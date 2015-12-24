@extends('TenantSync::landlord/layout')

@section('content')
	<div class="row">
		<div class="col-sm-12 card">
			<h4 class="card-header">Dashboard</h4>
			<div class="col-sm-3 card-column">
				<p class="text-center">Rent Paid</p>
				<div class="w-md m-x-auto">
				  <canvas
				    class="ex-graph"
				    width="200" height="200"
				    data-chart="doughnut"
				    data-value="[{ value: 230, color: '#1ca8dd', label: 'Returning' }, { value: 130, color: '#1bc98e', label: 'New' }]"
				    data-segment-stroke-color="#fff">
				  </canvas>
				</div>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center">Rent Unpaid</p>
				<p class="stat text-primary text-center">-</p>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center">Vacancies</p>
				<p class="stat text-danger text-center">-</p>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center">Something Else</p>
				<p class="stat text-warning text-center">-</p>
			</div>
		</div>
	</div>
	<div class="row card">
		<div class="col-sm-12">
			<h4 class="card-header"><a href="/landlord/device">Devices</a></h4>
			<div class="table-heading">
				<div class="col-sm-5">Address</div>
				<div class="col-sm-5">Unit</div>
				<div class="col-sm-2">Alarm</div>
			</div>

			<div class="table-body table-striped">
				@foreach($devices as $device)
					<div class="table-row row">
						<div class="col-sm-5">{{ $device->property->address }}</div>
						<div class="col-sm-5">{{ $device->location }}</div>
						<div class="col-sm-2">{{ $device->alarm ? $device->alarm->slug : 'Off' }}</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>

@endsection
