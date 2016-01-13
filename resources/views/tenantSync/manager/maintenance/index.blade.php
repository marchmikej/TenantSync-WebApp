@extends('TenantSync::manager/layout')

@section('content')

@foreach($maintenanceRequests as $maintenanceRequest)

	<div class="row">

	    MaintenanceRequest :<a href="/landlord/maintenance/{{ $maintenanceRequest->id }}"> {{ $maintenanceRequest->id}}</a>

	</div>
	
	
		<div class="row" >{{ $maintenanceRequest->request }} <br>
		STATUS :{{ $maintenanceRequest->status }}</div><br><br>

@endforeach

@endsection