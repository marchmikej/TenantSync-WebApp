Vue.component('most-expensive-property-table', {
	props: ['userRole'],

	// components: {
	// 	'table-headers': require('./table-headers')
	// },

	data: function() {
		return {

			columns: [
				{
					name: 'address',
					label: 'Address',
					width: 'col-sm-10',
					isSortable: false,
				},
				{
					name: 'expenses',
					label: 'Expenses MTD',
					width: 'col-sm-2',
					isSortable: false,
				},
			],

			properties: [],
		}
	},

	ready: function() {
		this.fetchProperties();
	},

	methods: {

		fetchProperties: function() {
			var data = {
				with: ['transactions']
			}

			this.$http.get('/api/properties')
			.success(function(properties) {
				this.properties = _.map(properties, function(property) {
					return this.setTotalExpenses(property);
				}.bind(this));
			});
		},

		setTotalExpenses: function(property) {
			var transactions = _.filter(property.transactions, function(transaction) { return moment(transaction.date) >= moment().subtract(1, 'month')});
			var totalExpenses = _.reduce(transactions, function(memo , transaction) { return Number(memo) + Number(transaction.amount) * -1; }, 0);
			property = _.extend(property, {totalExpenses: totalExpenses});
			return property;
		},
	},

});