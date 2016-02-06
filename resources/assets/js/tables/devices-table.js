Vue.component('devices-table', {
	
	props: ['userRole'],

	// components: {
	// 	'table-headers': require('./table-headers'),
	// },

	data: function() {
		return {
			sortKey: 'rent_amount',

			reverse: -1,

			currentPage: 1,

			search: null,

			columns: [
				{
					name: 'address',
					label: 'address',
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
					label: 'status',
					width: 'col-sm-2',
					isSortable: true
				},
				{
					name: 'alarm_id',
					label: 'alarm',
					width: 'col-sm-2',
					isSortable: true
				}
			],

			devices: [],
		};
	},

	events: {
		'table-sorted': function(sortKey) {
			this.sortKey = sortKey;
			this.reverse = (this.sortKey == sortKey) ? this.reverse * -1 : 1;
			this.fetchDevices();
		}
	},

	ready: function() {
		this.fetchDevices();
	},

	methods: {
		fetchDevices: function() {
			var data = {
				with: ['property', 'alarm'],
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

});