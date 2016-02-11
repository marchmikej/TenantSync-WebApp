Vue.component('ytd-stats', {

	data: function() {
		return {
			properties: [],
			
			transactions: [],

			rentBills: [],
		};
	},

	computed: {
		stats: function() {
			return {
				roi: this.averageRoi(),
				paid_rent: this.paidRent(),
				deliquent_rent: this.deliquentRent(),
				vacant_rent: this.vacantRent(),
			}
		},
	},

	ready: function() {
		this.fetchRentBills();

		this.fetchProperties();
	},

	methods: {
		fetchRentBills: function() {
			var data = {
				from: '-1 year',
			};

			this.$http.get('/api/rent-bills', data)
				.success(function(rentBills) {
					this.rentBills = rentBills;
				});
		},

		fetchProperties: function() {
			var data = {
				set: ['transactions', 'roi'] 
			};

			return this.$http.get('/api/properties', data)
				.success(function(properties) {
					this.properties = properties;
					this.getTransactions();
				});
		},

		getTransactions: function() {
			var transactions = _.pluck(this.properties, 'transactions');

			this.transactions = _.flatten(transactions, true);
		},

		averageRoi: function() {
			var roiSum = _.reduce(this.properties, function(initial, property) {
				return initial + Number(property.roi);
			}, 0);

			var roiAsFraction = roiSum / this.properties.length;

			return numeral(roiAsFraction).format('0%');
		},

		paidRent: function() {
			var transactions = _.filter(this.transactions, function(transaction) {
				var from = Number(moment().subtract(1, 'year').format('X'));

				var transactionDate = Number(moment(transaction.date).format('X'));

				if(from <= transactionDate && transaction.payable_type == 'device') {
					return true;
				}

				return false;
			});

			return _.reduce(transactions, function(initial, transaction) {
				return initial + Number(transaction.amount);
			}, 0);
		},

		deliquentRent: function() {
			var totalBills = _.reduce(this.rentBills, function(initial, bill) {
				return initial + Number(bill.bill_amount);
			}, 0);

			return totalBills - this.paidRent();
		},

		vacantRent: function() {
			var bills = _.filter(this.rentBills, function(bill) {
				return bill.vacant;
			});

			return _.reduce(bills, function(initial, bill) {
				return initial + Number(bill.bill_amount);
			}, 0);
		},

	},
})
