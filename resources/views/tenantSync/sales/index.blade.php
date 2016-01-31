@extends('TenantSync::sales/layout')

@section('content')

	<div class="row card">
		<div class="col-sm-6">
			<h1 class="m-t-0 text-info">
				Landlords<a href="/sales/register"><button class=" btn btn-clear text-muted p-y-0"><h3 class="m-a-0 icon icon-plus"></h3></button></a>
			</h1>
				
			<table id="landlord-table" class="table">
				<thead>
					<!-- <th><input type="checkbox" name="landlords[]"></th> -->
					<th>Name</th>
					<th>Address</th>
					<th>Email</th>
					<th>Phone</th>
				</thead>
				<tbody>
					@foreach($landlords as $landlord)
					<tr>
						<!-- <td><input type="checkbox" name="landlords[]"></td> -->
						<td>{{ $landlord->profile->first_name.' '.$landlord->profile->last_name }}</td>
						<td>{{ $landlord->profile->address }}</td>
						<td><a href="/sales/landlord/{{$landlord->id}}">{{ $landlord->email }}</a></td>
						<td>{{ $landlord->profile->phone }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-sm-6">
			<h1 class="m-t-0 text-info">
				Devices
			</h1>
				
			<table id="device-table" class="table">
				<thead>
					<!-- <th><input type="checkbox" name="devices[]"></th> -->
					<th>Location</th>
					<th>Alarm</th>
					<th>Status</th>
				</thead>
				<tbody>
					@foreach($devices as $device)
					<tr>
						<!-- <td><input type="checkbox" name="devices[]"></td> -->
						<td><a href="/sales/device/{{$device->id}}">{{ $device->property->address . ' ' . $device->location }}</a></td>
						<td>{{ $device->alarm }}</td>
						<td>{{ $device->status }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection
