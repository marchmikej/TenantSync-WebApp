@extends('TenantSync::landlord.layout')

@section('content')

<div class="row">
	<div class="col-sm-6 col-sm-offset-3 card">
		<div class="card-header">
			<h3>New Manager</h3>
		</div>
		<form action="/landlord/managers" method="POST" class="form form-horizontal">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="form-group">
				<label class="control-label col-sm-3" for="first_name">First Name</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="first_name" placeholder="First Name" value="{{ old('first_name') }}"/>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-3" for="last_name">Last Name</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}"/>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-3" for="email">Email</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="email" placeholder="Email" value="{{ old('email') }}"/>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-3" for="position">Position</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="position" placeholder="Position" value="{{ old('position') }}"/>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-3" for="phone">Phone</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="phone" placeholder="Phone" value="{{ old('phone') }}"/>
				</div>
			</div>

			<button class="form-control col-sm-3 col-sm-offset-9 btn btn-primary">Create</button>
		</form>
	</div>
</div>


@endsection