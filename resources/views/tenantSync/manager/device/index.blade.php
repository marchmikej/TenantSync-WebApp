@extends('TenantSync::manager/layout')
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
							<div class="col-sm-8"><a href="/manager/maintenance/@{{ maintenance.id }}">@{{ maintenance.request }}</a></div>
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
							<div class="col-sm-4"><a href="/manager/device/@{{ message.device.id }}">@{{ message.device.property.address + ', ' + message.device.location }}</a></div>
							<div class="col-sm-8">@{{ message.body }}</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<property-manager-table user-role="manager" inline-template>
		<div class="row card">
			<div class="col-sm-12">
				<h4 class="card-header">
					Properties
				</h4>
				<!-- <div class="row table-heading">
					<div class="col-sm-5">Address</div>
					<div class="col-sm-2">ROI</div>
					<div class="col-sm-2">Devices</div>
					<div class="col-sm-2">Value</div>
					<div class="col-sm-1"></div>
				</div> -->

				<table-headers :columns="columns" :sort-key.sync="sortKey" :reverse.sync="reverse"></table-headers>
			
				<div class="table-body table-striped">
							
					<div v-for="property in properties | orderBy sortKey reverse" class="table-row row">
						<div class="col-sm-7"><a :href="'/'+ userRole +'/properties/' + property.id">@{{property.address + ', ' + property.city + ' ' + property.state}}</a></div>
						<div class="col-sm-2 text-danger">@{{ property.alarms }}</div>
						<div class="col-sm-2 text-warning">@{{ property.inactives }}</div>
						<div @click="showDevices($index)" class="col-sm-1 btn btn-clear icon icon-plus p-y-0"></div>

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
									<div class="col-sm-3"><a :href="'/'+ userRole +'/device/' + device.id">@{{ device.location }}</a></div>
									<div class="col-sm-2">$@{{ device.rent_amount }}</div>
									<div class="col-sm-2">@{{ device.contact_name ? device.contact_name : '-' }}</div>
									<div class="col-sm-2">@{{ device.contact_phone ? device.contact_phone : '-' }}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</property-manager-table>
</div>



@endsection

@section('scripts')

	<script>

	Vue.config.debug = true;

		var vue = new Vue({
			

			el: '#properties',


			data: {

				messages: {

				},

				maintenanceRequests: {

				},

				numeral: window.numeral,

			},


			ready: function() {
				var numeral = numeral;
				this.fetchMessages();
				this.fetchMaintenance();
			},


			methods: {

				fetchMessages: function() {
					this.$http.get('/manager/messages/all')
					.success(function(messages) {
						this.messages = messages;
					});
				},

				fetchMaintenance: function() {
					this.$http.get('/manager/maintenance/all')
					.success(function(maintenance) {
						this.maintenanceRequests = maintenance;
					});
				},

			}
		});
	</script>


@endsection