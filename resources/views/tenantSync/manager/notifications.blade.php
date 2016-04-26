@extends('TenantSync::manager.layout')

@section('content')

<div class="row">
	<div class="card">
		<h2 class="text-primary">Method</h2>
		<div class="form-group">
<!-- 			<h4>How would you like to receive notifications?</h4>
 -->			<label class="m-r control-label" for="email_notifications">
				<input @change="updateNotificationMethods()" type="checkbox" v-model="emailNotifications"/>
				Email
			</label>

			<label class="control-label" for="mobile_notifications">
				<input @change="updateNotificationMethods()" type="checkbox" v-model="textNotifications"/>
				Text
			</label>
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
		notifications: {
			all: JSON.parse(app.allNotifications),
			user: JSON.parse(app.userNotifications),
			selected: [],
		},
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

		updateNotificationMethods: function() {
			var data = {
				email: this.emailNotifications,
				text: this.textNotifications,
			};

			this.$http.patch('/' + this.user().role + '/notifications/methods', data)
			.success(function(response) {
				console.log(response);
			});
		},

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