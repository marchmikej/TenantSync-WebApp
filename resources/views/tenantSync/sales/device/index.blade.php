@extends('TenantSync::sales/layout')

@section('content')
	
	<div class="row">
		<div class="col-sm-10">
			<h1>Devices</h1>
		</div>
<!-- 		<div class="col-sm-2">
			<a href="/sales/device/create"><button class="col-sm-12 btn btn-primary">Add Device</button></a>
		</div> -->
	</div>
	<div class="row">
		<div class="col-sm-12">
			<table class="devices-table table">
				<thead>
					<th>Landlord</th>
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
					@foreach($devices as $device)
					<tr>
						<td><a href="/sales/landlord/{{ $device->user_id }}">{{ $device->owner->email}}</a></td>
						
						<td><a href="/sales/device/{{ $device->id }}">{{ $device->serial }}</a></td>
						<td>{{ $device->alarm }}</td>
						<td>{{ $device->status }}</td>
						<td>{{ $device->location }}</td>
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
