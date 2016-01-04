@extends('TenantSync::sales/layout')

@section('content')
	<div class="row p-t">
		<div class="col-sm-4">
		<h2 class="text-info col-sm-10 m-t-0 p-x-0">Profile</h2>
		<a class=" col-sm-1" href="/landlord/profile/edit"><span class="icon icon-edit"></span></a>
			<table class="table-borderless table">
				<tr>
					<th>Name</th>
					<td>{{ ucfirst($landlord->profile->first_name).' '.ucfirst($landlord->profile->last_name) }}</td>
				</tr>
				<tr>
					<th>Email</th>
					<td>{{$landlord->email}}</td>
				</tr>
				<tr>
					<th>Company</th>
					<td>{{$landlord->profile->company}}</td>
				</tr>
				<tr>
					<th>Phone</th>
					<td>{{$landlord->profile->phone}}</td>
				</tr>
			</table>
		</div>
		<div class="col-sm-4">
		<h2 class="text-info m-t-0 p-x-0 col-sm-10">Billing</h2>
		<a class=" col-sm-1" href="/landlord/profile/edit"><span class="icon icon-edit"></span></a>
			<table class="table-borderless table">
				<tr>
					<th>Method</th>
					<td> card ending in ... </td>
				</tr>
				<tr>
					<th>Address</th>
					<td> billing address </td>
				</tr>
				<tr>
					<th>City/State</th>
					<td> city state </td>
				</tr>
				<tr>
					<th>Zip</th>
					<td> zip </td>
				</tr>
			</table>
		</div>
		<div class="col-sm-4">
		<h2 class="text-info m-t-0 p-x-0 col-sm-10">Receiving</h2>
		<a class=" col-sm-1" href="/landlord/profile/edit"><span class="icon icon-edit"></span></a>
			<table class="table-borderless table">
				<tr>
					<th>Pin</th>
					<td>{{ isset($landlord->gateway->pin) }}</td>
				</tr>
				<tr>
					<th>Key</th>
					<td>{{ isset($landlord->gateway->key) }}</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10">
			<h2 class="text-info m-t-0">Devices</h2>
		</div>
		<div class="col-sm-2">
			<a href="/sales/device/create?user_id={{ $landlord->id }}"><button class="col-sm-12 btn btn-primary">Add Device</button></a>
		</div>
	</div>
	<div class="row-fluid">
		<div class="col-sm-12 p-a well">
			<table class="devices-table table">
				<thead>
					<th>Address</th>
					<th>Apt.</th>
					<th>Alarm</th>
					<th>Status</th>
 d					<th>Serial</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($landlord->devices as $device)
					<tr>
						<td><a href="/sales/device/{{ $device->id }}">{{ $device->address . ', ' .  $device->city . ' ' . $device->state }}</a></td>
						<td>{{ $device->apt }}</td>
						<td>{{ $device->alarm->slug }}</td>
						<td>{{ $device->status }}</td>
						<td>{{ $device->serial }}</td>
						
						<td></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>


@endsection