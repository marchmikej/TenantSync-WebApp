@extends('TenantSync::landlord/layout')

@section('content')

<div class="row" id="calculator">
	<div class="card col-sm-12">
		<h3 class="card-header">Aquisition Calculator</h3>
		<form  class="form form-horizontal" @keydown.enter="calculateRoi">
			<div class="col-sm-6 p-x-md">
				<div class="form-group">
					<label class="control-label" for="address">Address</label>
					<input v-model="property.address" class="form-control" type="text" name="address" placeholder="Address" value="{{ old('address') }}"/>
				</div>
				
				<div class="form-group">
					<label class="control-label" for="city">City</label>
					<input v-model="property.city" class="form-control" type="text" name="city" placeholder="City" value="{{ old('city') }}"/>
				</div>
				
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<label class="control-label" for="city">State</label>
							<select v-model="property.state" class="form-control" name="state" id="state">
								<option></option>
								@foreach($states as $slug => $state)
									<option value="{{ $slug }}">{{ ucfirst(strtolower($state)) }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-sm-6">
							<label class="control-label" for="zip">Zip</label>
							<input class="form-control" type="zip" name="zip" placeholder="Zip" value="{{ old('zip') }}"/>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-6 p-x-md">
				<div class="form-group">
					<label class="control-label" for="purchase_price">Purchase Price</label>
					<input v-model="property.purchasePrice" class="form-control" type="text" name="purchase_price" placeholder="Purchase Price" value="{{ old('purchase_price') }}"/>
				</div>

				<div class="form-group">
					<label class="control-label" for="rent_income">Rent</label>
					<input v-model="property.rent" class="form-control" type="text" name="rent_income" placeholder="Monthly Rent Income" value="{{ old('annual_rent_income') }}"/>
				</div>

				<div class="form-group">
					<div class="row ">
						<div class="col-sm-6">
							<label class="control-label" for="taxes">Taxes</label>
							<input v-model="property.taxes" class="form-control" type="text" name="taxes" placeholder="Annual Taxes" value="{{ old('taxes') }}"/>
						</div>
						
						<div class="col-sm-6">
							<label class="control-label" for="expenses">Expenses</label>
							<input v-model="property.expenses" class="form-control" type="text" name="expenses" placeholder="Annual Expenses" value="{{ old('expenses') }}"/>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-2 col-sm-offset-10">
					<button id="submitButton" @click="calculateRoi" class="btn btn-primary form-control">Calculate</button>
				</div>
			</div>
		</form>
	</div>


	<div class="row">
		<div class="col-sm-6">
			<div v-show="estimatedRoi" style="display: none;" class="col-sm-12">
				<h3 class="text-info text-center m-t-0">Estimated ROI</h3>
				<h1 class="text-success text-center">@{{ Math.round(estimatedRoi * 1000) / 10 }}</h1>
			</div>
		</div>
	</div>
</div>
</div>

@endsection

@section('scripts')

	<script>
	var calculator = new Vue({

		el: '#calculator',

		data: {
			property: {
				address: '',
				city: '',
				state: '',
				zip: '',
				purchasePrice: '',
				rent: '',
				taxes: '',
				expenses: ''
			},
			estimatedRoi: '',
		},

		methods: {

			calculateRoi: function(e) {
				e.preventDefault();
				this.$http.get('/landlord/calculator/estimate_roi', this.property)
				.success(function(roi){
					this.estimatedRoi = roi;
					console.log(roi);
				});
			}
		}

	})
	</script>

@endsection