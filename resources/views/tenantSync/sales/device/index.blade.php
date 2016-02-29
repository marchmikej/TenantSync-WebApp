@extends('TenantSync::sales/layout')

@section('content')
	
	<div class="row card">
		<div class="col-sm-10">
			<h1>Devices</h1>
		</div>
		<div class="col-sm-12">
			<table class="devices-table table">
				<thead>
					<th>Landlord</th>
					<th>Alarm</th>
					<th>Status</th>
					<th>Address</th>
					<th>Apt.</th>
					<th>City</th>
					<th>State</th>
					<th>Zip</th>
					<th>Rent</th>
					<th>Due</th>
					<th>Serial</th>
				</thead>
				<tbody>
					@foreach($devices as $device)
					<tr>
						<td><a href="/sales/landlord/{{ $device->user_id }}">{{ $device->owner->email}}</a></td>
						
						<td>{{ $device->alarm->slug ? $device->alarm->slug : 'Off' }}</td>
						<td>{{ $device->status }}</td>
						<td>{{ $device->property->address }}</td>
						<td>{{ $device->location }}</td>
						<td>{{ $device->property->city }}</td>
						<td>{{ $device->property->state }}</td>
						<td>{{ $device->property->zip }}</td>
						<td>{{ $device->rent_amount }}</td>
						<td>{{ $device->rent_due }}</td>
						<td><a href="/sales/device/{{ $device->id }}">{{ $device->serial }}</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection
