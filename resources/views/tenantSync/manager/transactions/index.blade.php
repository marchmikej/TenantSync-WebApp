@extends('TenantSync::manager/layout')
@section('heading')
<!-- Transactions -->
@endsection

@section('head')
	<meta id="user_id" value="{{ $manager->landlord->id }}">
@endsection

@section('content')

<div id="ledger">
	<div class="row">
		<div class="col-sm-12 card">
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
				@if($manager->landlord->recurringTransactions)
				{{
					array_sum($manager->landlord->recurringTransactions->map(function($recurring) 
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
					collect($manager->transactions())
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
					collect($manager->transactions())
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

	var vue = new Vue({

		el: '#app',

		methods: {

			fetchProperties: function() {
				this.$http.get('/manager/properties/all')
				.success(function(properties) {
					this.properties = properties;
				});
			},
		},
	});

</script>

@endsection