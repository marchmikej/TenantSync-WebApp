Vue.component('portfolio-table', TSTable.extend({		

	// components: {
	// 	'table-headers': require('./table-headers'),
	// },

	data: function() {
		return {
			perPage: 10,

			listName: 'properties',

			columns: [
				{
					name: 'address',
					label: 'Address',
					width: 'col-sm-5',
					isSortable: false
				},
				{
					name: 'roi',
					label: 'ROI YTD',
					width: 'col-sm-2',
					isSortable: true
				},
				{
					name: 'devices',
					label: 'Devices',
					width: 'col-sm-2',
					isSortable: true
				},
				{
					name: 'value',
					label: 'Value',
					width: 'col-sm-2',
					isSortable: true
				},
				{
					name: '',
					label: '',
					width: 'col-sm-1',
					isSortable: false
				}
			],

			properties: [],
		};

	},

	ready: function() {
		this.fetchProperties();
	},


	methods: {

		fetchProperties: function(page, sortKey, reverse) {
			var data = {
				with: ['devices'],
				set: ['roi']
			};

			this.$http.get('/api/properties', data)
				.success( function(properties) {
					this.properties = properties;
					this.$dispatch('properties-loaded', properties);
				});
		},

		showDetails: function(id) {
			var property = _.where(this.properties, {id: id});
			$('[data-property-id='+ id +']').toggle();
		},
	},
}));
