@extends('TenantSync::landlord/layout')

@section('content')

<div id="portfolio">
	<div class="row card">
		<div class="col-sm-12">
			<h4 class="card-header">Overview</h4>
			<div class="col-sm-3 card-column">
				<p class="text-center">ROI YTD</p>
				<p class="stat text-primary text-center">{{ round($roi, 2)*100 }}%</p>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center">Revenue YTD</p>
				<p class="stat text-success text-center">
				@if($landlord->transactions->count())
				{{ 
				array_sum($landlord->transactions->filter(function($transaction) 
					{
						return $transaction->amount > 0;
					}
				) 
				->pluck('amount')->toArray())
				}}
				@endif
				</p>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center">Delinquency YTD</p>
				<p class="stat text-warning text-center">
				@if($landlord->rentBills->count())
				{{ 
					array_sum($landlord->rentBills->filter(function($rentBill) 
						{
							if($rentBill->vacant == 1)
							{
								return false;
							}
							return date('Y', strtotime($rentBill->rent_month)) == date('Y', time());
						})
					->pluck('bill_amount')->toArray()) - array_sum($landlord->rentPayments()->filter(function($rentPayment) 
						{
							return date('Y', strtotime($rentPayment->created_at)) == date('Y', time());
						})
					->pluck('amount')->toArray())
				}}
				@endif
				</p>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center">Vacancy YTD</p>
				<p class="stat text-danger text-center">
				@if($landlord->rentBills->count())
				{{
					array_sum($landlord->rentBills->filter(function($rentBill) 
					{
						if($rentBill->vacant == 0)
						{
							return false;
						}
						return date('Y', strtotime($rentBill->rent_month)) == date('Y', time());
					})
					->pluck('bill_amount')->toArray())
				}}
				@endif
				</p>
			</div>
		</div>
	</div>

	<div class="row card">
		<div class="col-sm-12">
				<h4 class="card-header">
					Properties<!-- <button  class=" btn btn-clear text-primary"><h4 class="m-a-0 icon icon-plus"></h4></button> -->
				</h4>
				<div class="row table-heading">
					<div class="col-sm-5">Address</div>
					<div class="col-sm-2">ROI YTD</div>
					<div class="col-sm-2">Devices</div>
					<div class="col-sm-2">Value</div>
					<div class="col-sm-1"></div>
				</div>

				<div class="table-body table-striped">
				
						<div v-for="property in properties" class="table-row row">
							<div class="col-sm-5"><a href="/landlord/properties/@{{ property.id }}">@{{property.address + ', ' + property.city + ' ' + property.state}}</a></div>
							<div class="col-sm-2 text-success">@{{ numeral(property.roi).format('0.0 %') }}</div>
							<div class="col-sm-2 text-danger">@{{ property.devices.length }}</div>
							<div class="col-sm-2 text-primary">$@{{numeral(property.value).format('0,0.00')}}</div>
							<div @click="showDevices(property.id)" class="col-sm-1 btn btn-clear icon icon-plus p-y-0"></div>

							<div v-show="property.showDetails" class="sub-table bg-muted">
								<div class="table-row p-t-md p-b-md">
									<div class="col-sm-6">
										<div class="col-sm-6 text-left">Z-estimate</div>
										<div class="col-sm-6 text-right">$@{{ property.value ? numeral(property.value).format('0,0.00') : '-'}}</div>
										<div class="col-sm-6 text-left">Purchase Price</div>
										<div class="col-sm-6 text-right">$@{{ property.purchase_price ? numeral(property.purchase_price).format('0,0.00') : '-'}}</div>
										<div class="col-sm-6 text-left">Closing Costs</div>
										<div class="col-sm-6 text-right">@{{ property.closing_costs ? property.closing_costs : '-' }}</div>
										<div class="col-sm-6 text-left">Expenses</div>
										<div class="col-sm-6 text-right">@{{ property.expenses  ? property.expenses : '-'}}</div>
										<div class="col-sm-6 text-left">Taxes</div>
										<div class="col-sm-6 text-right">@{{ property.taxes ? property.taxes : '-' }}</div>
										<div class="col-sm-6 text-left">Insurance</div>
										<div class="col-sm-6 text-right">@{{ property.insurance ? property.insurance : '-' }}</div>
									</div>
									<div class="col-sm-6">
										<div class="col-sm-6 text-left">Mortgage Rate</div>
										<div class="col-sm-6 text-right">@{{ property.rent_due ? device.rent_due : '-' }}</div>
										<div class="col-sm-6 text-left">Mortgagae Payment</div>
										<div class="col-sm-6 text-right">@{{ property.mortgage_payment ? device.mortgage_payment : '-' }}</div>
										<div class="col-sm-6 text-left">Purchase Date</div>
										<div class="col-sm-6 text-right">@{{ property.purchase_date ? device.purchase_date : '-' }}</div>
<!-- 										<div class="col-sm-6 text-left">Aquisition Cost</div>
										<div class="col-sm-6 text-right">@{{ +property.down_payment + +property.closing_costs }}</div>
										<div class="col-sm-6 text-left">Appreciation</div>
										<div class="col-sm-6 text-right">@{{ property.value - property.purchase_price }}</div>
										<div class="col-sm-6 text-left">Appreciation / Aquisition</div>
										<div class="col-sm-6 text-right">@{{ (property.value - property.purchase_price) /  (property.down_payment + property.closing_costs) }}</div> -->
									</div>
								</div>
							</div>
						</div>

				</div>


		</div>
	</div>

	
</div>



@endsection

@section('scripts')

	<script>

		var vue = new Vue({
			

			el: '#portfolio',


			data: {

				properties: {
					
				},

				numeral: window.numeral,

			},


			ready: function() {
				this.fetchProperties();
				var numeral = numeral;
			},


			methods: {

				fetchProperties: function() {
					this.$http.get('/landlord/properties/all')
						.success( function(properties) {
							this.properties = properties;
						})
						.error( function() {
							console.log('Error fetching properties');
						});
				},

				showDevices: function(id) {
					if (typeof this.properties[id].showDetails === 'undefined')
					{
						this.$set('properties[' + id + '].showDetails', true);
					}
					else
					{
						this.properties[id].showDetails = !this.properties[id].showDetails;
					}
					
				}
			},


			// filters: {
			// 	numeric: function(array, field, operator, value ) {
			// 		return array.filter(function(item) {
			// 			console.log(item);
			// 			if (item.$value)
			// 			{
			// 				return math[operator](item.$value[field], value)  ? item : null;
			// 			}
			// 		});
			// 	}
			// }
		});
	</script>


@endsection