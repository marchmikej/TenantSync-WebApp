@extends('TenantSync::bare')
@include('TenantSync::globals')

@section('topmenu')

		<!-- <ul class="nav navbar-nav navbar-right"> -->
			<li><a href="/landlord/properties">Portfolio</a></li>
			<li><a href="/landlord/device">Device Manager</a></li>
			<li><a href="/landlord/transaction">Accounting</a></li>
			<li><a href="/landlord/calculator">Calculator</a></li>
			<li><a href="/landlord/calendar">Calendar</a></li>
			<li class="dropdown">
				<a class="dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" style="background-color: transparent !important;">
			  		<span class="icon icon-menu" style="font-size: 1.2em;"></span>
				</a>
			  	<ul class="dropdown-menu nav-dropdown" aria-labelledby="dropdownMenu1">
			    	<li><a href="/{{Auth::user()->role}}/profile">Profile</a></li>
			    	<li><a href="/landlord/managers">Managers</a></li>
				    <li role="separator" class="divider"></li>
				    <li><a href="/logout">Logout</a></li>
				</ul>
			</li>
		<!-- </ul> -->

@endsection