@extends('TenantSync::sales/layout')

@section('content')

	<div class="row">
		<div class="col-sm-10">
			<h1 class="text-primary">Add Device</h1>
		</div>
	</div>
	<div class="row">
		<form action="/sales/device" class="device-form form form-horizontal" method="POST">
			<div class="col-sm-6">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="user_id" value="{{ $landlord->id }}">
				<h4 class="text-info">Device Info</h4>

				<div class="form-group">
					<label class="control-label col-sm-3" for="property_id">Property</label>
					<div class="col-sm-9">
						<select class="form-control" name="property_id">
							<option value="null">Select a property...</option>
							@foreach($landlord->properties as $property)
							<option value="{{ $property->id }}">{{ $property->address.', '.$property->city.' '.$property->state }}</option>
							@endforeach
						</select>
					</div>
				</div>

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

				<!-- <div class="form-group">
					<label class="control-label col-sm-3" for="rent_due_day">Rent Due Day</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" name="rent_due_day" placeholder="Day of the month" value="{{ old('rent_due_day') }}"/>
					</div>
				</div> -->

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
								<option value="{{ $slug }}" {{ $landlord->profile->state == $state ? 'selected' : ''}}>{{ strtoupper($slug) }}</option>
							@endforeach
						</select>
						<input class="form-control col-sm-3" type="text" name="zip" placeholder="Zip code"/>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<h4 class="text-info p-l-0">Payment Method</h4>
				<!-- <div class="form-group">
					<label class="control-label col-sm-3" for="usePaymentMethod">Current Method</label>
					<div class="col-sm-9">
						<input class="form-control col-sm-1 checkbox" type="checkbox" name="usePaymentMethod" placeholder=""/>
					</div>
				</div> -->
				<div class="form-group">
					<label class="control-label col-sm-3" for="payment_method">Payment Method</label>
					<div class="col-sm-9">
						<input class="form-control form-borderless col-sm-6" type="text" name="payment_method" placeholder="" :value="paymentMethods.hasOwnProperty(0) ? paymentMethods[0].MethodName : 'Loading...'" disabled readonly/>
						<a href="/sales/payment/create?user_id={{ $landlord->id }}" class="btn btn-primary col-sm-4"><span>Change</span></a>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-3" for="financed">Finance Install?</label>
					<div class="col-sm-9">
						<input class="form-control" type="checkbox" name="financed" value="1"/>
					</div>
				</div>

				<button type="submit" class="btn btn-primary form-control">Continue</button>
			</div>
		</form>
	</div>

@endsection

@section('scripts')

<script>
	$('button[form = device-form]').click(function()
	{
		$('form.device-form').submit();
	});
</script>

<script>
	var vue = new Vue({
		el: '#app',

		data: {
			paymentMethods: {},
		},

		ready: function() {
			this.fetchPaymentMethods();
		},

		methods: {
			fetchPaymentMethods: function() {
				this.$http.get('/sales/payment/' + {{ $landlord->id }})
				.success(function(paymentMethods) {
					this.paymentMethods = paymentMethods;
				});
			},
		}

	});
</script>

@endsection