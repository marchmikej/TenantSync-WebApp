@extends('TenantSync::manager/layout')

@section('content')

<div id="profile" class="row card" v-cloak>

	<div class="col-sm-6">
		<div class="card-header">
			<h4>Change Email</h4>
		</div>
		<form action="/manager/profile/email" method="POST" class="form form-horizontal">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="form-group">
				<label class="control-label col-sm-3" for="email">Email</label>
				<div class="col-sm-9">
					<input class="form-control" type="email" name="email" placeholder="Email" value="{{ $manager->user->email }}"/>
				</div>
			</div>

			<button class="btn btn-primary col-sm-3 col-sm-offset-9">Save</button>

		</form>
	</div>
	<div class="col-sm-6">
		<div>
			<div class="card-header">
				<h4>Password Reset</h4>
			</div>
			<form class="form form-horizontal" action="/manager/profile/password" method="POST">
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
					<label class="control-label col-sm-3" for="password_confirmation">Comfirm</label>
					<div class="col-sm-9">
						<input class="form-control" type="password" name="password_confirmation" placeholder="Comfirm" value="{{ old('password_confirmation') }}"/>
					</div>
				</div>

				<button class="btn btn-primary col-sm-3 col-sm-offset-9">Submit</button>

			</form>
		</div>
	</div>

	@if($manager->isLandlord())
	<div class="col-sm-6">
		<div class="card-header">
			<h4>Billing Info</h4>
		</div>

		@include('TenantSync::includes/paymentMethods')
				
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

	<!-- <div class="col-sm-6">
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
					<label class="control-label col-sm-3" for="password">New Password</label>
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

				<button class="btn btn-primary col-sm-3 col-sm-offset-9 form-control">Submit</button>

			</form>
		</div> -->
	</div>
	@endif
</div>

@endsection

@section('scripts')

<script>

vue = new Vue({
	el: '#app',

})	

</script>

@endsection