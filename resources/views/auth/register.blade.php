@extends('TenantSync::bare')

@section('content')
<div class="container-fluid">
	<div class="row card">
		<div class="col-md-12">
			<div class="">
				<div class="">

					<form id="register-form" class="form-horizontal" role="form" method="POST" action="/sales/register">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						
						<div class="col-sm-6">
							<h2 class="text-info">Landlord Info</h2>
							
							<input type="hidden" name="role_id" value="2">

							<div class="form-group">
								<label class="col-md-4 control-label">First Name</label>
								<div class="col-md-6">
									<input type="first_name" class="form-control" name="first_name" value="{{ old('first_name') }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Last Name</label>
								<div class="col-md-6">
									<input type="last_name" class="form-control" name="last_name" value="{{ old('last_name') }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">E-Mail Address</label>
								<div class="col-md-6">
									<input type="email" class="form-control" name="email" value="{{ old('email') }}">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Phone Number</label>
								<div class="col-md-6">
									<input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
								</div>
							</div>

							<!-- <div class="form-group">
								<label class="col-md-4 control-label">Password</label>
								<div class="col-md-6">
									<input type="password" class="form-control" name="password">
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Confirm Password</label>
								<div class="col-md-6">
									<input type="password" class="form-control" name="password_confirmation">
								</div>
							</div> -->
						</div>

						<div class="col-sm-6">
							<h2 class="text-info">Payment Info</h2>
							<div class="form-group">
								<label class="control-label col-sm-3" for="type">Payment Method</label>
								<div class="col-sm-9">
									<select name="type" class="form-control" id="payment-type">
										<option value="card">Credit Card</option>
										<option value="ach">Bank Transfer</option>
									</select>
								</div>
							</div>

							
							<div class="form-group">
								<div class="col-md-6 col-sm-offset-6">
									<button id="register-button" class="form-control btn btn-primary">
										Register
									</button>
								</div>
							</div>
						
						</div>	
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')

<script>
	function showPaymentFields()
	{
		var e = document.getElementById("payment-type");
		var strUser = e.options[e.selectedIndex].value;

		for (i=0; i < e.options.length; i++)
		{
			if (strUser == e.options[i].value)
			{
				document.getElementById(strUser+'-inputs').style.display = 'block';
			}
			else
			{
				document.getElementById(e.options[i].value+'-inputs').style.display = 'none';
			}
		}
	}

	$('#payment-type').change(showPaymentFields);
	showPaymentFields();

</script>
@endsection
