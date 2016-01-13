@extends('TenantSync::manager/layout')

@section('content')
	<div id="app">
		<div class="row">
			<div class="col-sm-12 card">
				<h4 class="card-header">Dashboard</h4>
		
				<div class="col-sm-3 card-column">
					<p class="text-center">Revenue</p>
					<div class="w-md m-x-auto">
					  <canvas
					    class="ex-graph"
					    width="200" height="200"
					    data-chart="doughnut"
					    data-value="[{ value: 230, color: '#1ca8dd', label: 'Returning' }, { value: 130, color: '#1bc98e', label: 'New' }]"
					    data-segment-stroke-color="#fff">
					  </canvas>
					</div>
				</div>
		
				<div class="col-sm-3 card-column">
					<p class="text-center">Rent Paid MTD</p>
					<p class="stat text-success text-center">
					@if($manager->landlord->rentPayments())
					{{
						array_sum($manager->landlord->rentPayments()->filter(function($rentPayment) 
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
					@if($manager->landlord->rentBills->count() && $manager->landlord->rentPayments())
					{{ 
						array_sum($manager->landlord->rentBills->filter(function($rentBill) 
							{
								if($rentBill->vacant == 1)
								{
									return false;
								}
								return date('m', strtotime($rentBill->rent_month)) == date('m', time());
							})
						->pluck('bill_amount')->toArray()) - array_sum($manager->landlord->rentPayments()->filter(function($rentPayment) 
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
					@if($manager->landlord->rentBills->count())
					{{
						array_sum($manager->landlord->rentBills->filter(function($rentBill) 
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
		<devices-table user-role="manager" inline-template>
			<div class="row card">
				<div class="col-sm-12">
					<h4 class="card-header">Devices</h4>
					<table-headers :columns="columns" :sort-key.sync="sortKey" :reverse.sync="reverse"></table-headers>
			
					<div class="table-body table-striped">
						<div v-for="device in devices | orderBy sortKey reverse" class="table-row row">
							<div class="col-sm-6"><a :href="'/manager/device/' + device.id">@{{ device.address }}</a></div>
							<div class="col-sm-2">@{{ device.rent_amount }}</div>
							<div class="col-sm-2">@{{ device.status }}</div>
							<div class="col-sm-2">@{{ device.alarm ? device.alarm.slug : 'Off' }}</div>
						</div>
					</div>
					<div class="col-sm-4 col-sm-offset-4 text-center">
						<button class="btn btn-clear text-primary"
							v-if="paginated.current_page > 1"
							@click="fetchPage(-1)" 
						>
							<span class="icon icon-chevron-left"></span>
						</button>
						<button class="btn btn-clear text-primary"
							v-if="paginated.last_page > paginated.current_page"
							@click="fetchPage(1)"
						>
							<span class="icon icon-chevron-right"></span>
						</button>
					</div>
				</div>
			</div>
		</devices-table>
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

		// 	paginate: 10,

		// 	columns: [
		// 		{
		// 			name: 'address',
		// 			label: 'address',
		// 			width: 'col-sm-6',
		// 			isSortable: false
		// 		},
		// 		{
		// 			name: 'rent_amount',
		// 			label: 'rent_amount',
		// 			width: 'col-sm-2',
		// 			isSortable: true
		// 		},
		// 		{
		// 			name: 'status',
		// 			label: 'status',
		// 			width: 'col-sm-2',
		// 			isSortable: true
		// 		},
		// 		{
		// 			name: 'alarm_id',
		// 			label: 'alarm',
		// 			width: 'col-sm-2',
		// 			isSortable: true
		// 		}
		// 	],


		// 	devices: [],
		},
	
		// ready: function() {
		// 	this.fetchDevices(1, this.sortKey, this.reverse);
		// },

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

@endsection
