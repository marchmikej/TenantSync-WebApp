@extends('TenantSync::sales/layout')

@section('content')

<div id="landlord">
	<div class="row card">
		<div class="col-sm-4">
			<h2 class="text-info">
				Profile <button class="btn btn-clear text-primary " form="profile-form" alt="Save" ><span class="icon icon-save"></span></button>
			</h2>
			
			<form id="profile-form" class="form form-horizontal" action="/sales/profile/{{$landlord->profile->id}}" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="_method" value="PATCH">
				<div class="form-group">
					<label class="control-label col-sm-3" for="name">Name</label>
					<div class="col-sm-9">
						<input class="form-control form-borderless" type="text" placeholder="Name" value="{{ ucfirst($landlord->profile->first_name).' '.ucfirst($landlord->profile->last_name) }}" disabled readonly/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="email" >Email</label>
					<div class="col-sm-9">
						<input class="form-control" type="email" name="email" placeholder="Email" value="{{ $landlord->email }}"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="company">Company</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="company" placeholder="Company" value="{{ $landlord->profile->company }}"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="phone">Phone</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="phone" placeholder="Phone" value="{{ $landlord->profile->phone }}"/>
					</div>
				</div>
			</form>
		</div>
		<div class="col-sm-4">
			<h2 class="text-info">
				Billing <button class="btn btn-clear text-primary " form="billing-form" alt="Save"><span class="icon icon-save"></span></button>
			</h2>
			<form id="billing-form" class="form form-horizontal" action="/sales/billing/{{ $landlord->profile->id}}" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="_method" value="PATCH">
				<div class="form-group">
					<label class="control-label col-sm-3">Method</label>
					<div class="col-sm-9">
						<input class="form-control form-borderless col-sm-10" value="{{ ($landlord->paymentMethods()->exists()) ? $landlord->paymentMethods()->orderBy('created_at', 'desc')->first()->name : ''}}" disabled readonly/>
						<button @click.prevent="showModal = true" class="btn btn-clear col-sm-2"><span class="icon icon-edit"></span></button>
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
								<option value="{{ $slug }}" {{ $landlord->profile->state == $state ? 'selected' : ''}}>{{ strtoupper($slug) }}</option>
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
			</form>
		</div>
		<div class="col-sm-4">
			<h2 class="text-info">
				Receiving <button class="btn btn-clear text-primary " form="receiving-form" alt="Save"><span class="icon icon-save"></span></button>
			</h2>
			<form id="receiving-form" class="form form-horizontal" action="/sales/gateway/{{ $landlord->id}}" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="_method" value="PATCH">
				<div class="form-group">
					<label class="control-label col-sm-3" for="pin">Pin</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="pin" placeholder="Pin" value="{{ $landlord->gateway()->exists() ? $landlord->gateway->pin : '' }}"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3" for="key">Key</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="key" placeholder="Key" value="{{ $landlord->gateway()->exists() ? $landlord->gateway->key : '' }}"/>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="row card">
		<div class="col-sm-12">
		<h4 class="card-header">Recurring Billing</h4>
		<form @submit.prevent="updateCustomer" class="form form-horizontal">
			<div class="form-group">
				<label class="control-label col-sm-3">Reccuring Amount</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" placeholder="Reccuring Amount" v-model="customer.Amount"/>
				</div>
			</div>

			<button class="btn btn-primary form-control col-sm-3 col-sm-offset-9">Save</button>
		</form>
		</div>
	</div>
	<div class="row card">
		<div class="col-sm-10">
			<h2 class="text-info m-t-0">Devices</h2>
		</div>
		<div class="col-sm-2">
			<a href="/sales/device/create?user_id={{ $landlord->id }}"><button class="col-sm-12 btn btn-primary">Add Device</button></a>
		</div>

		<div class="col-sm-12">
			<table class="devices-table table">
				<thead>
					<th>Address</th>
					<th>Apt.</th>
					<th>Alarm</th>
					<th>Status</th>
 					<th>Serial</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($landlord->devices as $device)
					<tr>
						<td><a href="/sales/device/{{ $device->id }}">{{ $device->property->address . ', ' .  $device->property->city . ' ' . $device->property->state }}</a></td>
						<td>{{ $device->location }}</td>
						<td>{{ $device->alarm_id !== 0 ? str_replace('_', ' ', $device->alarm->slug) : 'Off' }}</td>
						<td>{{ $device->status }}</td>
						<td>{{ $device->serial }}</td>
						
						<td></td>
					</tr>
					@endforeach
				</tbody>
			</table>
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
									<input class="form-control" type="text" name="account_number" placeholder="Account Number" v-model="payment.check.account_number"/>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3" for="routing_number">Routing Number</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="routing_number" placeholder="Routing Number" v-model="payment.check.routing_number"/>
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
</div><!-- Vue Container -->



@endsection

@section('scripts')

<script>
vue = new Vue({
	el: '#landlord',
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
			this.$http.patch('/sales/payment/' + this.payment.id, this.payment)
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