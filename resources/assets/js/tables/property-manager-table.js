Vue.component('property-manager-table', {
	
	props: ['userRole'],

	// components: {
	// 	'table-headers': require('./table-headers'),
	// },

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
		};
	},


	ready: function() {
		this.fetchProperties();
	},


	methods: {

		fetchProperties: function(page, sortKey, reverse) {
			var data = {
				with: ['devices', 'devices.alarm'],
				set: ['roi', 'net_income']
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

});