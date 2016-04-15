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

			perPage: 5,

			currentPage: 1,
		};

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


	ready: function() {
		this.fetchMaintenance();
	},

	methods: {
		fetchMaintenance: function() {
			var data = {
				with: ['device'],
				// limit: 5,
			};

			this.$http.get('/api/maintenance/', data)
			.success(function(maintenance) {
				this.maintenanceRequests = maintenance;
			});
		},

		isInCurrentPage: function(index) {
			return this.firstMaintenance <= index && index < this.lastMaintenance;
		},

		nextPage: function() {
			if(this.currentPage < this.lastPage) {
				this.currentPage ++;
			}
			console.log('next');
		},

		previousPage: function() {
			if(this.currentPage > 1) {
				this.currentPage --;
			}
			console.log('prev');
		},
	},
})