@extends('TenantSync::landlord/layout')

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
					@if($landlord->rentPayments())
					{{
						array_sum($landlord->rentPayments()->filter(function($rentPayment) 
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
					@endif
					</p>
				</div>
			</div>
		</div>
		<div class="row card">
			<div class="col-sm-12">
				<h4 class="card-header"><a href="/landlord/device">Devices</a></h4>
				<div class="table-heading row">
					<div v-for="column in columns" @click="sortBy($index)" :class="[column.width, column.isSortable ? 'sortable' : '' ]">@{{ toTitleCase(column.name) }}<span :class="sortKeyClasses($index)"></span></div>
				</div>
		
				<div class="table-body table-striped">
					<div v-for="device in devices | orderBy sortKey reverse" class="table-row row">
						<div class="col-sm-6">@{{ device.property.address + ', ' }}<a :href="'/landlord/device/' + device.id">@{{ device.location }}</a></div>
						<div class="col-sm-2">@{{ device.rent_amount }}</div>
						<div class="col-sm-2">@{{ device.status }}</div>
						<div class="col-sm-2">@{{ device.alarm ? device.alarm.slug : 'Off' }}</div>
					</div>
				</div>
				<div class="col-sm-4 col-sm-offset-4 text-center">d</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')

<script>
Vue.config.debug = true;

Vue.mixin({
  created: function () {
    var sortKey = '';
    var reverse = 1;
  }
})

var vue = new Vue({
		el: '#app',
	
		data: {

			columns: [
				{
					name: 'address',
					width: 'col-sm-6',
					isSortable: false
				},
				{
					name: 'rent_amount',
					width: 'col-sm-2',
					isSortable: true
				},
				{
					name: 'status',
					width: 'col-sm-2',
					isSortable: true
				},
				{
					name: 'alarm',
					width: 'col-sm-2',
					isSortable: true
				}
			],


			devices: [],

			paginated: null,
		},
	
		ready: function() {
			this.fetchDevices();
		},

		methods: {
			fetchDevices: function() {
				// var include = ['property', 'alarm'].map(function(item) {
				// 	return 'with[]=' + item;
				// }).join('&');
				var append = this.generateUrlVars({ with: ['property', 'alarm'], paginate: this.paginate, sort: this.sortKey});

				console.log();
				this.$http.get('/landlord/device/all?' + append)
				.success(function(result) {
					for(var i = 0; i < result.data.length; i++)
					{
						result.data[i].rent_amount = Number(result.data[i].rent_amount);
					}
					this.devices = result.data;
					this.paginated = result;
				});
			},
		}
	});

</script>

@endsection
