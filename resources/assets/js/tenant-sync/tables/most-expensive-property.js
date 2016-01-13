Vue.component('most-expensive-property-table', {
	props: ['userRole'],

	components: {
		'table-headers': require('./table-headers')
	},

	data: function() {
		return {

			columns: [
				{
					key: 'address',
					label: 'Address',
					width: 'col-sm-10',
					isSortable: false,
				},
				// {
				// 	key: 'income',
				// 	label: 'Income',
				// 	width: 'col-sm-2',
				// 	isSortable: false,
				// },
				{
					key: 'expenses',
					label: 'Expenses',
					width: 'col-sm-2',
					isSortable: false,
				},
				// {
				// 	key: 'netIncome',
				// 	label: 'Net Income',
				// 	width: 'col-sm-2',
				// 	isSortable: false,
				// }
			],

			properties: [

			],
		}
	},

	ready: function() {
		this.fetchProperties();
	},

	methods: {

		fetchProperties: function() {
			this.$http.get('/'+ this.userRole +'/properties/all')
			.success(function(result) {
				this.properties = _.map(result.data, function(property) {
					return this.setTotalExpenses(property);
				}.bind(this));
			});
		},

		setTotalExpenses: function(property) {
			var totalExpenses = _.reduce(property.expenses, function(memo , current) { return Number(memo) + Number(current.amount) * -1; }, 0);
			property = _.extend(property, {totalExpenses: totalExpenses});
			return property;
		},
	},

});