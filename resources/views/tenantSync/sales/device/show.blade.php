@extends('TenantSync::sales/layout')

@section('content')

	<div class="row card">
		<div class="col-sm-6">
		<h2 class="text-info">Device Info</h2>

			<form action="/sales/device/{{ $device->id }}" method="POST" class="form form-horizontal">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="_method" value="PATCH">

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
				
				<div class="form-group">
					<label class="control-label col-sm-3" for="alarm">Alarm</label>
					<div class="col-sm-9">
						<select name="alarm_id" class="form-control">
							<option value="0" {{ $device->alarm_id == 0 ? 'selected' : false }}>Off</option>
							<option value="1" {{ $device->alarm_id == 1 ? 'selected' : false }}>Deliquent</option>
						</select>
					</div>
				</div>
				
				<!-- <div class="form-group">
					<label class="control-label col-sm-3" for="alarm">Alarm</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" placeholder="Alarm" value="{{ $device->alarm }}" disabled/>
					</div>
				</div> -->

				<button class="form-control btn btn-primary">Submit</button>

			</form>
		</div>
		<div class="col-sm-6">
		<h4>Property Info</h4>
			<table class="table">
				<tr>
					<td>Address</td>
					<td>{{ $device->property->address }}</td>
				</tr>
				<tr>
					<td>Apt</td>
					<td>{{ $device->location }}</td>
				</tr>
				<tr>
					<td>City</td>
					<td>{{ $device->property->city }}</td>
				</tr>
				<tr>
					<td>State</td>
					<td>{{ $device->property->state }}</td>
				</tr>
				<tr>
					<td>Zip</td>
					<td>{{ $device->property->zip }}</td>
				</tr>
			</table>
		</div>
	</div>

@endsection