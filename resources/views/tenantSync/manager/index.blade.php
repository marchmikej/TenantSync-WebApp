@extends('TenantSync::manager/layout')

@section('content')
	<div>
		<div class="row">
			<div class="col-sm-12 card">
				<h4 class="card-header">Dashboard</h4>
		
				<div class="col-sm-3 card-column">
					<p class="text-center">Revenue</p>
					<!-- <div class="w-md m-x-auto">
					  <canvas
					    class="ex-graph"
					    width="200" height="200"
					    data-chart="doughnut"
					    data-value="[{ value: 230, color: '#1ca8dd', label: 'Returning' }, { value: 130, color: '#1bc98e', label: 'New' }]"
					    data-segment-stroke-color="#fff">
					  </canvas>
					</div> -->
				</div>
		
				<div class="col-sm-3 card-column">
					<p class="text-center">Rent Paid MTD </p>
					<p class="stat text-success text-center">
					@if($manager->rentPayments())
					{{
						array_sum($manager->rentPayments()->filter(function($rentPayment) 
							{
								return date('m', strtotime($rentPayment->created_at)) == date('m', time());
							})
						->pluck('amount')->toArray())
					}}
					@endif
					</p>
				</div>
		
				<div class="col-sm-3 card-column">
					<p class="text-center">Deliquent Rent MTD</p>
					<p class="stat text-warning text-center">
					@if($manager->rentBills()->count() && $manager->rentPayments())
					{{ 
						array_sum($manager->rentBills()->filter(function($rentBill) 
							{
								if($rentBill->vacant == 1)
								{
									return false;
								}
								return date('m', strtotime($rentBill->rent_month)) == date('m', time());
							})
						->pluck('bill_amount')->toArray()) - array_sum($manager->rentPayments()->filter(function($rentPayment) 
							{
								return date('m', strtotime($rentPayment->created_at)) == date('m', time());
							})
						->pluck('amount')->toArray())
					}}
					@endif
					</p>
				</div>
				
				<div class="col-sm-3 card-column">
					<p class="text-center">Vacant Rent MTD</p>
					<p class="stat text-danger text-center">
					@if($manager->rentBills()->count())
					{{
						array_sum($manager->rentBills()->filter(function($rentBill) 
						{
							if($rentBill->vacant == 0)
							{
								return false;
							}
							return date('m', strtotime($rentBill->rent_month)) == date('m', time());
						})
						->pluck('bill_amount')->toArray())
					}}
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
	
		data: {

			sortKey: 'rent_amount',

			reverse: -1,
		},

		methods: {
			fetchDevices: function(page, sortKey, reverse) {
				var append = this.generateUrlVars({with: ['property', 'alarm'], paginate: this.paginate, sort: sortKey, page: page, asc: reverse});

				this.$http.get('/manager/device/all?' + append)
				.success(function(result) {
					for(var i = 0; i < result.data.length; i++)
					{
						result.data[i].rent_amount = Number(result.data[i].rent_amount);
					}
					this.devices = result.data;
					this.paginated = result;
					this.page = result.current_page;
				});
			},

			refreshTable: function(sortKey, reverse)
			{
				this.fetchDevices(1, sortKey, reverse);
			},
		}
	});

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>

@endsection
