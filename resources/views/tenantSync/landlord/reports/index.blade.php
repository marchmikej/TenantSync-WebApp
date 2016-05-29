@extends('TenantSync::manager/layout')

@section('content')

<h1>Reports</h1>

<div class="form-group">
	<a href="/landlord/getreports/overdueusage">
		<button class="button">
			Overdue Usage
		</button>
	</a>
</div>
<div class="form-group">
	<a href="/landlord/getreports/printdevices">
		<button class="button">
			My Devices
		</button>
	</a>
</div>
@endsection