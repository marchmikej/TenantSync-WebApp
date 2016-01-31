@extends('TenantSync::landlord/layout')

@section('content')

	<div class="row">
		<div class="col-sm-6 p-r-md">
			<form id="property-form" action="/landlord/properties" method="POST" class="form form-horizontal">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="card row">
						<div class="col-sm-12">
						<h4 class="card-header">Address</h4>
							<div class="form-group">
								<label class="control-label col-sm-3" for="address">Address</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="address" placeholder="Address" value="{{ old('address') }}"/>
								</div>
							</div>
						
							<div class="form-group">
								<label class="control-label col-sm-3" for="city">City</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="city" placeholder="City" value="{{ old('city') }}"/>
								</div>
							</div>
						
							<div class="form-group">
						
								<label class="control-label col-sm-3" for="state">State</label>
								<div class="col-sm-4">
									<select class="form-control" name="state" id="state" >
										@foreach($states as $slug => $state)
											<option value="{{ $slug }}" >{{ strtoupper($slug) }}</option>
										@endforeach
									</select>
								</div>
									
								<label class="control-label col-sm-1" for="zip">Zip</label>
								<div class="col-sm-4">
									<input class="form-control" type="text" name="zip" placeholder="Zip" value="{{ old('zip') }}"/>
								</div>
							</div>
						</div>
				</div>
			</div>
				
			<div class="col-sm-6 p-l-md">
				<div class="row card">
						<div class="col-sm-12 form-horizontal">
						<h4 class="card-header">Financials</h4>
							<div class="form-group">
								<label class="control-label col-sm-3" for="purchase_price">Purchase Price</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="purchase_price" placeholder="Purchase Price" value="{{ old('purchase_price') }}">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3" for="purchase_date">Purchase Date</label>
								<div class="col-sm-9">
									<input class="form-control" type="date" name="purchase_date" placeholder="Purchase Date" value="{{ old('purchase_date') }}"/>
								</div>
							</div>
						
							<div class="form-group">
								<label class="control-label col-sm-3" for="closing_costs">Closing Costs</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="closing_costs" placeholder="Closing Costs" value="{{ old('closing_costs') }}"/>
								</div>
							</div>
						
							<div class="form-group">
								<label class="control-label col-sm-3" for="taxes">Taxes</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="taxes" placeholder="Taxes" value="{{ old('taxes') }}"/>
								</div>
							</div>
						
							<div class="form-group">
								<label class="control-label col-sm-3" for="expenses">Expenses</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="expenses" placeholder="Expenses" value="{{ old('expenses') }}"/>
								</div>
							</div>
						
							<div class="form-group">
								<label class="control-label col-sm-3" for="insurance">Insurance</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="insurance" placeholder="Insurance" value="{{ old('insurance') }}"/>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3" for="down_payment">Down Payment</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="down_payment" placeholder="Down Payment" value="{{ old('down_payment') }}"/>
								</div>
							</div>
						
							<div class="form-group">
								<label class="control-label col-sm-3" for="mortgage_rate">Mortgage Rate(%)</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="mortgage_rate" placeholder="Mortgage Rate" value="{{ old('mortgage_rate') }}"/>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3" for="mortgage_term">Loan Term(yrs)</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="mortgage_term" placeholder="Mortgage Term" value="{{ old('mortgage_term') }}"/>
								</div>
							</div>
						</div>
					</div>
				</div>

				<button form="property-form" class="form-control col-sm-2 col-sm-offset-10 btn btn-primary">Create</button>
			</form>
		</div>
	</div>

@endsection

@section('scripts')

<script>
	vue =  new Vue({

		el: '#property-form',

		data: {

		},

		methods: {

		}

	})
</script>

@endsection