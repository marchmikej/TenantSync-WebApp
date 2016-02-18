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
			<div @click="toggleStat('recurring')" class="col-sm-3 card-column">
				<p class="text-center">Monthly Recurring Expenses</p>
				<p class="stat clickable text-primary text-center">
				@{{ stats.recurring }}
				</p>
			</div>
			<div @click="toggleStat('expenses')" class="col-sm-3 card-column">
				<p class="text-center">Total Expenses MTD</p>
				<p class="stat clickable text-danger text-center">
				@{{ stats.expenses }}
				</p>
			</div>
			<div @click="toggleStat('revenue')" class="col-sm-3 card-column">
				<p class="text-center">Revenue  MTD</p>
				<p class="stat clickable text-warning text-center">
				@{{ stats.revenue }}
				</p>
			</div>
		</div>
	</div>

	<modal id="stat-modal">
		<div class="modal-wrapper">
			<div v-if="showStat.recurring">
				<div v-if="stats.recurring == 0">
					No results found.	
				</div>
			
				<div v-if="stats.recurring != 0" class="h-md col-sm-12 scrollable">
			
					<div class="table-heading row">
						<div class="col-sm-2">
							Amount
						</div>
			
						<div class="col-sm-5">
							Address
						</div>
			
						<div class="col-sm-3">
							Schedule
						</div>
					</div>
			
					<div class="table-body table-striped">
						<div v-for="transaction in recurringTransactions" class="table-row row">
							<div :class="transaction.amount > 0 ? 'text-success' : 'text-danger'" class="col-sm-2">
								@{{ transaction.amount }}
							</div>		
							<div class="col-sm-5">
								<!-- <a :href="'/'+ user().role +'/'device'/'+ transaction.payable_id"> -->
									@{{ transaction.address }}
								<!-- </a> -->
							</div>		
							<div class="col-sm-3">
								@{{ 'Every '+ transaction.schedule }}
							</div>
							<div class="col-sm-2">
								<button @click="generateRecurringModal(transaction.id)" class="btn btn-clear p-a-0">
									<span class="text-primary icon icon-edit"></span>
								</button>
								<button @click="deleteRecurringTransaction(transaction.id)" class="btn btn-clear p-y-0 p-r-0">
									<span class="text-danger icon icon-cross"></span>
								</button>
							</div>
							</div>	
						</div>
					</div>
				
				</div>
			</div>
			
			<div v-if="showStat.expenses">
				<div v-if="stats.expenses == 0">
					No results found.	
				</div>
			
				<div v-if="stats.expenses != 0" class="h-md col-sm-12 scrollable">
					<div class="table-heading row">
						<div class="col-sm-6">
							Address
						</div>
			
						<div class="col-sm-3 col-sm-offset-3">
							Amount
						</div>
					</div>
			
					<div class="table-body table-striped">
						<div v-for="transaction in expenseTransactions()" class="table-row row">
							<div class="col-sm-6">
								<!-- <a :href="'/'+ user().role +'/device/'+ device.id"> -->
									@{{ transaction.address }}
								<!-- </a> -->
							</div>		
							<div class="col-sm-3 col-sm-offset-3 text-danger">
								@{{ transaction.amount }}
							</div>		
						</div>
					</div>
			
				</div>
			</div>
			
			<div v-if="showStat.revenue">
				<div v-if="stats.revenue == 0">
					No results found.	
				</div>
			
				<div v-if="stats.revenue != 0" class="h-md col-sm-12 scrollable">
					<div class="table-heading row">
						<div class="col-sm-6">
							Address
						</div>
			
						<div class="col-sm-3 col-sm-offset-3">
							Amount
						</div>
					</div>
			
					<div class="table-body table-striped">
						<div v-for="transaction in revenueTransactions()" class="table-row row">
							<div class="col-sm-6">
								<!-- <a :href="'/'+ user().role +'/device/'+ rentBill.device_id"> -->
									@{{ transaction.address }}
								<!-- </a> -->
							</div>		
							<div :class="transaction.amount > 0 ? 'text-success' : 'text-danger'" class="col-sm-3 col-sm-offset-3">
								@{{ transaction.amount }}
							</div>		
						</div>
					</div>
				</div>
			</div>
		</div>
	</modal>
	
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
		showStat: {
			net_income: false,
			expenses: false,
			recurring: false,
			revenue: false,
		},

		forms: {
			recurringTransaction: {}
		},

		transactions: [],

		recurringTransactions: [],
	},

	ready: function() {
		this.fetchTransactions();
		this.fetchRecurringTransactions();
	},

	events: {
		'modal-hidden': function() {
			this.hideStats();
		},

		'transactions-updated': function() {
			this.fetchTransactions();
			this.fetchRecurringTransactions();
		}
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
				set: 'address',
			};

			this.$http.get('/api/transactions', data)
				.success(function(transactions) {
					this.transactions = transactions;
				});
		},

		fetchRecurringTransactions: function() {
			var data = {
				set: ['address']
			};

			this.$http.get('/api/transactions/recurring', data)
				.success(function(recurringTransactions) {
					this.recurringTransactions = recurringTransactions;
				});
		},

		toggleStat: function(stat) {
			this.showStat[stat] = !this.showStat[stat];

			this.$broadcast('show-modal', 'stat-modal');
		},

		hideStats: function() {
			for(var i = 0; i < _.size(this.showStat); i++) {
				var key = Object.keys(this.showStat)[i];

				this.showStat[key] = false;
			}
		},

		generateRecurringModal: function(id) {
			this.$broadcast('recurring-modal-generated', _.find(this.recurringTransactions, {id: id}));
			this.$broadcast('show-modal', 'recurring-modal');
		},

		deleteRecurringTransaction: function(id) {
			this.$broadcast('delete-recurring', id);
		},

		netIncome: function() {
			return _.reduce(this.transactions, function(initial, transaction) {
				return initial + Number(transaction.amount);
			}, 0);
		},

		expenseTransactions: function() {
			return _.filter(this.transactions, function(transaction) {
				return Number(transaction.amount) < 0;
			});
		},

		expenses: function() {
			var transactions =  this.expenseTransactions();

			return _.reduce(transactions, function(initial, transaction) {
				return initial + Number(transaction.amount);
			}, 0);
		},

		recurring: function() {
			return _.reduce(this.recurringTransactions, function(initial, transaction) {
				return initial + Number(transaction.amount);
			}, 0);
		},

		revenueTransactions: function() {
			return _.filter(this.transactions, function(transaction) {
				return Number(transaction.amount) > 0;
			});
		},

		revenue: function() {
			var transactions = this.revenueTransactions();

			return _.reduce(transactions, function(initial, transaction) {
				return initial + Number(transaction.amount);
			}, 0);
		},
	},
});

</script>

@endsection