@extends('TenantSync::landlord/layout')
@section('heading')
<!-- Transactions -->
@endsection

@section('head')
	<meta id="user_id" value="{{ $user->id }}">
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
	
	<div class="row card">
		<div class="col-sm-12">

			<h3 class="card-header m-t-0">Most Expensive</h3>
			<div class="table-heading row">
				<div class="col-sm-8">Address</div>
				<div class="col-sm-2">Expenses</div>
				<div class="col-sm-2">Net Income</div>
			</div>
			<div class="table-body table-striped">
				<div v-for="property in properties" class="table-row row">
					<div class="col-sm-8"><a href="/landlord/properties/@{{ property.id }}">@{{property.address + ', ' + property.city + ' ' + property.state}}</a></div>
					<div class="col-sm-2 text-danger">$@{{ numeral(property.totalExpenses).format('0,0.00') }}</div>
					<div class="col-sm-2">$@{{ numeral(property.netIncome).format('0,0.00') }}</div>
				</div>
			</div>

		</div>	
	</div>

			<div class="card row">
				<div class="col-sm-12">
					<h3 class="card-header">
						Transactions<button @click="generateModal()" class=" btn btn-clear text-primary p-y-0"><h3 class="m-a-0 icon icon-plus"></h3></button>
					</h3>
					<div class="row table-heading">
						<div class="col-sm-2">Amount</div>
						<div class="col-sm-2">Applied To</div>
						<div class="col-sm-6">Description</div>
						<div class="col-sm-1">Date</div>
						<div class="col-sm-1"></div>
						
					</div>
					<div class="table-body table-striped">
						<div v-for="transaction in transactions | orderBy 'date' -1" class="table-row row">
							<div :class="transaction.amount > 0 ? 'text-success' : 'text-danger'" class="col-sm-2"><strong>@{{ transaction.amount }}</strong></div>
							<div class="col-sm-2 overflow-hide">@{{ getTransactionPayable(transaction) }}</div>
							<div class="col-sm-6 overflow-hide">@{{ transaction.description }}</div>
							<div class="col-sm-1">@{{ (transaction.date.substring(5) + '/' + transaction.date.substring(2, 4)).replace('-', '/') }}</div>
							<div class="col-sm-1">
								<button @click=" generateModal( transaction.id )" class="btn btn-clear p-a-0"><span class="text-primary icon icon-edit"></span></button>
								<button @click=" deleteTransaction( transaction.id )" class="btn btn-clear p-y-0 p-r-0"><span class="text-danger icon icon-cross"></span></button>
							</div>
						</div>
					</div>
				</div>
			</div>


	<!--// MODAL -->
	<div v-show="showModal" id="modal" class="vue-modal" style="display: none;">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
		      	<!-- <div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title text-info">Edit Transaction</h4>
		      	</div> -->
		      	<form @keyup.enter=" submitTransaction" class="form form-horizontal">
		      		<meta type="hidden" id="_token" value="{{ csrf_token() }}">
		      		<div class="modal-body">
						
						<div class="form-group">
							<label class="control-label col-sm-3" for="payable_type">Apply To</label>
							<div class="col-sm-9">
								<select v-model="modal.billable" id="billable" class="form-control" >
									<option data-type="user" value="{{ $landlord->id }}">General</option>
									@foreach($landlord->properties as $property)
										<option data-type="property" value="{{ $property->id }}">&nbsp;&nbsp;{{ $property->address }}</option>
										@foreach($property->devices as $device)
											<option data-type="device" value="{{ $device->id }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-{{ $device->location }}</option>
										@endforeach
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3" for="recurring">Recurring</label>
							<div class="col-sm-9">
								<input class="form-control" type="checkbox" name="recurring" v-model="modal.recurring" />
							</div>
						</div>

						<div v-show="modal.recurring" class="form-group">
							<label class="control-label col-sm-3" for="schedule">Schedule</label>
							<div class="col-sm-9">
								<select class="form-control" name="schedule" v-model="modal.schedule">
									<option :value="null">Select One</option>
									<option value="1">Daily</option>
									<option value="7">Weekly</option>
									<option value="30">Monthly</option>
									<option value="365">Yearly</option>
								</select>
							</div>
						</div>

		        		<div class="form-group">
		        			<label class="control-label col-sm-3" for="amount">Amount</label>
		        			<div class="col-sm-9">
		        				<input id="modal-amount" class="form-control" type="text" name="amount" placeholder="Amount" v-model="modal.amount"/>
		        			</div>
		        		</div>

		        		<div class="form-group">
		        			<label class="control-label col-sm-3" for="description">Description</label>
		        			<div class="col-sm-9">
		        				<input class="form-control" type="text" name="description" placeholder="Description" v-model="modal.description"/>
		        			</div>
		        		</div>

		        		<div class="form-group">
		        			<label class="control-label col-sm-3" for="date">Date</label>
		        			<div class="col-sm-9">
		        				<input class="form-control" type="date" name="date" placeholder="mm/dd/yyyy" v-model="modal.date" />
		        			</div>
		        		</div>

		      		</div>
			      	<div class="modal-footer">
			        	<button @click=" showModal = false" type="button" class="btn btn-default">Close</button>
			        	<button  @click=" submitTransaction" type="button" class="btn btn-primary">Save changes</button>
			      	</div>
		      	</form>
	    	</div><!-- /.modal-content -->
	  	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>



@endsection

@section('scripts')

<script>

	Vue.filter('numeric', function (item, field, operator, value) {
	  console.log(item);
	})

	var vue = new Vue({

		el: '#ledger',


		data: {
			showModal: false,

			modal: {
				amount: '',
				description: '',
				transactionId: 0,
				date: '',
				billable: {{ $landlord->id }},
				recurring: false,
				schedule: null,
			},
			
			// incomes: [

			// ],
			// expenses: [

			// ],

			transactions: [

			],

			properties: {

			},

			numeral: window.numeral,
		},


		ready: function() {
			this.fetchTransactions();
			this.fetchProperties();
		},


		methods: {

			generateModal: function(id) {
				this.modal.amount = '';
				this.modal.transactionId = null;
				this.modal.description = '';
				if(id)
				{
					this.modal.amount = this.transactions[id].amount;
					this.modal.transactionId = id;
					this.modal.description = (this.transactions[id].description) ? this.transactions[id].description : '';
					this.modal.date = this.transactions[id].date;
					this.modal.billable = this.transactions[id].payable_id;
				}
				this.showModal = true;
			},

			submitTransaction: function() {
				var data = {
					amount: this.modal.amount,
					description: this.modal.description,
					payable_id: this.modal.billable,
					payable_type: $('#billable option:selected').data('type'),
					date: this.modal.date,
					recurring: this.modal.recurring,
					schedule: this.modal.schedule
				};

				if(this.modal.transactionId)
				{
					this.updateTransaction(data);
				}
				else
				{
					data.user_id = document.getElementById('user_id').getAttribute('value');
					this.createTransaction(data);
				}
			},

			createTransaction: function(data) {
				this.$http.post('/landlord/transaction', data)
					.success( function(transaction){
						this.transactions[transaction.id] = transaction;
						this.fetchTransactions();
						this.modal.amount = '';
						this.modal.description = '';
						this.showModal = false;
					});
			},

			updateTransaction: function(data) {
				this.transactions[this.modal.transactionId].amount = this.modal.amount;
				this.transactions[this.modal.transactionId].description = this.modal.description;
				this.transactions[this.modal.transactionId].date = this.modal.date;
			
				this.$http.patch('/landlord/transaction/' + this.modal.transactionId, data)
					.success( function(transaction) {
						console.log(transaction);
					});
				//this.fetchTransactions();
				this.showModal = false;
			},

			deleteTransaction: function(id) {
				this.$http.delete('/landlord/transaction/' + id)
					.success( function() {
						delete this.transactions[id];
						console.log('Transaction deleted.')
						this.fetchTransactions();
					});
			},

			fetchTransactions: function() {
				this.$http.get('/landlord/transaction/all')
					.success( function(transactions) {
						this.transactions = transactions;
						//this.incomes = [];
						//this.expenses = [];
						//this.splitTransactions();
					});
			},

			splitTransactions: function() {
				for(var transaction in this.transactions) {
					if (this.transactions[transaction].amount >= 0) {
						this.incomes.push(this.transactions[transaction]);
					}
					else {
						this.expenses.push(this.transactions[transaction]);
					}
				}

			},

			fetchProperties: function() {
				this.$http.get('/landlord/properties/all?sortBy=netIncome')
				.success(function(properties) {
					this.properties = properties;
				});
			},

			getTransactionPayable: function(transaction) {
				
				switch (transaction.payable_type) {
					case 'TenantSync\\Models\\Property':
						return transaction.payable.address;
						break;
					case 'TenantSync\\Models\\Device':
						return transaction.payable.location + ', ' + transaction.property.address;
						break;
					case 'TenantSync\\Models\\User':
						return 'General';
						break;
				}
			}
		},


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