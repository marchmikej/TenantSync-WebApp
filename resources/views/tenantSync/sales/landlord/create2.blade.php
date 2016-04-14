@extends('TenantSync::sales/layout')

@section('content')

	<div class="row">
		<div class="col-sm-10">
			<h1 class="text-primary">New Landlord</h1>
		</div>
		<div class="col-sm-2">
			<button form="landlord-form" class="col-sm-12 btn btn-primary">Create</button>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 card">
			<span class="text-info lead">User Info</span>
			<form action="/sales/landlord/" method="POST" id="landlord-form">

				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="form-group">
					<label for="" class="control-label">Email</label>
					<input class="form-control" type="text" name="email" value="{{ old('email') }}"  placeholder="Email">
				</div>

				<div class="form-group">
					<label for="" class="control-label">Password</label>
					<input class="form-control" type="password" name="password" placeholder="Password">
				</div>

				<div class="form-group">
					<label for="" class="control-label">Comfirm Password</label>
					<input class="form-control" type="password" name="password_confirmation" placeholder="Confirm password">
				</div>
				
				<div class="form-group">
					<label for="" class="control-label">First Name</label>
					<input class="form-control" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="first name">
				</div>
			
				
				<div class="form-group">
					<label for="" class="control-label">Last Name</label>
					<input class="form-control" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="last name">
				</div>
			
				
				<div class="form-group">
					<label for="" class="control-label">Company</label>
					<input class="form-control" type="text" name="company" value="{{ old('company') }}" placeholder="company">
				</div>
			
			
				<div class="form-group">
					<label for="" class="control-label">Phone</label>
					<input class="form-control" type="text" name="phone" value="{{ old('phone') }}" placeholder="phone">
				</div>
					
			</div>
			<div class="col-sm-4 card">
				<span class="text-info lead">Billing</span>					
						
				<!-- <div class="form-group">
				   	<input type="checkbox" id="same-address" class="padding-vertical">
				   	<label for="" class="control-label">Same as shipping</label>
				</div>  -->  
			
				<!-- <div class="form-group">
					<label class="control-label" for="card_number">Card Number</label>
					<input class="form-control" type="text" name="card_number" placeholder="Card Number" value="{{ old('card_number') }}"/>
				</div>

				<div class="form-group">
					<label class="control-label" for="expiration">Expiration</label>
					<input class="form-control" type="text" name="expiration" placeholder="Expiration" value="{{ old('expiration') }}"/>
				</div>

				<div class="form-group">
					<label class="control-label" for="cvv2">Cvv2</label>
					<input class="form-control" type="text" name="cvv2" placeholder="Cvv2" value="{{ old('cvv2') }}"/>
				</div> -->
			
				<div class="form-group">
					<label for="" class="control-label">Address</label>
					<input class="form-control" type="text" name="address" value="{{ old('address') }}" placeholder="Address">
				</div>
			
			
				<div class="form-group">
					<label for="" class="control-label">Apartment</label>
					<input class="form-control" type="text" name="apt" value="{{ old('apt') }}" placeholder="Apartment">
				</div>
			
			
				<div class="form-group">
					<label for="" class="control-label">City</label>
					<input class="form-control" type="text" name="city" value="{{ old('city') }}" placeholder="City">
				</div>
			
			
				<div class="form-group">
					<label class="control-label" for="city">State</label>
					<select class="form-control" name="state" id="state">
						@foreach($states as $slug => $state)
							<option value="{{ $slug }}">{{ strtoupper($slug) }}</option>
						@endforeach
					</select>
				</div>
			
			
				<div class="form-group">
					<label for="" class="control-label">Zip</label>
					<input class="form-control" type="text" name="zip" value="{{ old('zip') }}" placeholder="Zip">
				</div>
					
			</div>
			<div class="col-sm-4 card">
				<span class="text-info lead">Receiving Payments</span>
					
				<div class="form-group">
					<label for="" class="control-label">Souce Key</label>
					<input class="form-control" type="text" name="key" value="{{ old('key') }}" placeholder="Source key">
				</div>
			
			
				<div class="form-group">
					<label for="" class="control-label">Source Pin</label>
					<input class="form-control" type="text" name="pin" value="{{ old('pin') }}" placeholder="Source pin">
				</div>
				
				<input type="submit" value="Create" class="form-control hidden">
			</div>
		</form>
	</div>


@endsection

@section('footer')

<script>
	$('button[form = "landlord-form"]').click(function()
	{
		$('#landlord-form').submit();
	});
</script>

@endsection