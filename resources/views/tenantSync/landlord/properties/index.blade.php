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
				@else {{ 0 }}
				@endif
				</p>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center">Delinquency YTD</p>
				<p class="stat text-warning text-center">
				@if($landlord->rentBills->count() && $landlord->rentPayments())
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
				@else {{ 0 }}
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
				@else {{ 0 }}
				@endif
				</p>
			</div>
		</div>
	</div>

	@include('TenantSync::includes.tables.portfolio-table')

	
</div>



@endsection

@section('scripts')

	<script>

		var vue = new Vue({
			

			el: '#app',


			// data: {

				

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