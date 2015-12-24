@extends('TenantSync::sales/layout')

@section('content')

	<div class="row">
		<div class="col-sm-12">
			<h1 class="text-muted">Device ID : {{ $device->id }}</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
		<h4>Device Info</h4>
			<table class="table">
				<tr>
					<td>Serial</td>
					<td><input type="text" class="form-control" name="" value="{{ $device->android_device_serial }}</td>">
				</tr>
				<tr>
					<td>Status</td>
					<td><input type="text" class="form-control" name="" value="{{ $device->status }}</td>">
				</tr>
				<tr>
					<td>Alarm</td>
					<td><input type="text" class="form-control" name="" value="{{ $device->alarm }}</td>">
				</tr>
			</table>
		</div>
		<div class="col-sm-6">
		<h4>Property Info</h4>
			<table class="table">
				<tr>
					<td>Address</td>
					<td><input type="text" class="form-control" name="" value="{{ $device->property->address }}"></td>
				</tr>
				<tr>
					<td>Apt</td>
					<td><input type="text" class="form-control" name="" value="{{ $device->property->apt }}"></td>
				</tr>
				<tr>
					<td>City</td>
					<td><input type="text" class="form-control" name="" value="{{ $device->property->city }}"></td>
				</tr>
				<tr>
					<td>State</td>
					<td><input type="text" class="form-control" name="" value="{{ $device->property->state }}"></td>
				</tr>
				<tr>
					<td>Zip</td>
					<td><input type="text" class="form-control" name="" value="{{ $device->property->postal_code }}"></td>
				</tr>
			</table>
		</div>
	</div>

@endsection