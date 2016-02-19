@extends('TenantSync::manager/layout')

@section('head')
	<meta id="user_id" value="{{ $user->id }}">
@endsection

@section('content')

<div id="properties" v-cloak>
	
	<div class="row">

		<recent-maintenance></recent-maintenance>
			
		<recent-messages></recent-messages>
		
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
					this.$http.get('/manager/messages/all', {limit: 5})
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