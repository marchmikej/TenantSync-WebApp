@extends('TenantSync::manager/layout')

@section('content')
<div v-cloak>
	<div class="row card">
		<div class="col-sm-12">
			<h4 class="card-header">Dashboard</h4>
	
			<div class="col-sm-6 col-md-3 card-column">
				<p class="text-center">Alarms</p>
				<p class="stat text-danger text-center">
					@{{ stats.alarms }}
				</p>
			</div>
	
			<div @click="toggleStat('paid_rent')" class="col-sm-6 col-md-3 card-column">
				<p class="text-center">Rent Paid MTD</p>
				<p class="stat clickable text-success text-center">
					@{{ money(stats.paid_rent) }}
				</p>
			</div>
	
			<div @click="toggleStat('deliquent_rent')" class="col-sm-6 col-md-3 card-column">
				<p class="text-center">Delinquency MTD</p>
				<p class="stat clickable text-warning text-center">
					@{{ money(stats.deliquent_rent) }}
				</p>
			</div>
			
			<div @click="toggleStat('vacant_rent')" class="col-sm-6 col-md-3 card-column">
				<p class="text-center">Vacant Rent MTD</p>
				<p class="stat clickable text-danger text-center">
					@{{ money(stats.vacant_rent) }}
				</p>
			</div>
		</div>
	</div>

	<modal>
		<div slot="one">
			<div v-if="showStat.paid_rent">
				<div v-if="stats.paid_rent == 0">
					No results found.	
				</div>

				<div v-if="stats.paid_rent != 0" class="h-md col-sm-12 scrollable-y">

					<div class="table-heading row">
						<div class="col-sm-3">
							Amount
						</div>

						<div class="col-sm-6">
							Address
						</div>

						<div class="col-sm-3">
							Date
						</div>
					</div>

					<div class="table-body table-striped">
						<div v-for="transaction in paidRentTransactions()" class="table-row row">
							<div :class="transaction.amount > 0 ? 'text-success' : 'text-danger'" class="col-sm-3">
								@{{ money(transaction.amount) }}
							</div>		
							<div class="col-sm-6">
								<a :href="'/'+ user().role +'/device/'+ transaction.payable_id">
									@{{ transaction.address }}
								</a>
							</div>		
							<div class="col-sm-3">
								@{{ transaction.date }}
							</div>		
						</div>
					</div>
				
				</div>
			</div>
			
			<div v-if="showStat.deliquent_rent">
				<div v-if="stats.deliquent_rent == 0">
					No results found.	
				</div>

				<div v-if="stats.deliquent_rent != 0" class="h-md col-sm-12 scrollable-y">
					<div class="table-heading row">
						<div class="col-sm-6">
							Address
						</div>

						<div class="col-sm-3 col-sm-offset-3">
							Balance Due
						</div>
					</div>

					<div class="table-body table-striped">
						<div v-for="device in deliquentDevices()" class="table-row row">
							<div class="col-sm-6">
								<a :href="'/'+ user().role +'/device/'+ device.id">
									@{{ device.address }}
								</a>
							</div>		
							<div class="col-sm-3 col-sm-offset-3 text-danger">
								@{{ money(device.balance_due) }}
							</div>		
						</div>
					</div>

				</div>
			</div>

			<div v-if="showStat.vacant_rent">
				<div v-if="stats.vacant_rent == 0">
					No results found.	
				</div>

				<div v-if="stats.vacant_rent != 0" class="h-md col-sm-12 scrollable-y">
					<div class="table-heading row">
						<div class="col-sm-6">
							Address
						</div>

						<div class="col-sm-3 col-sm-offset-3">
							Amount
						</div>
					</div>

					<div class="table-body table-striped">
						<div v-for="bill in vacantRentBills()" class="table-row row">
							<div class="col-sm-6">
								<a :href="'/'+ user().role +'/device/'+ bill.device_id">
									@{{ bill.address }}
								</a>
							</div>		
							<div class="col-sm-3 col-sm-offset-3 text-danger">
								@{{ money(bill.bill_amount) }}
							</div>		
						</div>
					</div>

				</div>
			</div>
		</div>
	</modal>
	
	<devices-table inline-template>
		@include('TenantSync::includes.tables.devices-table')
	</devices-table>

</div>
@endsection

@section('scripts')
<script>
Vue.config.debug = true;

var vue = new Vue({
	el: '#app',

	data: {
		showStat: {
			paid_rent: false,
			deliquent_rent: false,
			vacant_rent: false,
		},

		devices: [],

		transactions: [],

		rentBills: [],
	},

	computed: {
		stats: function() {
			return {
				alarms: this.alarms(),
				paid_rent: this.paidRent(),
				deliquent_rent: this.deliquentRent(),
				vacant_rent: this.vacantRent(),
			};
		}
	},

	ready: function() {
		this.fetchDevices();
		this.fetchTransactions();
		this.fetchRentBills();
	},

	events: {
		'modal-hidden': function() {
			this.hideStats();
		}
	},

	methods: {
		fetchDevices: function() {
			this.$http.get('/api/devices')
				.success(function(devices) {
					this.devices = devices;
				});
		},

		fetchTransactions: function() {
			var data = {
				from: '-1 month',
				set: ['address']
			};

			this.$http.get('/api/transactions', data)
				.success(function(transactions) {
					this.transactions = transactions;
				});
		},

		fetchRentBills: function() {
			var data = {
				with: ['device'],
				from: '-1 month',
			};

			this.$http.get('/api/rent-bills', data)
				.success(function(rentBills) {
					this.rentBills = rentBills;
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

		alarms: function() {
			var devices = _.filter(this.devices, function(device) {
				return device.alarm_id;
			});

			return devices.length;
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
				return initial + Number(transaction.amount);
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

			devices = _.filter(devices, function(device) {
				return device.balance_due;
			});

			return devices;
		},

		deliquentRent: function() {
			var totalBills = _.reduce(this.rentBills, function(initial, bill) {
				return initial + Number(bill.bill_amount);
			}, 0);

			var deliquentRent = totalBills - this.paidRent();

			return deliquentRent > 0 ? deliquentRent : 0;
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
});
</script>
@endsection
