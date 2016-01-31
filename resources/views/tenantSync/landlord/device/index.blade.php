@extends('TenantSync::landlord/layout')
@section('heading')
@endsection

@section('head')
	<meta id="user_id" value="{{ $user->id }}">
@endsection

@section('content')

<div id="properties" v-cloak>
	
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
							<div>
								Recent Messages
								<!-- <button @click="newMessage" class=" btn btn-clear p-y-0"><h3 class="m-a-0 text-primary icon icon-plus"></h3></button> -->
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
	
	@include('TenantSync::includes.tables.property-manager-table')

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
			},
		});
	</script>


@endsection