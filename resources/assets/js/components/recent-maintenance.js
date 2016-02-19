Vue.component('recent-maintenance', {

	data: function() {
		return {

			maintenanceRequests: [],

			forms: {
				message: new TSForm({
					device_id: [],
					body: '',
					search: null,
				})
			},
		};

	},


	ready: function() {
		this.fetchMaintenance();
	},

	methods: {
		fetchMaintenance: function() {
			var data = {
				with: ['device'],
				limit: 5,
			};

			this.$http.get('/api/maintenance/', data)
			.success(function(maintenance) {
				this.maintenanceRequests = maintenance;
			});
		},
	},
})