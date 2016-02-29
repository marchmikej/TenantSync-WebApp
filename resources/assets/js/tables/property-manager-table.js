Vue.component('property-manager-table', TSTable.extend({

	data: function() {
		return {
			perPage: 10,

			listName: 'properties',

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

			properties: [],

			messages: [],

			maintenanceRequests: [],

			showDevices: [],
		};
	},


	ready: function() {
		this.fetchProperties();
	},


	methods: {

		fetchProperties: function(page, sortKey, reverse) {
			var data = {
				with: ['devices', 'devices.alarm'],
				set: ['roi', 'net_income', 'transactions']
			};

			this.$http.get('/api/properties', data)
				.success(function(properties) {
					this.properties = _.map(properties, function(property) {
						property = this.inactiveDevicesInProperty(property);
						return this.alarmsInProperty(property);
					}.bind(this));
				});
		},

		alarmsInProperty: function(property) {
			var alarms = _.filter(property.devices, function(device) { return device.alarm_id != 0 ;}).length;
			property = _.extend(property, {alarms: alarms});
			return property;
		},

		inactiveDevicesInProperty: function(property) {
			var inactives = _.filter(property.devices, function(device) { return device.status != 'active' ;}).length;
			property = _.extend(property, {inactives: inactives});
			return property;
		},

		toggleDevices: function(id) {
			$('[data-property-id='+ id +']').toggle();
		},
	},

}));