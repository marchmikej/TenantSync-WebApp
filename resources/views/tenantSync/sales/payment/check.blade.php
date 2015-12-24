@extends('TenantSync::sales/layout')

@section('content')
<div class="row">
	<div class="col-sm-6 col-sm-offset-3">
	<h2 class="text-primary p-b">Check Info</h2>
		<form class="form" action="/sales/payment/card" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="form-group">
				<label class="control-label col-sm-3" for="name">Name</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="name" placeholder="Cardholder Name"/>
				</div>
			</div> 
			<div class="form-group">
				<label class="control-label col-sm-3" for="card_number">Card Number</label>
				<div class="col-sm-9">
					<input class="form-control" type="text" name="card_number" placeholder="Card Number"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3" for="exp">Expiration/CVV</label>
				<div class="col-sm-9">
					<input class="form-control col-sm-6" type="text" name="exp" placeholder="Exp.  mm/yy"/>
					<input class="form-control col-sm-6" type="text" name="cvv2" placeholder="CVV2"/>
				</div>
			</div>
			<div class="col-sm-3 col-sm-offset-9">
				<button class="form-control btn btn-primary-outline">Verify</button>
			</div>
		</form>
	</div>
</div>
			

@endsection