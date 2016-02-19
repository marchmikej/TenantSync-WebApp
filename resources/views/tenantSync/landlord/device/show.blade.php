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
							<div class="table-body table-striped">
								<div v-for="maintenance in maintenanceRequests" class="table-row row">
									<div class="col-sm-2">@{{ maintenance.device.location }}</div>
									<div class="col-sm-10"><a href="/landlord/maintenance/@{{ maintenance.id }}">@{{ maintenance.request }}</a></div>
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
								<p 
									v-for="message in messages"
									:class="['well', message.from_device ? 'well-blue text-white m-r-md' : 'm-l-md']"
									style="position: relative;"
								>
									<button 
										@click="confirm({method: 'deleteMessage', id: message.id})"
										class="btn btn-clear p-a-0 m-a-0 text-danger icon icon-cross"
										style="position: absolute; top: 0px; right: 1px;"
									></button>
									@{{ message.body }}
								</p>	
							</div>
							<div class="row">
								<form class="form row" >
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<input type="hidden" name="device_id" value="{{ $device->id }}">
									<div class="form-group">
										<div class="col-sm-12 p-l">
											<textarea 
												@keydown.enter="sendMessage()" 
												v-model="forms.message.body" 
												name="message" 
												rows="2" 
												class="form-control"
											></textarea>
											<button @click.prevent="sendMessage()" class="form-control btn btn-primary">Reply</button>
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
	vue = new Vue({
	
		el: "#app",

		data: {
			device: app.device,

			maintenanceRequests: [],

			messages: app.deviceMessages,

			forms: {
				message: new TSForm({
					device_id: app.device.id,
					body: null,
				})
			}
		},

		events: {
			'messages-updated': function() {
				this.fetchMessages();
			},
		},

		ready: function() {
			this.fetchMaintenance();
			this.fetchMessages();
		},

		methods: {
			fetchMaintenance: function() {
				this.$http.get('/landlord/maintenance/all')
					.success(function(maintenanceRequests) {
						this.maintenanceRequests = maintenanceRequests;
					});
			},

			fetchMessages: function() {
				this.$http.get('/api/devices/'+ this.device.id +'/messages')
					.success(function(messages) {
						this.messages = messages;
						
					})
					.then(function() {
						this.scrollToLatestMessage();
					});
			},

			deleteMessage: function(id) {
				this.$http.delete('/api/messages/'+ id)
					.success(function(response) {
						var message = _.find(this.messages, {id: id}); 

						this.messages.$remove(message);
					});
			},

			sendMessage: function() {
				var that = this;
				TS.post('/api/messages', this.forms.message)
					.then(function(response) {
						that.$emit('messages-updated');
						that.forms.message.body = null;
					});
			},

			submitForm: function() {
				$('#device-form').submit();
			},

			scrollToLatestMessage: function() {
				var element = document.getElementById("chat");
				element.scrollTop = element.scrollHeight;
			},
		}
	})
</script>
@endsection

