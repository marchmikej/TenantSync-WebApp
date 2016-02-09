@extends('TenantSync::landlord/layout')

@section('content')
	<div>
		<div class="row">
			<div class="col-sm-12 card">
				<h4 class="card-header">Dashboard</h4>
		
				<div class="col-sm-3 card-column">
					<p class="text-center">Alarms</p>
					<p class="stat text-danger text-center">
						@if($landlord->devices)
						{{ 
							$landlord->devices->filter(function($device) {
								return $device->alarm_id;
							})
							->count()
						}}
						@endif
					</p>
				</div>
		
				<div class="col-sm-3 card-column">
					<p class="text-center">Rent Paid MTD</p>
					<p class="stat text-success text-center">
					@if($landlord->rentPayments())
					{{
						array_sum($landlord->rentPayments()->filter(function($rentPayment) 
							{
								return date('m', strtotime($rentPayment->date)) == date('m', time());
							})
						->pluck('amount')->toArray())
					}}
					@else {{ 0 }}
					@endif
					</p>
				</div>
		
				<div class="col-sm-3 card-column">
					<p class="text-center">Delinquency MTD</p>
					<p class="stat text-warning text-center">
					@if($landlord->rentBills->count() && $landlord->rentPayments())
				{{ 
					array_sum($landlord->rentBills->filter(function($rentBill) 
						{
							if($rentBill->vacant == 1)
							{
								return false;
							}
							return date('m', strtotime($rentBill->rent_month)) == date('m', time());
						})
					->pluck('bill_amount')->toArray()) - array_sum($landlord->rentPayments()->filter(function($rentPayment) 
						{
							return date('m', strtotime($rentPayment->date)) == date('m', time());
						})
					->pluck('amount')->toArray())
				}}
				@else {{ 0 }}
				@endif
					</p>
				</div>
				
				<div class="col-sm-3 card-column">
					<p class="text-center">Vacant Rent MTD</p>
					<p class="stat text-danger text-center">
					@if($landlord->rentBills->count())
					{{
						array_sum($landlord->rentBills->filter(function($rentBill) 
						{
							if($rentBill->vacant == 0)
							{
								return false;
							}
							return date('m', strtotime($rentBill->rent_month)) == date('m', time());
						})
						->pluck('bill_amount')->toArray())
					}}
					@else {{ 0 }}
					@endif
					</p>
				</div>
			</div>
		</div>

		@include('TenantSync::includes.tables.devices-table')
	
	</div>

@endsection

@section('scripts')

<script>
Vue.config.debug = true;

var vue = new Vue({
		el: '#app',
	});

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>

@endsection
