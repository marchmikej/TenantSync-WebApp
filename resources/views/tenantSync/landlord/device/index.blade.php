@extends('TenantSync::landlord/layout')
@section('heading')
@endsection

@section('head')
	<meta id="user_id" value="{{ $user->id }}">
@endsection

@section('content')

<div v-cloak>
	
	<div class="row">
		<div class="col-sm-6 p-r-md">
			<div class="card row">
				<div class="col-sm-12">
					<h3 class="card-header">
						Recent Maintenance
					</h3>
					<div class="row table-heading">
						<div class="col-sm-4">Unit</div>
						<div class="col-sm-8">Request</div>
					</div>
					<div class="table-body table-striped scrollable row">
						<div v-for="maintenance in maintenanceRequests | orderBy 'created_at' -1" class="table-row col-sm-12">
							<div class="col-sm-4">
								@{{ maintenance.device.property.address + ', ' + maintenance.device.location }}
							</div>
							<div class="col-sm-8">
								<a href="/landlord/maintenance/@{{ maintenance.id }}">
									@{{ maintenance.request }}
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


			
		<div class="col-sm-6 p-l-md">
			<div class="card row">
				<div class="col-sm-12">

						<h3 class="card-header">
							<div>
								Recent Messages
								<button @click="newMessage()" class=" btn btn-clear p-y-0">
									<h3 class="m-a-0 text-primary icon icon-plus"></h3>
								</button>
							</div>
						</h3>
						
						<div class="row table-heading">
						<div class="col-sm-4">Unit</div>
						<div class="col-sm-8">Message</div>
					</div>
					<div class="table-body table-striped">
						<div v-for="message in messages | orderBy 'created_at' -1" class="table-row row">
							<div class="col-sm-4"><a href="/landlord/device/@{{ message.device.id }}">@{{ message.device.property.address + ', ' + message.device.location }}</a></div>
							<div class="col-sm-8">@{{ message.body }}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<modal>
		<form id="message-form" class="form form-horizontal" slot="one">
			
			<div  class="form-group">
				<label class="control-label col-sm-3" for="payable">Send To</label>
				<div class="col-sm-9">
					<input v-model="forms.message.search" class="form-control col-sm-4" type="text" placeholder="Search..."/>
					<label class="control-label p-l">@{{ 'Devices selected: '+ _.size(forms.message.device_ids) }}</label>
				</div>
			</div>
		
			<div class="well col-sm-9 col-sm-offset-3 scrollable" style="max-height: 150px;">
				<ul style="list-style-type: none;">
					<li 
						@click=""
						v-if="user().role == 'landlord'" 
					>
						<label>
							<input 
								@click.stop="toggleAllDevices($event)" 
								type="checkbox" 
							>
							All
						</label>
					</li>
					<li 
						v-for="property in properties | filterBy forms.message.search" 
						class="col-sm-12"
					>
						<label>
							<input 
								@click.stop="toggleDevicesInProperty($event)" 
								type="checkbox" 
								:data-name="'property-'+ property.id"
							>
							@{{ property.address }}
						</label>

						<ul style="list-style-type: none;">
							<li 
								v-for="device in property.devices" 
							>
								<input 
									@click.stop="toggleDeviceForMessage($event)"
									type="checkbox" 
									:data-id="device.id"
									:checked="_.contains(forms.message.device_ids, device.id)"
								>
								@{{ device.location }}
							</li>
						</ul>
					</li>
				</ul>
			</div>

			<ts-textarea
				:name="message"
				:display="'Message'"
				:form="forms.message"
				:input.sync="forms.message.message"
			>
			</ts-textarea>

			<button 
				@click.prevent="sendMessage()" 
				class="col-sm-4 col-sm-offset-8 btn btn-primary form-control"
			>
				Send
			</button>

		</form>
	</modal>
	
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
						device_ids: [],
						message: '',
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
					this.forms.message.device_ids = [],
					this.forms.message.message = '',
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
					this.forms.message.device_ids.push(Number(element.dataset.id));

					return element.checked = true;
				},

				removeDeviceFromMessage: function(element) {
					this.forms.message.device_ids.$remove(Number(element.dataset.id));

					element.checked = false;
				},
			},
		});
	</script>


@endsection