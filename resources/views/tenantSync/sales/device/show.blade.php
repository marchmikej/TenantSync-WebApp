@extends('TenantSync::sales/layout')

@section('content')

	<div class="row">
		<div class="col-sm-6">
		<h2 class="text-info">Device Info</h2>

			<div class="form-group">
				<label class="control-label col-sm-3" for="serial">Serial</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" placeholder="Device Serial" value="{{ $device->serial }}" disabled/>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-sm-3" for="status">Status</label>
				<div class="col-sm-9">
					<select class="form-control" name="status">
						<option value="active">Active</option>
						<option value="canceled">Canceled</option>
						<option value="unresponsive">Unresponsive</option>
					</select>
				</div>
			</div>

			<!-- <div class="form-group">
				<label class="control-label col-sm-3" for="alarm">Alarm</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" placeholder="Alarm" value="{{ $device->alarm }}" disabled/>
				</div>
			</div> -->
		</div>
		<div class="col-sm-6">
		<h4>Property Info</h4>
			<table class="table">
				<tr>
					<td>Address</td>
					<td>{{ $device->location }}</td>
				</tr>
				<tr>
					<td>Apt</td>
					<td>{{ $device->apt }}</td>
				</tr>
				<tr>
					<td>City</td>
					<td>{{ $device->city }}</td>
				</tr>
				<tr>
					<td>State</td>
					<td>{{ $device->state }}</td>
				</tr>
				<tr>
					<td>Zip</td>
					<td>{{ $device->postal_code }}</td>
				</tr>
			</table>
		</div>
	</div>

@endsection