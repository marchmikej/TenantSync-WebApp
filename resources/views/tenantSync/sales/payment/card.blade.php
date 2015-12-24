@extends('TenantSync::sales/layout')

@section('content')
<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
	<h2 class="text-primary p-b">Card Info</h2>
		<form class="form" action="/sales/payment/card" method="POST">
			@include('TenantSync::partials.card-inputs')
			<div class="col-sm-3 col-sm-offset-9">
				<button class="form-control btn btn-primary-outline">Verify</button>
			</div>
		</form>
	</div>
</div>
			

@endsection