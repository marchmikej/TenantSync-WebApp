Vue.component('portfolio-table', {		

	// components: {
	// 	'table-headers': require('./table-headers'),
	// },

	data: function() {
		return {
			sortKey: 'roi',

			reverse: -1,

			currentPage: 1,

			search: null,

			columns: [
				{
					name: 'address',
					label: 'Address',
					width: 'col-sm-5',
					isSortable: false
				},
				{
					name: 'roi',
					label: 'ROI',
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

	events: {
		'table-sorted': function(sortKey) {
			this.sortKey = sortKey;
			this.reverse = (this.sortKey == sortKey) ? this.reverse * -1 : 1;
			// this.currentPage = 1;
		}
	},


	ready: function() {
		this.fetchProperties();
	},


	methods: {

		fetchProperties: function(page, sortKey, reverse) {
			var data = {
				with: ['devices', 'transactions'],
				set: ['roi']
			};

			this.$http.get('/api/properties', data)
				.success( function(properties) {
					this.properties = properties;
				});
		},

		showDetails: function(id) {
			var property = _.where(this.properties, {id: id});
			$('[data-property-id='+ id +']').toggle();
		},
	},
});
