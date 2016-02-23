Vue.component('accounting-stats', {
	
	data: function() {
		return {
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
		};
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
				set: ['address'],
			};

			this.$http.get('/api/transactions/recurring', data)
				.success(function(recurringTransactions) {
					this.recurringTransactions = recurringTransactions;
				});
		},

		toggleStat: function(stat) {
			this.showStat[stat] = !this.showStat[stat];

			this.$dispatch('show-modal', 'stat-modal');
		},

		hideStats: function() {
			for(var i = 0; i < _.size(this.showStat); i++) {
				var key = Object.keys(this.showStat)[i];

				this.showStat[key] = false;
			}
		},

		generateRecurringModal: function(id) {
			this.$dispatch('recurring-modal-generated', _.find(this.recurringTransactions, {id: id}));
			this.$dispatch('show-modal', 'recurring-modal');
		},

		deleteRecurringTransaction: function(id) {
			this.$dispatch('delete-recurring', id);
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
})