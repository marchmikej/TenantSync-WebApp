@extends('TenantSync::bare')

@section('topmenu')

		<!-- <ul class="nav navbar-nav navbar-right"> -->
			@if(Auth::user()->role ==  'landlord')
			<li><a href="/{{Auth::user()->role}}/properties">Portfolio</a></li>
			@endif
			<li><a href="/{{Auth::user()->role}}/device">Device Manager</a></li>
			<li><a href="/{{Auth::user()->role}}/transaction">Accounting</a></li>
			@if(Auth::user()->role ==  'landlord')
			<li><a href="/{{Auth::user()->role}}/calculator">Calculator</a></li>
			@endif
			<li><a href="/{{Auth::user()->role}}/calendar">Calendar</a></li>

			<li class="dropdown">
				<a 
					class="dropdown-toggle" 
					id="dropdownMenu1" 
					data-toggle="dropdown" 
					aria-haspopup="true" 
					style="background-color: transparent !important;"
				>
			  		<span class="icon icon-menu" style="font-size: 1.2em;"></span>
				</a>
				
			  	<ul class="dropdown-menu nav-dropdown" aria-labelledby="dropdownMenu1">
			    	<li><a href="/{{Auth::user()->role}}/profile">Profile</a></li>
			    	<li><a href="/{{Auth::user()->role}}/notifications">Notifications</a></li>

			    	@if(Auth::user()->role ==  'landlord')
			    	<li><a href="/{{Auth::user()->role}}/managers">Managers</a></li>
			    	@endif

				    <li role="separator" class="divider"></li>
				    <li><a href="/logout">Logout</a></li>
				</ul>
			</li>
		<!-- </ul> -->

@endsection