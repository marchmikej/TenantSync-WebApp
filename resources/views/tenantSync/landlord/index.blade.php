@extends('TenantSync::landlord/layout')

@section('content')
	<div>
		<div>
			<div class="row card">
				<div class="col-sm-12">
					<h4 class="card-header">Dashboard</h4>
			
					<div @click="showStats('alarms')" class="col-sm-3 card-column">
						<p class="text-center">Alarms</p>
						<p class="stat text-danger text-center">
							@{{ stats.alarms }}
						</p>
					</div>
			
					<div class="col-sm-3 card-column">
						<p class="text-center">Rent Paid MTD</p>
						<p class="stat text-success text-center">
							@{{ stats.paid_rent }}
						</p>
					</div>
			
					<div class="col-sm-3 card-column">
						<p class="text-center">Delinquency MTD</p>
						<p class="stat text-warning text-center">
							@{{ stats.deliquent_rent }}
						</p>
					</div>
					
					<div class="col-sm-3 card-column">
						<p class="text-center">Vacant Rent MTD</p>
						<p class="stat text-danger text-center">
							@{{ stats.vacant_rent }}
						</p>
					</div>
				</div>
			</div>
		</div>

		@include('TenantSync::includes.tables.devices-table')
	
	</div>

@endsection

@section('scripts')

<script>
Vue.config.debug = true;

var vue = new Vue({
	el: '#app',

	data: {
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

	methods: {
		fetchDevices: function() {
			this.$http.get('/api/devices')
				.success(function(devices) {
					this.devices = devices;
				});
		},

		fetchTransactions: function() {
			var data = {
				from: '-1 year',
			};

			this.$http.get('/api/transactions', data)
				.success(function(transactions) {
					this.transactions = transactions;
				});
		},

		fetchRentBills: function() {
			var data = {
				from: '-1 year',
			};

			this.$http.get('/api/rent-bills', data)
				.success(function(rentBills) {
					this.rentBills = rentBills;
				});
		},

		alarms: function() {
			var devices = _.filter(this.devices, function(device) {
				return device.alarm_id;
			});

			return devices.length;
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
});

</script>
@endsection
