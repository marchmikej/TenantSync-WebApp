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
			<h1 class="text-muted">{{ ucfirst($landlord->profile->first_name).' '.ucfirst($landlord->profile->last_name) }}</h1>
		</div>
		<div class="col-sm-2">
			<button form="landlord-form" class=" col-sm-12 btn btn-primary">Save</button>
		</div>
	</div>
	<div class="row table-no-pad table-no-border">
		<div class="col-sm-4 ">
		<h4 class="p-b">Profile</h4>
			<form action="/sales/landlord/{{ $landlord->id }}/edit" class="landlord-form form form-default" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<table class="flextable">
					<tr>
						<td>Email</td>
						<td><input class="form-control" type="text" name="email" value="{{ $landlord->email }}" placeholder="Email"></td>
					</tr>
					<tr>
						<td>Password</td>
						<td><button class="btn btn-primary-outline"></button>
					<tr>
						<td>Company</td>
						<td><input class="form-control" type="text" name="company" value="{{ $landlord->profile->company }}" placeholder="company"></td>
					</tr>
					<tr>
						<td>Phone</td>
						<td><input class="form-control" type="text" name="phone" value="{{ $landlord->profile->phone }}" placeholder="phone"></td>
					</tr>
				</table>
			</div>
			<div class="col-sm-4">
			<h4 class="p-b">Payment Method</h4>
				<table class="table">

				</table>
			</div>
			<div class="col-sm-4">
			<h4 class="p-b">Payment Gateway</h4>
				<table class="table">

	<!-- 				<tr>
						<td>Gateway</td>
						<td></td>
					</tr> -->
				</table>
			</div>
		</form>
	</div>
	<div class="row p-t-md">
		<div class="col-sm-12">
		<h4>Devices</h4>
			<table class="devices-table table">
				<thead>
					<th>Serial</th>
					<th>Alarm</th>
					<th>Status</th>
					<th>Address</th>
					<th>Apt.</th>
					<th>City</th>
					<th>State</th>
					<th>Zip</th>
					<th>Rent</th>
					<th>Due</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($landlord->devices as $device)
					<tr>
						<td><a href="/sales/device/{{ $device->id }}">{{ $device->android_device_serial }}</a></td>
						<td>{{ $device->alarm }}</td>
						<td>{{ $device->status }}</td>
						<td>{{ $device->address }}</td>
						<td>{{ $device->apt }}</td>
						<td>{{ $device->city }}</td>
						<td>{{ $device->state }}</td>
						<td>{{ $device->postal_code }}</td>
						<td>{{ $device->rent_ammount }}</td>
						<td>{{ $device->rent_due_date }}</td>
						<td></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
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