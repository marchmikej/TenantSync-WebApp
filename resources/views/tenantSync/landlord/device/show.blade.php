@extends('TenantSync::landlord/layout')

@section('content')
<div id="device">
	<!-- <div class="row">
		<div class="col-sm-12 card">
			<h4 class="m-t-0 text-primary card-header">{{ $device->location }}</h4>
			<div class="col-sm-3 card-column">
				<p class="text-center m-t-0">ROI</p>
				<h3 class="stat text-center text-success">-</h3>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center m-t-0">Maintenance</p>
				<h3 class="stat text-center text-danger">-</h3>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center m-t-0">Messages</p>
				<h3 class="stat text-center text-info">-</h3>
			</div>
			<div class="col-sm-3 card-column">
				<p class="text-center m-t-0">Something</p>
				<h3 class="stat text-center text-primary">-</h3>
			</div>
		</div>
	</div> -->

			<div class="row">
				<h4 class="text-primary"><a href="/landlord/properties/{{ $device->property->id }}">{{ $device->property->address . ', ' . $device->property->city }}</a></h4>

				<div class="col-sm-6 p-r-md">
					<div class="card row">
						<div class="col-sm-12">
							<h3 class="card-header">
								Recent Maintenance
							</h3>
							<div class="row table-heading">
								<div class="col-sm-2">Unit</div>
								<div class="col-sm-10">Request</div>
							</div>
							<div class="scrollable">
								<div class="table-body table-striped">
									<div v-for="maintenance in maintenanceRequests" class="table-row row">
										<div class="col-sm-2">@{{ maintenance.device.location }}</div>
										<div class="col-sm-10"><a href="/landlord/maintenance/@{{ maintenance.id }}">@{{ maintenance.request }}</a></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-6 p-l-md">
					<div class="row card">
						<div class="col-sm-12 p-x">
							<h4 class="card-header">Chat</h4>
							<div class="row h-sm scrollable" id="chat">
								@foreach( $device->messages as $message)
									
											<p class="well {{ ($message->is_from_device) ? 'well-blue text-white m-r-md' : 'm-l-md' }}">
												{{ $message->body }}
											</p>
									
								@endforeach
							</div>
							<div class="row">
								<form class="form row" action="/landlord/device/message" method="POST">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="device_id" value="{{ $device->id }}">
									<div class="form-group">
										<div class="col-sm-12 p-l">
											<textarea name="message" id="" cols="" rows="2" class="form-control" placeholder="Type your reply here..."></textarea>
											<button class="form-control btn btn-primary">Reply</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>

			</div>


			<div class="row">
				<div class="col-sm-12 card">
					<div class="col-sm-6">
						<h3 class="card-header m-t-0">Info</h3>
						<form id="device-form" action="/landlord/device/{{$device->id}}" method="POST" class="form form-horizontal">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="_method" value="PATCH">
							<div class="form-group">
								<label class="control-label col-sm-3" for="location">Location</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="location" placeholder="Location" value="{{$device->location}}"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3" for="rent_amount">Amount Rent</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="rent_amount" placeholder="Amount Rent" value="{{ $device->rent_amount }}"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3" for="rent_due">Rent due next</label> 
								<div class="col-sm-9">
									<input class="form-control" type="date" name="rent_due" placeholder="mm/dd/yyy" value="{{ $device->rent_due }}"/>
								</div> 
							</div>	

							<h3 class="card-header m-t">Occupancy</h3>

							<div class="form-group">
								<label class="control-label col-sm-3" for="occupancy">Occupancy</label>
								<div class="col-sm-9">
									<select name="vacant" class="form-control">
										<option value="0">Occupied</option>
										<option value="1" {{ $device->vacant ? 'selected' : '' }}>Vacant</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3" for="contact_name">Contant Name</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="contact_name" placeholder="Contant Name" value="{{ $device->contact_name }}"/>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3" for="contact_phone">Contact Phone</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="contact_phone" placeholder="Contact Phone" value="{{ $device->contact_phone }}"/>
								</div>
							</div>

						</div>

						<div class="col-sm-6 form-horizontal">
							<h3 class="card-header ">Payments</h3>

							<div class="form-group">
								<label class="control-label col-sm-3" for="grace_period">Grace Period</label>
								<div class="col-sm-2">
									<input class="form-control" type="text" name="grace_period" placeholder="Grace Period" value="{{ $device->grace_period }}"/>
								</div>
								<label class="control-label col-sm-7" for="grace_period">days.</label>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-3" for="late_fee">Late Fee</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="late_fee" placeholder="Late Fee" value="{{ $device->late_fee }}"/>
								</div>
							</div>
						</form>
					</div>
					<button @click="submitForm" class="form-control col-sm-4 col-sm-offset-8 btn btn-primary">Save</button>
				</div>
			</div>
		</div>

@endsection 

@section('scripts')

<script>
	var element = document.getElementById("chat");
	element.scrollTop = element.scrollHeight;

	function updateScroll(){
	    var element = document.getElementById("chat");
	    element.scrollTop = element.scrollHeight;

	    //call updateScroll when new content is added
	}
</script>

<script>
	vue = new Vue({
	
		el: "#device",

		data: {
			device: {

			},
			maintenanceRequests: {},
			
		},

		ready: function() {
			this.fetchMaintenance();
		},

		methods: {
			fetchMaintenance: function() {
				this.$http.get('/landlord/maintenance/all')
				.success(function(maintenanceRequests) {
					this.maintenanceRequests = maintenanceRequests;
				});
			},

			submitForm: function() {
				$('#device-form').submit();
			}
		}
	})
</script>

@endsection

