Vue.component('devices-table', TSTable.extend({

	data: function() {
		return {

			perPage: 10,

			listName: 'devices',

			columns: [
				{
					name: 'address',
					label: 'Address',
					width: 'col-sm-6',
					isSortable: false
				},
				{
					name: 'rent_owed',
					label: 'Rent Owed',
					width: 'col-sm-2',
					isSortable: true
				},
				{
					name: 'status',
					label: 'Status',
					width: 'col-sm-2',
					isSortable: true
				},
				{
					name: 'alarm_id',
					label: 'Alarm',
					width: 'col-sm-2',
					isSortable: true
				}
			],

			devices: [],
		};
	},

	ready: function() {
		this.fetchDevices();
	},

	methods: {
		fetchDevices: function() {
			var data = {
				with: ['property', 'alarm'],
				set: ['address', 'rent_owed']
			};

			this.$http.get('/api/devices', data)
			.success(function(list) {
				this.devices = list;
				for(var i = 0; i < list.length; i++)
				{
					list[i].rent_amount = Number(list[i].rent_amount);
				}
			});
		},

		alarmsInProperty: function(property) {
			return _.filter(property.devices, function(device) { device.alarm_id != 0 ;}).length;
		},

		inactiveDevicesInProperty: function(property) {
			return _.filter(property.devices, function(device) { device.status != 'active' ;}).length;
		}
	},

}));