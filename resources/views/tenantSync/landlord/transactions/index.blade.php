@extends('TenantSync::landlord/layout')
@section('heading')
<!-- Transactions -->
@endsection

@section('head')
	<meta id="user_id" value="{{ $user->id }}">
@endsection

@section('content')

<div id="ledger" v-cloak>
	<div class="card row">
		<div id="stats" class="col-sm-12">
			<h4 class="card-header">Overview</h4>
			<div class="col-sm-3 card-column">
				<p class="text-center">Net Income MTD</p>
				<p class="stat text-success text-center">
				{{
					$netIncome
				}}
				</p>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center">Monthly Recurring Expenses</p>
				<p class="stat text-primary text-center">
				@if($landlord->recurringTransactions)
				{{
					array_sum($landlord->recurringTransactions->map(function($recurring) 
						{
							return $recurring->transaction->amount;
						}
					)
					->toArray())
				}}
				@endif
				</p>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center">Total Expenses MTD</p>
				<p class="stat text-danger text-center">
				{{ 
					round(array_sum(
					$landlord->transactions
					->filter(function($transaction) {
						if($transaction->amount > 0)
						{
							return false;
						}
						return date('m', strtotime($transaction->date)) == date('m', time());
					})
					->pluck('amount')
					->toArray()
					), 2)
				}}
				</p>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center">Revenue  MTD</p>
				<p class="stat text-warning text-center">
				{{ 
					round(array_sum(
					$landlord->transactions
					->filter(function($transaction) {
						if($transaction->amount < 0)
						{
							return false;
						}
						return date('m', strtotime($transaction->date)) == date('m', time());
					})
					->pluck('amount')
					->toArray()
					), 2)
				}}
				</p>
			</div>
		</div>
	</div>
	
	@include('TenantSync::includes.tables.most-expensive-property-table')

	@include('TenantSync::includes.tables.transactions-table')
</div>




@endsection

@section('scripts')

<script>
Vue.config.debug =true;

	// Vue.filter('numeric', function (item, field, operator, value) {
	//   console.log(item);
	// })

	var vue = new Vue({

		el: '#ledger',

	// 	data: {

	// 		properties: [

	// 		],

	// 		numeral: window.numeral,
	// 	},


	// 	ready: function() {
	// 		// this.fetchTransactions(1, this.sortKey, this.reverse);
	// 		// this.fetchProperties();
	// 	},


	// 	methods: {

	// 		fetchProperties: function() {

	// 			this.$http.get('/landlord/properties/all')
	// 			.success(function(result) {
	// 				this.properties = result;
	// 			});
	// 		},
	// 	},


		// filters: {
		// 	numeric: function(array, field, operator, value ) {
		// 		console.log(array);
		// 		// return array.filter(function(item) {
		// 		// 	console.log(item);
		// 		// 	if (item.$value)
		// 		// 	{
		// 		// 		return math[operator](item.$value[field], value)  ? item : null;
		// 		// 	}
		// 		// });
		// 	}
		// }
	});

</script>

@endsection