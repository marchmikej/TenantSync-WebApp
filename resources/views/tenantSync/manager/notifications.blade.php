@extends('TenantSync::manager.layout')

@section('content')

<div class="row">
	<div class="card">
		<h2 class="text-primary">Method</h2>
		<div class="form-group row col-sm-12">

			<button 
				@click="toggleNotificationMethod($event)" 
				data-method="emailNotifications" 
				class="col-sm-2 btn" 
				:class="[emailNotifications ? 'btn-success' : 'btn-muted']"
			>
				Email
				</button>

			<button 
				@click="toggleNotificationMethod($event)" 
				data-method="textNotifications" 
				class="col-sm-2 btn m-l" 
				:class="[textNotifications ? 'btn-success' : 'btn-muted']"
			>
			Text
			</button>
			
			<!-- <label class="col-sm-2 m-r control-label" for="email_notifications">
				Email
				<input class="" @change="updateNotificationMethods()" type="checkbox" v-model="emailNotifications"/>
			</label> -->

			<!-- <label class="col-sm-1 control-label" for="mobile_notifications">
				Text
				<input class="" @change="updateNotificationMethods()" type="checkbox" v-model="textNotifications"/>
			</label> -->

			<div class="col-sm-4">
				<select @change="updateCellCarrier()" class="form-control" name="cell_carrier" v-model="cellCarrier">
					<option :value="null" default>Cell Carrier</option>
					<option v-for="carrier in cellCarriers" :value="carrier.id">@{{ carrier.name }}</option>
				</select>
				<!-- <label >
					Cell Carrier
				</label> -->
			</div>

		</div>

		<hr>
		
		<h2 class="text-primary">Notifications</h2>

		<div class="form-group">
			<div v-for="notification in notifications.all" class="checkbox">
				<label>
					<input 
						type="checkbox" 
						:name="notification.name" 
						:checked="userWantsNotification(notification.id)"
						@change="toggleNotification($event, notification.id)" 
					/>
						@{{ toTitleCase(notification.name) }}
				</label>
			</div>
		</div>

	</div>
</div>

@endsection

@section('scripts')

<script>

var vue = new Vue({
	el: '#app',

	data: {
		emailNotifications: app.notifyByEmail,
		textNotifications: app.notifyByText,
		cellCarrier: app.cellCarrier || null,
		notifications: {
			all: JSON.parse(app.allNotifications),
			user: JSON.parse(app.userNotifications),
			selected: [],
		},
		cellCarriers: app.cellCarriers,
	},

	ready: function() {
		this.populateSelected();
	},

	methods: {
		populateSelected: function() {
			this.notifications.selected = _.pluck(this.notifications.user, 'id');
		},

		updateNotifications: function() {
			var data = {
				notification_ids: this.notifications.selected,
			};

			this.$http.patch('/' + this.user().role + '/notifications', data)
			.success(function(response) {
				console.log(response);
			});
		},

		toggleNotificationMethod: function(event) {
			var notificationMethod = event.target.dataset.method;

			if (notificationMethod == 'textNotifications' && ! this.cellCarrier) {
				swal('Hang On!', 'Please select a cell carrier.');
				return false;
			}

			this[notificationMethod] = ! this[notificationMethod];

			var data = {
				email: this.emailNotifications,
				text: this.textNotifications,
			};

			this.$http.patch('/' + this.user().role + '/notifications/methods', data)
			.success(function(response) {
				console.log(response);
			})
			.error(function(error) {
				this[notificationMethod] = ! this[notificationMethod];
			});
		},

		updateCellCarrier: function() {
			var data = {
				cell_carrier_id: this.cellCarrier,
			};

			this.$http.patch('/manager/cell-carrier', data)
			.success(function(manager) {

			});
		},

		// updateNotificationMethods: function() {
		// 	var data = {
		// 		email: this.emailNotifications,
		// 		text: this.textNotifications,
		// 	};

		// 	this.$http.patch('/' + this.user().role + '/notifications/methods', data)
		// 	.success(function(response) {
		// 		console.log(response);
		// 	});
		// },

		toggleNotification: function(event, id) {
			var element = event.target;

			if (element.checked) {
				this.addNotification(id);
			} else {
				this.removeNotification(id);
			}

			this.updateNotifications();
		},

		addNotification: function(id) {
			this.notifications.selected.push(Number(id));
		},

		removeNotification: function(id) {
			this.notifications.selected.$remove(Number(id));
		},

		userWantsNotification: function(id) {
			var found = this.findById(this.notifications.user, id);

			return found;
		},
	},
});

</script>
@endsection