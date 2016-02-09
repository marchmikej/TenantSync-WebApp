@extends('TenantSync::sales/layout')

@section('content')

<div class="row card">
	<div class="col-sm-6 col-sm-offset-3">
	<h4 class="card-header">Payment Methods</h4>
		<form class="form form-horizontal">
			<meta type="hidden" id="_token" value="{{ csrf_token() }}">
			
			<div class="modal-body">
				<div class="form-group">
					<label class="control-label col-sm-3" for="id">Method</label>
					<div class="col-sm-9">
						<select @change="setMethodDetails" class="form-control" v-model="payment.object">
							<option :value="null" number>New Payment Method</option>
							<option v-for="paymentMethod in paymentMethods" :value="paymentMethod" number>@{{ paymentMethod.CardNumber }}</option>
						</select>
					</div>
				</div>
				
				<div v-show="!payment.object" class="form-group">
					<label class="control-label col-sm-3" for="type">Type</label>
					<div class="col-sm-9">
						<select name="type" class="form-control" v-model="payment.type">
							<option :value="null" ></option>
							<option value="card">Credit Card</option>
							<option value="check">Bank Transfer</option>
						</select>
					</div>
				</div>
			

				<div v-if="payment.type == 'card'" id="card-fields">

					<div class="form-group">
						<label class="control-label col-sm-3" for="method_name">Method Name</label>
						<div class="col-sm-9">
							<input class="form-control" type="text" name="method_name" placeholder="Method Name" v-model="payment.method_name"/>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-3" for="card_number">Card Number</label>
						<div class="col-sm-9">
							<input class="form-control" type="text" name="card_number" placeholder="Card Number" v-model="payment.card_number"/>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-3" for="expiration">Expiration</label>
						<div class="col-sm-9">
							<input class="form-control" type="text" name="expiration" placeholder="MM/YY" v-model="payment.expiration"/>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-3" for="cvv2">CVV2</label>
						<div class="col-sm-9">
							<input class="form-control" type="text" name="cvv2" placeholder="CVV2" v-model="payment.cvv2"/>
						</div>
					</div>
				</div>

				<div v-if="payment.type == 'check'" id="check-fields">
					
					<div class="form-group">
						<label class="control-label col-sm-3" for="method_name">Method Name</label>
						<div class="col-sm-9">
							<input class="form-control" type="text" name="method_name" placeholder="Method Name" v-model="payment.method_name"/>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-3" for="account_number">Account Number</label>
						<div class="col-sm-9">
							<input class="form-control" type="text" name="account_number" placeholder="Account Number" v-model="payment.account_number"/>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-3" for="routing_number">Routing Number</label>
						<div class="col-sm-9">
							<input class="form-control" type="text" name="routing_number" placeholder="Routing Number" v-model="payment.routing_number"/>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button @click.stop="showModal = false" type="button" class="col-sm-2 btn btn-default">Close</button>
				<button @click.prevent="submitPayment" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>
</div>

@endsection

@section('scripts')

<script>
vue = new Vue({
	el: '#app',
	data: {
		newPaymentMethod: false,
		showModal: false,
		payment: {
				object: null,
				id: null,
				type: null,
				method_name: null,
				card_number: '',
				expiration: '',
				cvv2: '',
				account_number: '',
				routing_number: '',
			},
		paymentMethods: [

		],
		customer: {},
	},

	ready: function() {
		this.fetchPaymentMethods();
		this.getCustomer();
	},

	methods: {
		fetchPaymentMethods: function() {
			this.$http.get('/sales/payment/' + {{ $landlord->id }})
			.success(function(paymentMethods) {
				this.paymentMethods = paymentMethods;
			});
		},
		submitPayment: function(payment) {			
			this.$http.patch('/sales/payment/' + {{ $landlord->id }}, this.payment)
			.success(function(response) {
				console.log(response);
			});	
		},

		setMethodDetails: function() {
			if(this.payment.object == null) 
			{
				this.resetPaymentFields();
				return false;
			}

			this.payment.id = this.payment.object.MethodID;
			this.payment.object.MethodType == 'cc' ? this.setCardFields() : this.setCheckFields();

		},

		setCardFields: function() {
			this.payment.type = 'card';
			this.payment.method_name = this.payment.object.MethodName;
			this.payment.expiration = this.payment.object.CardExpiration.substring(5) + '/' + this.payment.object.CardExpiration.substring(2, 4);
			this.payment.sortOrder = 0;
		},

		resetPaymentFields: function() {
			this.payment.object = null; 
			this.payment.id = null;
			this.payment.type = null;
			this.payment.method_name = null;
			this.payment.card_number = '';
			this.payment.expiration = '';
			this.payment.cvv2 = '';
			this.payment.account_number = '';
			this.payment.routing_number = '';
		},

		getCustomer: function() {
			this.$http.get('/sales/landlord/' + {{ $landlord->id }} + '/customer')
			.success(function(customer) {
				this.customer = customer;
			});
		},

		updateCustomer: function() {
			data = {
				amount: this.customer.Amount,
			};

			this.$http.patch('/sales/landlord/' + {{ $landlord->id }}, data)
			.success(function() {
				this.getCustomer();
				console.log('submitted');
			});
		},
	}

})	

</script>

@endsection