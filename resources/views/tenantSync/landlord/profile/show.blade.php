@extends('TenantSync::landlord/layout')

@section('content')

	<div id="profile" class="row card" v-cloak>
		<div class="col-sm-6">
			<div class="card-header">
				<h4>Billing Info</h4>
			</div>

			<div class="form form-horizontal">
				<div class="form-group">
					<label class="control-label col-sm-3">Payment Method</label>
					<div class="col-sm-9">
						<input :value="paymentMethods.hasOwnProperty(0) ? paymentMethods[0].MethodName : 'Loading...'" class="col-sm-10 form-control" type="text"  placeholder="" disabled readonly/>
						<button @click.prevent="showModal = true" class="btn btn-clear col-sm-2"><span class="icon icon-edit"></span></button>
					</div>
				</div>
			</div>

			<form class="form form-horizontal" action="/landlord/profile/{{ $landlord->id }}" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="_method" value="PATCH">

				<div class="form-group">
					<label class="control-label col-sm-3" for="first_name">First Name</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="first_name" placeholder="First Name" value="{{ $landlord->profile->first_name }}"/>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3" for="last_name">Last Name</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="last_name" placeholder="Last Name" value="{{ $landlord->profile->last_name }}"/>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3" for="phone">Phone</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="phone" placeholder="Phone" value="{{ $landlord->profile->phone }}"/>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3" for="company">Company</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="company" placeholder="Company" value="{{ $landlord->profile->company }}"/>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3" for="address">Address</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="address" placeholder="Address" value="{{ $landlord->profile->address }}"/>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3" for="city">City/State</label>
					<div class="col-sm-9">
						<input class="form-control col-sm-9" type="text" name="city" placeholder="City" value="{{ $landlord->profile->city }}"/>
						<select class="form-control col-sm-3" name="state" id="state" >
							@foreach($states as $slug => $state)
								<option value="{{ $slug }}" {{ $landlord->profile->state == $slug ? 'selected' : ''}}>{{ strtoupper($slug) }}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3" for="zip">Zip</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="zip" placeholder="Zip" value="{{ $landlord->profile->zip }}"/>
					</div>
				</div>

				<button class="btn btn-primary col-sm-3 col-sm-offset-9 form-control">Save</button>
			</form>

			<div class="card-header">
				<h4>Receiving Info</h4>
			</div>
			<form class="form form-horizontal" action="/landlord/gateway/{{ $landlord->gateway->id }}" method="POST">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="_method" value="PATCH">

				<div class="form-group">
					<label class="control-label col-sm-3" for="pin">Pin</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="pin" placeholder="Pin" value="{{ $landlord->gateway->pin }}"/>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3" for="key">Key</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="key" placeholder="Key" value="{{ $landlord->gateway->key }}"/>
					</div>
				</div>
				
				<button class="btn btn-primary col-sm-3 col-sm-offset-9 form-control">Save</button>
			</form>
				
		</div>
		<div class="col-sm-6">
			<div>
				<div class="card-header">
						<h4>Password Reset</h4>
					</div>
				<form class="form form-horizontal" action="/landlord/profile/password" method="POST">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					
					<div class="form-group">
						<label class="control-label col-sm-3" for="current_password">Current Password</label>
						<div class="col-sm-9">
							<input class="form-control" type="password" name="current_password" placeholder="Current Password" value="{{ old('current_password') }}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="password">Password</label>
						<div class="col-sm-9">
							<input class="form-control" type="password" name="password" placeholder="Password" value="{{ old('password') }}"/>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-sm-3" for="password_confirmation">Confirm</label>
						<div class="col-sm-9">
							<input class="form-control" type="password" name="password_confirmation" placeholder="Confirm" value="{{ old('password_confirmation') }}"/>
						</div>
					</div>

				</form>
			</div>
		</div>

		<!--// MODAL -->
		<div @click="showModal = false" v-show="showModal" id="modal" class="vue-modal" style="display: none;">
		  	<div class="modal-dialog">
		    	<div @click.stop="showModal = true" class="modal-content">
			      	<!-- <div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title text-info">Edit Transaction</h4>
			      	</div> -->
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

		    	</div><!-- /.modal-content -->
		  	</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

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
	},

	ready: function() {
		this.fetchPaymentMethods();
	},

	methods: {
		fetchPaymentMethods: function() {
			this.$http.get('/landlord/payment/' + TenantSync.landlord)
			.success(function(paymentMethods) {
				this.paymentMethods = paymentMethods;
			});
		},
		submitPayment: function(payment) {			
			this.$http.patch('/landlord/payment/' + this.payment.id, this.payment)
			.success(function(response) {
				console.log(response);
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
	}

})	

</script>

@endsection