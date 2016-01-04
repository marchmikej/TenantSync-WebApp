@extends('TenantSync::landlord/layout')
@section('heading')
<!-- Transactions -->
@endsection

@section('head')
	<meta id="user_id" value="{{ $user->id }}">
@endsection

@section('content')

<div id="container">
	
	<div class="row">
		<h4 class="text-primary"><strong>Dashboard</strong></h4>
		<div class="col-sm-12 card">
			<div class="col-sm-3">
				<p class="text-center"><strong>Rent Paid</strong></p>
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
			<div class="col-sm-3">
				<p class="text-center"><strong>Vacancies</strong></p>
				<h3 class="text-primary text-center">5%</h3>
			</div>
			<div class="col-sm-3">
				<p class="text-center"><strong>Something here</strong></p>
				<h3 class="text-danger text-center">900</h3>
			</div>
			<div class="col-sm-3">
				<p class="text-center"><strong>Something Else</strong></p>
				<h3 class="text-warning text-center">30%</h3>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12 card">
			<div class="col-sm-6">
				<table class="table table-striped">
					<h3 class="text-info m-t-0">
						Properties
					</h3>
				
					<thead>
						<th>Location</th>
						<th>Status</th>
						<th>Alarm</th>
						<th>More</th>
						<th>ROI</th>
						<!-- <th></th> -->
					</thead>
					<tbody>
						<tr v-for="property in properties">
							<td><a href="/manager/properties/@{{ property.id }}">@{{property.address + ', ' + property.city}}</a></td>
							<td>@{{property.id }}</td>
							<td>@{{property.id }}</td>
							<td>@{{property.id }}</td>
							<td>@{{property.id }}</td>
							<!-- <td><button v-on="click: generateModal( transaction.id )" class="btn btn-clear"><span class="text-primary icon icon-edit"></span></button></td> -->
							<!-- <td><button v-on="click: deleteTransaction( transaction.id )" class="btn btn-clear"><span class="text-danger icon icon-cross"></span></button></td> -->
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col-sm-6">
				<table class="table table-striped">
					<h3 class="text-info m-t-0">
						Maintenance<!-- <button v-on="click: generateModal(), click: modal.expense = false" class=" btn btn-clear text-primary"><h3 class="m-a-0 icon icon-plus"></h3></button> -->
					</h3>
				
					<thead>
						<th>Status</th>
						<th>Request</th>
						<th>Days</th>
						<th>Attempts</th>
						<!-- <th></th> -->
					</thead>
					<tbody>
						<tr v-for="maintenance in maintenanceRequests">
							<td><a href="/landlord/maintenance/@{{ maintenance.id }}">@{{maintenance.request}}</a></td>
							<td>@{{maintenance.status.substr(0, 1).toUpperCase() + maintenance.status.substr(1)}}</td>
							<td>@{{maintenance.status}}</td>
							<td>@{{maintenance.status}}</td>
							<!-- <td><button v-on="click: generateModal( transaction.id )" class="btn btn-clear"><span class="text-primary icon icon-edit"></span></button></td> -->
							<!-- <td><button v-on="click: deleteTransaction( transaction.id )" class="btn btn-clear"><span class="text-danger icon icon-cross"></span></button></td> -->
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>

	<!--// MODAL -->
	<div v-show="showModal" id="modal" class="vue-modal" style="display: none;">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
		      	<!-- <div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title text-info">Edit Transaction</h4>
		      	</div> -->
		      	<form @keyup.enter=" submitTransaction" class="form form-horizontal">
		      		<meta type="hidden" id="_token" value="{{ csrf_token() }}">
		      		<div class="modal-body">
		        		<div class="form-group">
		        			<label class="control-label col-sm-3" for="amount">Amount</label>
		        			<div class="col-sm-9">
		        				<input id="modal-amount" class="form-control" type="text" name="amount" placeholder="Amount" v-model="modal.amount"/>
		        			</div>
		        		</div>
		        		<div class="form-group">
		        			<label class="control-label col-sm-3" for="description">Description</label>
		        			<div class="col-sm-9">
		        				<input class="form-control" type="text" name="description" placeholder="Description" v-model="modal.description"/>
		        			</div>
		        		</div>
		      		</div>
			      	<div class="modal-footer">
			        	<button @click=" showModal = false" type="button" class="btn btn-default">Close</button>
			        	<button  @click=" submitTransaction" type="button" class="btn btn-primary">Save changes</button>
			      	</div>
		      	</form>
	    	</div><!-- /.modal-content -->
	  	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<pre>@{{ $data | json }}</pre>
</div>



@endsection

@section('scripts')

	<script>
	var vue = new Vue({
		el: '#container',

		data: {
			properties: [],

			maintenanceRequests: [],
		},

		ready: function(){
			this.fetchProperties();
			this.fetchMaintenance();
		},

		methods: {
			fetchProperties: function(){
				this.$http.get('/manager/properties/all')
				.success(function(properties){
					this.properties = properties;
				});
			},

			fetchMaintenance: function(){
				this.$http.get('/manager/maintenance/all')
				.success(function(maintenanceRequests){
					this.maintenanceRequests = maintenanceRequests;
				});
			}
		}

	});
	</script>


@endsection