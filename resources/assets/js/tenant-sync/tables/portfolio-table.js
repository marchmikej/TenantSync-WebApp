Vue.component('portfolio-table', {		

	components: {
		'table-headers': require('./table-headers'),
	},

	data: function() {
		return {
			sortKey: 'roi',

			reverse: -1,

			currentPage: 1,

			paginated: {},

			search: null,

			range: {
				from: moment().subtract(1, 'month').format('YYYY-MM-DD'),
			},

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

			properties: [

			],

			numeral: window.numeral,
		};

	},

	events: {
		'table-sorted': function(sortKey) {
			this.sortKey = sortKey;
			this.reverse = (this.sortKey == sortKey) ? this.reverse * -1 : 1;
			this.currentPage = 1;
			this.fetchProperties();
		}
	},


	ready: function() {
		this.fetchProperties();
		var numeral = numeral;
	},


	methods: {

		refreshTable: function(sortKey, reverse)
		{
			this.fetchProperties(1, sortKey, reverse);
		},

		fetchProperties: function(page, sortKey, reverse) {
			//var append = this.generateUrlVars({paginate: this.paginate, sort: sortKey, page: page, asc: reverse});

			this.$http.get('/landlord/properties/all?')
				.success( function(result) {
					this.properties = result.data;
					this.paginated = result;
					this.currentPage = result.current_page;
				});
		},

		showDetails: function(id) {
			var property = _.where(this.properties, {id: id});
			console.log(property);
			if (! property.showDetails)
			{
				property = $.extend({}, property, {showDetails: true});
				//property.$set('showDetails', true);
				console.log(property);
			}
			else
			{
				property.showDetails = ! property.showDetails;
			}
			
		}
	},
});
