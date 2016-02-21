@extends('TenantSync::landlord/layout')

@section('content')

<div id="ledger" v-cloak>

	@include('TenantSync::includes.accounting-stats')
	
	@include('TenantSync::includes.tables.most-expensive-property-table')

	@include('TenantSync::includes.tables.transactions-table')

</div>

@endsection



@section('scripts')
<script>
Vue.config.debug = true;

var vue = new Vue({

	el: '#app',

	events: {
		'transactions-updated': function() {
			this.$broadcast('transactions-updated');
		},

		'recurring-modal-generated': function(transaction) {
			this.$broadcast('recurring-modal-generated', transaction);
		},

		'delete-recurring': function(id) {
			this.$broadcast('delete-recurring', id);
		},

		'show-modal': function(modal) {
			this.$broadcast('show-modal', modal);
		},
	}
});

</script>
@endsection