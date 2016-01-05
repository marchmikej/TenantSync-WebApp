@extends('TenantSync::landlord/layout')
@section('heading')
@endsection

@section('head')
	<meta id="user_id" value="{{ $user->id }}">
@endsection

@section('content')

<div id="properties">
	
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
					<div class="table-body table-striped">
						<div v-for="maintenance in maintenanceRequests" class="table-row row">
							<div class="col-sm-4">@{{ maintenance.device.property.address + ', ' + maintenance.device.location }}</div>
							<div class="col-sm-8"><a href="/landlord/maintenance/@{{ maintenance.id }}">@{{ maintenance.request }}</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>


			
		<div class="col-sm-6 p-l-md">
			<div class="card row">
				<div class="col-sm-12">
						<h3 class="card-header">
							Recent Messages
						</h3>
						<div class="row table-heading">
						<div class="col-sm-4">Unit</div>
						<div class="col-sm-8">Message</div>
					</div>
					<div class="table-body table-striped">
						<div v-for="message in messages" class="table-row row">
							<div class="col-sm-4"><a href="/landlord/device/@{{ message.device.id }}">@{{ message.device.property.address + ', ' + message.device.location }}</a></div>
							<div class="col-sm-8">@{{ message.body }}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row card">
			<div class="col-sm-12">
				<h4 class="card-header">
					Properties<a href="/landlord/properties/create"><button class=" btn btn-clear text-primary"><h4 class="m-a-0 icon icon-plus"></h4></button></a>
				</h4>
				<!-- <div class="row table-heading">
					<div class="col-sm-5">Address</div>
					<div class="col-sm-2">ROI</div>
					<div class="col-sm-2">Devices</div>
					<div class="col-sm-2">Value</div>
					<div class="col-sm-1"></div>
				</div> -->

				<div class="table-heading row">
					<div v-for="column in columns" @click="sortBy($index)" :class="[column.width, column.isSortable ? 'sortable' : '' ]">@{{ toTitleCase(column.name) }}<span :class="sortKeyClasses($index)"></span></div>
				</div>
			
				<div class="table-body table-striped">
							
					<div v-for="property in properties | orderBy sortKey reverse" class="table-row row">
						<div class="col-sm-7"><a href="/landlord/properties/@{{ property.id }}">@{{property.address + ', ' + property.city + ' ' + property.state}}</a></div>
						<div class="col-sm-2 text-danger">@{{ alarmsInProperty(property) }}</div>
						<div class="col-sm-2 text-warning">@{{ inactiveDevicesInProperty(property) }}</div>
						<div @click="showDevices(property.id)" class="col-sm-1 btn btn-clear icon icon-plus p-y-0"></div>

						<div v-show="property.showDevices" class="sub-table">
							<div class="table-heading row">
								<div class="col-sm-1 text-right"></div>
								<div class="col-sm-3">Location</div>
								<div class="col-sm-2">Rent</div>
								<div class="col-sm-2">Contact Name</div>
								<div class="col-sm-2">Contact phone</div>
							</div>
							<div v-for="device in property.devices" class="table-row row">	
									<div class="col-sm-1 text-right"><span class="fa fa-long-arrow-right"></span></div>
									<div class="col-sm-3"><a href="/landlord/device/@{{ device.id }}">@{{ device.location }}</a></div>
									<div class="col-sm-2">$@{{ device.rent_amount }}</div>
									<div class="col-sm-2">@{{ device.contact_name ? device.contact_name : '-' }}</div>
									<div class="col-sm-2">@{{ device.contact_phone ? device.contact_phone : '-' }}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
</div>



@endsection

@section('scripts')

	<script>

		var vue = new Vue({
			

			el: '#properties',


			data: {

				columns: [
					{
						name: 'address',
						width: 'col-sm-7',
						isSortable: false
					},
					{
						name: 'alarms',
						width: 'col-sm-2',
						isSortable: false
					},
					{
						name: 'inactive',
						width: 'col-sm-2',
						isSortable: false
					}
				],

				properties: {
					
				},

				messages: {

				},

				maintenanceRequests: {

				},

				numeral: window.numeral,

			},


			ready: function() {
				this.fetchProperties();
				var numeral = numeral;
				this.fetchMessages();
				this.fetchMaintenance();
			},


			methods: {

				fetchProperties: function() {
					this.$http.get('/landlord/properties/all')
						.success( function(properties) {
							this.properties = properties;
						})
						.error( function() {
							console.log('Error fetching properties');
						});
				},

				showDevices: function(id) {
					if (typeof this.properties[id].showDevices === 'undefined')
					{
						this.$set('properties[' + id + '].showDevices', true);
					}
					else
					{
						this.properties[id].showDevices = !this.properties[id].showDevices;
					}
					
				},

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

				alarmsInProperty: function(property) {
					return _.filter(property.devices, function(device) { device.alarm_id != 0 ;}).length;
				},

				inactiveDevicesInProperty: function(property) {
					return _.filter(property.devices, function(device) { device.status != 'active' ;}).length;
				}
			},


			// filters: {
			// 	numeric: function(array, field, operator, value ) {
			// 		return array.filter(function(item) {
			// 			console.log(item);
			// 			if (item.$value)
			// 			{
			// 				return math[operator](item.$value[field], value)  ? item : null;
			// 			}
			// 		});
			// 	}
			// }
		});
	</script>


@endsection