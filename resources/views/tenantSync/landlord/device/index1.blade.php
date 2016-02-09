@extends('TenantSync::landlord/layout')
@section('heading')
<h4 class="text-primary"><strong>Property Manager</strong></h4>
@endsection

@section('head')
	<meta id="user_id" value="{{ $user->id }}">
@endsection

@section('content')

<div id="properties">


	<div class="row card">
		<div class="col-sm-12">
			<div class="maintenance col-sm-6 p-r-md b-r">
				<table class="table table-striped" >
					<h3 class="text-info">
						Recent Maintenance
					</h3>
					<thead>
						<th class="col-sm-2">Unit</th>
						<th>Request</th>
					</thead>
					<tbody>
						<tr v-for="maintenance in maintenanceRequests">
							<td><a href="/landlord/device/@{{ maintenance.device_id }}">@{{maintenance.device.location}}</a></td>
							<td>@{{maintenance.request}}</td>
						</tr>
					</tbody>
				</table>
				<!-- <div class="table-body" style="height: 50vh; overflow: scroll;">
					<div v-for="maintenance in maintenanceRequests" class="table-row row">
						<div class="col-sm-2"><a href="/landlord/device/@{{ maintenance.device_id }}">@{{ maintenance.device.location }}</a></div>
						<div class="col-sm-10">@{{ maintenance.request }}</div>
					</div>
				</div> -->
			</div>
			<div class="messages col-sm-6 p-l-md">
				<table class="table table-striped" >
					<h3 class="text-info">
						Recent Messages
					</h3>
					<thead>
						<th class="col-sm-2">Unit</th>
						<th>Body</th>
					</thead>
					<tbody>
						<tr v-for="message in messages">
							<td><a href="/landlord/device/@{{ message.device_id }}">@{{message.device.location}}</a></td>
							<td>@{{message.body}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="row card">
		<div class="col-sm-12">
			<div class="col-sm-12">
				<h3 class="text-info">Properties</h3>
					<div class="row table-heading">
						<div class="col-sm-5">Address</div>
						<div class="col-sm-2">ROI</div>
						<div class="col-sm-2">Devices</div>
						<div class="col-sm-2">Value</div>
						<div class="col-sm-1"></div>
					</div>
				
					<div class="table-body" v-for="property in properties">
						
				
						<div class="table-row row">
							<div class="col-sm-5"><a href="/landlord/properties/@{{ property.id }}">@{{property.address + ', ' + property.city + ' ' + property.state}}</a></div>
							<div class="col-sm-2">@{{ numeral(property.roi).format('0.0 %') }}</div>
							<div class="col-sm-2">@{{ property.devices.length }}</div>
							<div class="col-sm-2">$@{{numeral(property.value).format('0,0.00')}}</div>
							<div @click="showDevices(property.id)" class="col-sm-1 btn btn-clear icon icon-plus p-y-0"></div>
						</div>
				
				
						<div v-show="property.showDevices" class="sub-table">
							<div v-for="device in property.devices" class="table-row row ">	
									<div class="col-sm-2 text-right"></div>
									<div class="col-sm-3"><a href="">@{{ device.location }}</a></div>
									<div class="col-sm-2"></div>
							</div>
						</div>
				
				
					</div>
			</div>


		</div>
	</div>

	
	<!-- <pre>@{{ $data | json }}</pre> -->
</div>



@endsection

@section('scripts')

	<script>

		var vue = new Vue({
			

			el: '#app',


			data: {

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