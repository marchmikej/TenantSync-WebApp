@extends('TenantSync::sales/layout')

@section('content')

	@if ($errors->any())
	<div class="errors col-xs-12">
		<ul>
			@foreach($errors->all() as $error)
			<li class="text-danger">{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif

	<div class="row">
		<div class="col-sm-10">
			<h1 class="text-muted">New Landlord</h1>
		</div>
		<div class="col-sm-2">
			<button form="landlord-form" class=" col-sm-12 btn btn-primary">Create</button>
		</div>
	</div>
	<div class="row table-no-pad table-no-border">
		<div class="col-sm-4">
		<h4>User Info</h4>
			<form action="/sales/landlord" class="landlord-form form form-default" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<table class="table">
					<tr>
						<td>Username</td>
						<td><input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username"></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input class="form-control" type="text" name="email" value="{{ old('email') }}"  placeholder="Email"></td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input class="form-control" type="password" name="password" placeholder="Password"></td>
					</tr>
						<tr>
						<td>Confirm Password</td>
						<td><input class="form-control" type="password" name="password_confirmation" placeholder="Confirm password"></td>
					</tr>
						<tr>
						<td>First Name</td>
						<td><input class="form-control" type="text" name="first_name" value="{{ old('first_name') }}" placeholder="first_name"></td>
					</tr>
						<tr>
						<td>Last Name</td>
						<td><input class="form-control" type="text" name="last_name" value="{{ old('last_name') }}" placeholder="last_name"></td>
					</tr>
						<tr>
						<td>Company</td>
						<td><input class="form-control" type="text" name="company" value="{{ old('company') }}" placeholder="company"></td>
					</tr>
					<tr>
						<td>Phone</td>
						<td><input class="form-control" type="text" name="phone" value="{{ old('phone') }}" placeholder="phone"></td>
					</tr>
					<!-- <tr>
						<td>
							<h4>Shipping info</h4>
						</td>
						<td>
							<h4><span class="invisible">.</span></h4>
						</td>
					</tr>
					<tr>
						<td>Address</td>
						<td><input class="form-control" type="text" name="address" value="{{ old('address') }}" placeholder="Address"></td>
					</tr>
					<tr>
						<td>Apartment</td>
						<td><input class="form-control" type="text" name="apt" value="{{ old('address') }}" placeholder="Apartment"></td>
					</tr>
					<tr>
						<td>City</td>
						<td><input class="form-control" type="text" name="city" value="{{ old('city') }}" placeholder="City"></td>
					</tr>
					<tr>
						<td>State</td>
						<td><input class="form-control" type="text" name="state" value="{{ old('state') }}" placeholder="State"></td>
					</tr>
					<tr>
						<td>Zip</td>
						<td><input class="form-control" type="text" name="zip" value="{{ old('zip') }}" placeholder="Zip"></td>
					</tr> -->
				</table>
			</div>
			<div class="col-sm-4">
			<h4>Billing info</h4>
				<table class="table">
					<tr>
						<td></td>
						<td><input type="checkbox" id="same-address" class="padding-vertical">   Same as shipping</td>
					</tr>
					<tr>
						<td>Address</td>
						<td><input class="form-control" type="text" name="billing_address" value="{{ old('billing_address') }}" placeholder="Address"></td>
					</tr>
					<tr>
						<td>Apartment</td>
						<td><input class="form-control" type="text" name="billing_apt" value="{{ old('billing_apt') }}" placeholder="Apartment"></td>
					</tr>
					<tr>
						<td>City</td>
						<td><input class="form-control" type="text" name="billing_city" value="{{ old('billing_city') }}" placeholder="City"></td>
					</tr>
					<tr>
						<td>State</td>
						<td><input class="form-control" type="text" name="billing_state" value="{{ old('billing_state') }}" placeholder="State"></td>
					</tr>
					<tr>
						<td>Zip</td>
						<td><input class="form-control" type="text" name="billing_zip" value="{{ old('billing_zip') }}" placeholder="Zip"></td>
					</tr>
				</table>
			</div>
			<div class="col-sm-4">
				<h4>Payment Gateway</h4>
				<table class="table">
					<tr>
						<td>Souce Key</td>
						<td><input class="form-control" type="text" name="source_key" value="{{ old('source_key') }}" placeholder="Source key"></td>
					</tr>
					<tr>
						<td>Source Pin</td>
						<td><input class="form-control" type="text" name="source_pin" value="{{ old('source_pin') }}" placeholder="Source pin"></td>
					</tr>
	<!-- 				<tr>
						<td>Gateway</td>
						<td></td>
					</tr> -->
					<input type="submit" value="Create" class="form-control hidden">
				</table>
			</div>
		</form>
	</div>


@endsection

@section('footer')

<script>
	$('button[form = landlord-form]').click(function()
	{
		$('form.landlord-form').submit();
	});
</script>

@endsection