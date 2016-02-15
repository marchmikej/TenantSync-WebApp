Vue.component('ytd-stats', {

	data: function() {
		return {
			showStat: {
				paid_rent: false,
				deliquent_rent: false,
				vacant_rent: false,
			},

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

	events: {
		'modal-hidden': function() {
			this.hideStats();
		}
	},

	ready: function() {
		this.fetchRentBills();

		this.fetchTransactions();

		this.fetchProperties();
	},

	methods: {
		fetchRentBills: function() {
			var data = {
				from: '-1 year',

				with: ['device'],
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
				});
		},

		fetchTransactions: function() {
			var data = {
				from: '-1 year',

				set: ['address']
			};

			this.$http.get('/api/transactions', data)
				.success(function(transactions) {
					this.transactions = transactions;
				});
		},

		toggleStat: function(stat) {
			this.showStat[stat] = !this.showStat[stat];

			this.$broadcast('show-modal');
		},

		hideStats: function() {
			for(var i = 0; i < _.size(this.showStat); i++) {
				var key = Object.keys(this.showStat)[i];

				this.showStat[key] = false;
			}
		},

		averageRoi: function() {
			var roiSum = _.reduce(this.properties, function(initial, property) {
				return initial + Number(property.roi);
			}, 0);

			var roiAsFraction = roiSum / this.properties.length;

			return numeral(roiAsFraction).format('0%');
		},

		paidRentTransactions: function() {
			return _.filter(this.transactions, function(transaction) {
				var from = Number(moment().subtract(1, 'month').format('X'));

				var transactionDate = Number(moment(transaction.date).format('X'));

				if(from < transactionDate && transaction.payable_type == 'TenantSync\\Models\\Device') {
					return true;
				}

				return false;
			});
		},

		paidRent: function() {
			var transactions = this.paidRentTransactions();

			return _.reduce(transactions, function(initial, transaction) {
				return initial + Number(transaction.amount)  ;
			}, 0);
		},

		deliquentDevices: function() {
			var deviceListWithDuplicates = _.pluck(this.rentBills, 'device');

			var devices = [];

			_.each(deviceListWithDuplicates, function(device) {
				if(_.find(devices, {'id': device.id})) {
					return false;
				}

				return devices.push(device);
			});

			_.each(devices, function(device) {
				var rentBills = _.where(this.rentBills, {'device_id': device.id});

				var rentPayments = _.where(this.paidRentTransactions(), {'payable_id': device.id});

				var rentBillTotal = _.reduce(rentBills, function(initial, bill) {
					return initial + Number(bill.bill_amount);
				}, 0);

				var rentPaymentTotal = _.reduce(rentPayments, function(initial, payment) {
					return initial + Number(payment.amount);
				}, 0);

				if(rentBillTotal > rentPaymentTotal) {
					device.balance_due = rentBillTotal - rentPaymentTotal;
				}
			}.bind(this));

			return devices;
		},

		deliquentRent: function() {
			var totalBills = _.reduce(this.rentBills, function(initial, bill) {
				return initial + Number(bill.bill_amount);
			}, 0);

			return totalBills - this.paidRent();
		},

		vacantRentBills: function() {
			return _.filter(this.rentBills, function(bill) {
				return bill.vacant;
			});
		},

		vacantRent: function() {
			var bills = this.vacantRentBills();

			return _.reduce(bills, function(initial, bill) {
				return initial + Number(bill.bill_amount);
			}, 0);
		},
	},
})
