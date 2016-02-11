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
				@{{ stats.net_income }}
				</p>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center">Monthly Recurring Expenses</p>
				<p class="stat text-primary text-center">
				@{{ stats.recurring }}
				</p>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center">Total Expenses MTD</p>
				<p class="stat text-danger text-center">
				@{{ stats.expenses }}
				</p>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center">Revenue  MTD</p>
				<p class="stat text-warning text-center">
				@{{ stats.revenue }}
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
	Vue.config.debug = true;

	var vue = new Vue({

		el: '#app',

		data: {

			transactions: [],

			recurringTransactions: [],
		},

		ready: function() {
			this.fetchTransactions();
		},

		computed: {
			stats: function() {
				return {
					net_income: this.netIncome(),
					expenses: this.expenses(),
					recurring: this.recurring(),
					revenue: this.revenue(),
				}
			}
		},

		methods: {
			fetchTransactions: function() {
				var data = {
					from: '-1 month',
				};

				this.$http.get('/api/transactions', data)
					.success(function(transactions) {
						this.transactions = transactions;
					});
			},

			fetchRecurringTransactions: function() {
				this.recurringTransactions = [];
			},

			netIncome: function() {
				return _.reduce(this.transactions, function(initial, transaction) {
					return initial + Number(transaction.amount);
				}, 0);
			},

			expenses: function() {
				var transactions = _.filter(this.transactions, function(transaction) {
					return Number(transaction.amount) < 0;
				});

				return _.reduce(transactions, function(initial, transaction) {
					return initial + Number(transaction.amount);
				}, 0);
			},

			recurring: function() {
				return _.reduce(this.recurringTransactions, function(initial, transaction) {
					return initial + Number(transaction.amount);
				}, 0);
			},

			revenue: function() {
				var transactions = _.filter(this.transactions, function(transaction) {
					return Number(transaction.amount) > 0;
				});

				return _.reduce(transactions, function(initial, transaction) {
					return initial + Number(transaction.amount);
				}, 0);
			},
		},
	});

</script>

@endsection