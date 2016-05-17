@extends('TenantSync::sales/layout')

@section('content')

	<div class="row">
		<div class="col-sm-10">
			<h1 class="text-primary">Add Device</h1>
		</div>
	</div>
	<div class="row">
		<form action="/sales/properties/{{ $property->id }}/device" class="device-form form form-horizontal" method="POST">
			<div class="col-sm-6">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<h4 class="text-info">Device Info</h4>

				<input type="hidden" name="property_id" value="{{ $property->id }}">

				<div class="form-group">
					<label class="control-label col-sm-3" for="serial">Serial</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="serial" placeholder="Device serial #"/>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3" for="location">Location</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="location" placeholder="Location of the device"/>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3" for="rent_amount">Rent</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="rent_amount" placeholder="Cost of rent" value="{{ old('rent_amount') }}"/>
					</div>
				</div>	

				<div class="form-group">
					<label class="control-label col-sm-3" for="late_fee">Late Fee</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="late_fee" placeholder="Late Fee" value="{{ old('late_fee') }}"/>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3" for="grace_period">Grace Period</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="grace_period" placeholder="Grace Period" value="{{ old('grace_period') }}"/>
					</div>
				</div>

				<h4 class="text-info p-t">Ship To</h4>
				<div class="form-group">
					<label class="control-label col-sm-3" for="address">Address</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="address" placeholder="Address"/>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3" for="apt">Apartment</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="apt" placeholder="Apartment"/>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3" for="city">City/State/Zip</label>
					<div class="col-sm-9">
						<input class="form-control col-sm-6" type="text" name="city" placeholder="City"/>
						<select class="form-control col-sm-3" name="state" id="state">
							@foreach($states as $slug => $state)
								<option value="{{ $slug }}" {{ $property->state == $state ? 'selected' : ''}}>{{ strtoupper($slug) }}</option>
							@endforeach
						</select>
						<input class="form-control col-sm-3" type="text" name="zip" placeholder="Zip code"/>
					</div>
				</div>
				<button @click.prevent="createDevice" type="submit" class="btn btn-primary form-control m-b">Continue</button>
			</div>
			<!-- <div class="col-sm-6">
				<h4 class="text-info p-l-0">Payment Details</h4>

				<div class="form-group">
					<label class="control-label col-sm-3">Method</label>
					<div class="col-sm-9">
						<input type="hidden" name="payment_method_id" v-model="payment.id" >
						<input class="form-control form-borderless col-sm-10" :value="paymentMethods[0] ? paymentMethods[0].MethodName : 'Select Method...'" disabled readonly/>
						<button @click.prevent="showModal = true" class="btn btn-clear col-sm-2"><span class="icon icon-edit"></span></button>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-3" for="financed">Finance Install?</label>
					<div class="col-sm-9">
						<input class="form-control" type="checkbox" name="financed" value="1"/>
					</div>
				</div>

				<button @click.prevent="createDevice" type="submit" class="btn btn-primary form-control">Continue</button>
			</div> -->
		</form>
	</div>

	<!--// MODAL -->
	<div @click="showModal = false" v-show="showModal" id="modal" class="vue-modal" style="display: none;">
	  	<div class="modal-dialog">
	    	<div @click.stop="showModal = true" class="modal-content">
		      	<form class="form form-horizontal">
					<meta type="hidden" id="_token" value="{{ csrf_token() }}">
					
					<div class="modal-body">
						<div class="form-group">
							<label class="control-label col-sm-3" for="id">Method</label>
							<div class="col-sm-9">
								<select @change="setMethodDetails" class="form-control" v-model="payment.object">
									<option :value="null" number>New Payment Method</option>
									<option v-for="paymentMethod in paymentMethods" :value="paymentMethod" number>@{{ paymentMethod.MethodName }}</option>
								</select>
							</div>
						</div>
						
						<div v-if="!payment.object" class="form-group">
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
						<button @click.prevent="submitPayment" class="btn btn-primary">Update</button>
					</div>
				</form>

	    	</div><!-- /.modal-content -->
	  	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

@endsection

@section('scripts')

<script>
var vue = new Vue({
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
		//this.getCustomer();
	},

	methods: {
		fetchPaymentMethods: function() {
			this.$http.get('/sales/landlord/' + {{ $property->landlord()->id }} + '/payment')
			.success(function(paymentMethods) {
				this.paymentMethods = paymentMethods;
				this.payment.object = this.paymentMethods[0];
				this.setMethodDetails();
			});
		},

		createDevice: function($e) {
			if(! this.payment.id) {
				swal('Uh Oh.', 'Please select a payment method.');

				return false;
			}
			
			document.querySelector('.device-form').submit();
		},

		submitPayment: function(payment) {			
			this.$http.patch('/sales/landlord/' + {{ $property->landlord()->id }} + '/payment', this.payment)
			.success(function(response) {
				this.showModal = false;
				this.resetPaymentFields();
				this.fetchPaymentMethods();
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
			// this.payment.expiration = this.payment.object.CardExpiration.substring(5) + '/' + this.payment.object.CardExpiration.substring(2, 4);
			this.payment.sortOrder = 0;
		},

		setCardFields: function() {
			
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
			this.$http.get('/sales/landlord/' + {{ $property->landlord()->id }} + '/billing-account')
			.success(function(customer) {
				this.customer = customer;
				this.paymentMethods = customer.PaymentMethods;
			});
		},

		updateRecurringAmount: function() {
			data = {
				recurringAmount: this.customer.Amount,
			};

			this.$http.patch('/sales/landlord/' + {{ $property->landlord()->id }} + '/billing-account', data)
			.success(function() {
				this.getCustomer();
				swal('Success!', 'The recurring amount has been updated.');
			});
		},
	}

})	

</script>
</script>

@endsection