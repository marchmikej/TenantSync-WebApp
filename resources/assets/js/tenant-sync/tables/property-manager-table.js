Vue.component('property-manager-table', {
	
	props: ['userRole'],

	components: {
		'table-headers': require('./table-headers'),
	},

	data: function() {
		return {
			sortKey: '',

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
					width: 'col-sm-7',
					isSortable: false
				},
				{
					name: 'alarms',
					label: 'Alarms',
					width: 'col-sm-2',
					isSortable: false
				},
				{
					name: 'inactive',
					label: 'Inactive',
					width: 'col-sm-2',
					isSortable: false
				}
			],

			properties: [

			],

			messages: [
			
			],

			maintenanceRequests: [
			
			],

			showDevices: [

			],

			numeral: window.numeral,
		};
	},


	ready: function() {
		this.fetchProperties();
		var numeral = numeral;
	},


	methods: {

		fetchProperties: function(page, sortKey, reverse) {
			var append = this.generateUrlVars({with: 'devices', paginate: this.paginate, sort: sortKey, page: page, asc: reverse});

			this.$http.get('/'+ this.userRole +'/properties/all?' + append)
				.success(function(result) {
					this.properties = _.map(result.data, function(property) {
						property = this.inactiveDevicesInProperty(property);
						return this.alarmsInProperty(property);
					}.bind(this));
					this.paginated = result;
				});
		},

		showDevices: function(id) {
			if (! _.find(this.showDevices, function(item) { return item == id;}))
			{
				this.showDevices.push(id);
			}
			else
			{
				this.properties[id].showDevices = !this.properties[id].showDevices;
			}
		},

		alarmsInProperty: function(property) {
			var alarms = _.filter(property.devices, function(device) { device.alarm_id != 0 ;}).length;
			property = _.extend(property, {alarms: alarms});
			return property;
		},

		inactiveDevicesInProperty: function(property) {
			var inactives = _.filter(property.devices, function(device) { device.status != 'active' ;}).length;
			property = _.extend(property, {inactives: inactives});
			return property;
		}
	},

});