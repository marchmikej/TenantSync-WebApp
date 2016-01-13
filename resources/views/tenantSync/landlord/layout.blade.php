@extends('TenantSync::bare')
@include('TenantSync::globals')

@section('topmenu')

	@if($user->role == 'landlord')
		<ul class="nav navbar-nav navbar-right">
			<li><a href="/landlord/properties">Portfolio</a></li>
			<li><a href="/landlord/device">Device Manager</a></li>
			<li><a href="/landlord/transaction">Accounting</a></li>
			<li><a href="/landlord/calculator">Calculator</a></li>
			<li><a href="/landlord/calendar">Calendar</a></li>
			<li class="dropdown">
		</ul>
	@elseif($user->role == 'manager')
		<ul class="nav navbar-nav navbar-right">
			<li><a href="/manager/calendar">Calendar</a></li>
			<!-- <li><a href="/landlord/maintenance">Maintenance</a></li> -->
			<li class="dropdown">
		</ul>
	@endif

@endsection