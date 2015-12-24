@extends('TenantSync::landlord/layout')

@section('content')

	<div class="row">
		<h4 class="m-t-0 text-primary">{{ $device->location }}</h4>
	</div>
			<div class="row">
				<div class="col-sm-12 card">
					<div class="col-sm-8">
						<h3 class="text-info m-t-0">Maintenance</h3>
						<table class="table">
							<thead>
								<th>Status</th>
								<th>Request</th>
								<th>Days</th>
							</thead>
						@foreach( $device->maintenanceRequests as $maintenanceRequest)
							@if($maintenanceRequest->status == 'open')
							<tr>
								<td>{{ ucfirst($maintenanceRequest->status) }}</td>
								<td><a href="/landlord/maintenance/{{$maintenanceRequest->id}}">{{ $maintenanceRequest->request }}</a></td>
								<td class="text-danger">{{ $maintenanceRequest->daysOpen() }}</td>
							</tr>
							@endif
						@endforeach
						</table>
					</div>
					<div class="col-sm-4 p-l b-l">
						<!-- <h4>Chat</h4> -->
						<div class="row h-md scrollable" id="chat">
							@foreach( $device->messages as $message)
								
										<p class="well {{ ($message->is_from_device) ? 'well-blue text-white m-r-lg' : 'm-l-lg' }}">
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
			<div class="row">
				<div class="col-sm-12 card">
				<div class="col-sm-6">
						<h3 class="text-info m-t-0">Info</h3>
						<form class="form form-horizontal">
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
								<label class="control-label col-sm-3" for="rent_due">Rent due on the</label> 
								<div class="col-sm-2">
									<input class="form-control" type="text" name="rent_due" placeholder="Rent Due" value="{{ $device->rent_due }}"/>
								</div> 
								<label class="control-label col-sm-7">of the month.</label>
							</div>
						</form>
						<h3 class="text-info">Occupancy</h3>
						<form class="form form-horizontal">
							<div class="form-group">
								<label class="control-label col-sm-3" for="occupancy">Occupancy</label>
								<div class="col-sm-9">
									<select name="occupancy" class="form-control">
										<option value="occupied">Occupied</option>
										<option value="vacant">Vacant</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3" for="contact_name">Contant Name</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="contact_name" placeholder="Contant Name" value="{{ $device->contant_name }}"/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-3" for="contact_phone">Contact Phone</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="contact_phone" placeholder="Contact Phone" value="{{ $device->contact_phone }}"/>
								</div>
							</div>
						</form>
					</div>
					
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

<script src="/js/device.js"></script>

@endsection

