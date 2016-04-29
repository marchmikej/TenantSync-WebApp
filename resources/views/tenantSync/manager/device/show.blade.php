@extends('TenantSync::manager/layout')

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

	<div class="row" v-cloak>
		<h4 class="col-sm-3 text-primary p-l-0 m-b-0"><a :href="'/' + user().role + '/properties/' + device.property_id">{{ $device->property->address . ', ' . $device->property->city }}</a></h4>
		<button v-if="device.alarm_id" @click="turnAlarmOff()" class="btn btn-danger col-sm-3 col-sm-offset-6 m-b">Turn Off Alarm</button>
		<button v-if="! device.alarm_id" @click="turnAlarmOn()" class="btn btn-success col-sm-3 col-sm-offset-6 m-b">Turn On Alarm</button>

		<div class="col-sm-6 p-r-md">
			<div class="card row">
				<div class="col-sm-12">
					<h3 class="card-header">
						Recent Maintenance

						<button @click="previousPage" :class="currentPage > 1 ? 'text-primary' : 'text-muted'" class="btn-clear btn icon icon-chevron-left"></button>

						<button @click="nextPage" :class="lastPage == currentPage ? 'text-muted' : 'text-primary'"class="btn-clear btn icon icon-chevron-right"></button>
					</h3>
					<div class="row table-heading">
						<div class="col-sm-3">Unit</div>
						<div class="col-sm-9">Request</div>
					</div>
					<div class="table-body table-striped h-sm">
						<div 
							v-if="isInCurrentPage($index)" 
							v-for="maintenance in maintenanceRequests" class="table-row row"
						>
							<div class="col-sm-3">@{{ maintenance.device.location }}</div>
							<div class="col-sm-9"><a :href="'/'+ user().role +'/maintenance/'+ maintenance.id">@{{ maintenance.request }}</a></div>
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
						<div v-for="message in messages" :class="[message.from_device ? 'text-left' : 'text-right']">
							<p 
								:class="getMessageClasses(message)"
								style="position: relative;"
							>
								<button 
									v-if="user().role == 'landlord'"
									@click="confirm({method: 'deleteMessage', id: message.id})"
									class="btn btn-clear icon icon-cross"
									:class="[message.from_device ? 'chat-close-l' : 'chat-close-r']"
								></button>
								@{{ message.body }}
							</p>	
							<span style="width: 100%;" :class="{'pull-left': message.from_device, 'pull-right': ! message.from_device}">
								<span class="text-muted">@{{ 'sent ' + moment(message.created_at).format('MMM, D') }}</span>
								<span v-if="message.from_device" class="text-info">@{{ '| read ' + moment(message.read_at).format('MMM, D') }}</span>
							</span>
						</div>
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
				<form id="device-form" :action="'/'+ user().role +'/device/'+ device.id" method="POST" class="form form-horizontal">
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

	<transactions-table inline-template :search="device.address">
		@include('TenantSync::includes.tables.transactions-table')
	</transactions-table>
</div>

@endsection 

@section('scripts')
<script>

vue = new Vue({

	el: "#app",

	data: {
		perPage: 5,

		device: app.device,

		maintenanceRequests: [],

		messages: app.deviceMessages,

		lastPage: 1,

		currentPage: 1,

		forms: {
			message: new TSForm({
				device_id: app.device.id,
				body: null,
			})
		}
	},

	computed: {
		lastMaintenance: function() {
			return this.currentPage * this.perPage;
		},

		firstMaintenance: function() {
			return this.lastMaintenance ? this.lastMaintenance - this.perPage : 0;
		},

		lastPage: function() {
			var pages = Math.ceil(_.size(this.maintenanceRequests)/this.perPage);

			return pages;
		},
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
			var data = {
				with: ['device'],
			};

			this.$http.get('/api/devices/'+ this.device.id +'/maintenance', data)
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

		turnAlarmOff: function() {
			this.updateAlarm(0);
		},

		turnAlarmOn: function() {
			this.updateAlarm(1);
		},

		updateAlarm: function(id) {
			this.$http.patch('/api/devices/' + this.device.id, {alarm_id: id})
			.success(function(device) {

				this.device.alarm_id = device.alarm_id;
			});
		},

		getMessageClasses: function(message) {
			var classes = message.from_device ? ['chat-blue', 'text-left', 'pull-left'] : ['chat-gray', 'text-left', 'pull-right'];

			return classes;
		},

		scrollToLatestMessage: function() {
			var element = document.getElementById("chat");

			element.scrollTop = element.scrollHeight;
		},

		isInCurrentPage: function(index) {
			return this.firstMaintenance <= index && index < this.lastMaintenance;
		},

		nextPage: function() {
			if(this.currentPage < this.lastPage) {
				this.currentPage ++;
			}
		},

		previousPage: function() {
			if(this.currentPage > 1) {
				this.currentPage --;
			}
		},
	}
})

</script>
@endsection

