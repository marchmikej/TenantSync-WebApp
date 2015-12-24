new Vue({
	
	el: "#device",

	data: {
		device: {

		},
		maintenanceRequests: {},
		
	},

	ready: function() {
		this.fetchMaintenance();
	}

	methods: {
		fetchMaintenance: function() {
			this.$http.get('landlord/device/all')
			.success(function(maintenanceRequests) {
				this.maintenanceRequests = maintenanceRequests;
			})
			.error(function() {

			});
		},
	}
})