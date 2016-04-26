@extends('TenantSync::manager/layout')

@section('content')

<div v-cloak>
	
	<div class="row">
		@include('TenantSync::includes.recent-maintenance')
			
		@include('TenantSync::includes.recent-messages')
	</div>
	
	@include('TenantSync::includes.tables.property-manager-table')

</div>



@endsection

@section('scripts')

	<script>

		Vue.config.debug = true;

		var vue = new Vue({
			

			el: '#app',

			data: {

				messages: [],

				maintenanceRequests: [],

				properties: [],

				numeral: window.numeral,

				forms: {
					message: new TSForm({
						device_id: [],
						body: '',
						search: null,
					})
				},

			},


			ready: function() {
				var numeral = numeral;
				this.fetchMessages();
				this.fetchMaintenance();
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
					this.$http.get('/landlord/messages/all')
					.success(function(messages) {
						this.messages = messages;
					});
				},

				fetchMaintenance: function() {
					this.$http.get('/landlord/maintenance/all')
					.success(function(maintenance) {
						this.maintenanceRequests = maintenance;
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
					this.$broadcast('show-modal');
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
		});
	</script>


@endsection