Vue.component('recent-messages', {

		data: function() {
			return {
				messages: [],

				properties: [],

				numeral: window.numeral,

				forms: {
					message: new TSForm({
						device_id: [],
						body: '',
						search: null,
					})
				},
			};
		},

		ready: function() {
			this.fetchMessages();
			this.fetchProperties();
		},

		events: {
			'modal-hidden': function() {
				this.forms.message.device_id = [],
				this.forms.message.body = '',
				this.forms.message.search = null
			}
		},

		methods: {

			fetchMessages: function() {
				var data = {
					limit: 5,
					with: ['device']
				};

				this.$http.get('/api/messages', data)
				.success(function(messages) {
					this.messages = messages;
				});
			},

			fetchProperties: function() {
				var data = {
					with: ['devices']
				};

				this.$http.get('/api/properties', data)
					.success(function(properties) {
						this.properties = properties;
					});
			},

			newMessage: function() {
				this.$broadcast('show-modal', 'message-modal');
			},

			sendMessage: function() {
				TS.post('/api/messages', this.forms.message)
					.then(function(response) {
						swal('Success!', 'Your message has been sent');
						this.$broadcast('hide-modal');
					}.bind(this));
			},

			toggleAllDevices: function(event) {
				if(event.target.checked) {
					$('[data-name^=property').each(function(index, element) {
					
						if(!element.checked) {
							element.click();
						}

						return true;
					});

					return true;
				}
				
				$('#message-form input[type="checkbox"]').each(function(index, element) {
					this.removeDeviceFromMessage(element);
				}.bind(this));
			},

			toggleDevicesInProperty: function(event) {
				var checkbox = event.target;

				var selector = checkbox.parentElement.parentElement;

				$(selector).find(':checkbox').each(function(index, element) {
					if(element.dataset.name == event.target.dataset.name) {
						return true;
					}

					if(event.target.checked === true) {
						if(!element.checked) {
							this.addDeviceToMessage(element);
						}

						return true;
					}

					this.removeDeviceFromMessage(element);
				}.bind(this));
			},

			toggleDeviceForMessage: function(event) {
				var element = event.target;

				if(element.checked) {
					this.addDeviceToMessage(element);

					return true;
				}

				this.removeDeviceFromMessage(element);
			},

			addDeviceToMessage: function(element) {
				this.forms.message.device_id.push(Number(element.dataset.id));

				return element.checked = true;
			},

			removeDeviceFromMessage: function(element) {
				this.forms.message.device_id.$remove(Number(element.dataset.id));

				element.checked = false;
			},
		},
})