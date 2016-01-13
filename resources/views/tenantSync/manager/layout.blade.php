@extends('TenantSync::bare')
@include('TenantSync::globals')

@section('topmenu')

		<ul class="nav navbar-nav navbar-right">
			<li><a href="/manager/device">Device Manager</a></li>
			<li><a href="/manager/transaction">Accounting</a></li>
			<li><a href="/manager/calculator">Calculator</a></li>
			<li><a href="/manager/calendar">Calendar</a></li>
			<li class="dropdown">
		</ul>

@endsection