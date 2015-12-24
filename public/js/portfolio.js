var vue = new Vue({

	el: '#portfolio',


	data: {

		properties: {
			
		},
	},


	ready: function() {
		this.fetchProperties();
	},


	methods: {

		fetchProperties: function() {
			this.$http.get('/landlord/properties/all')
				.success( function(properties) {
					this.properties = properties;
				})
				.error( function() {
					console.log('Error fetching properties');
				});
		}
	},


	filters: {
		numeric: function(array, field, operator, value ) {
			return array.filter(function(item) {
				console.log(item);
				if (item.$value)
				{
					return math[operator](item.$value[field], value)  ? item : null;
				}
			});
		}
	}
});