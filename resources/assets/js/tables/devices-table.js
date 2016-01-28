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

			paginated: {},

			search: null,

			range: {
				from: moment().subtract(1, 'month').format('YYYY-MM-DD'),
			},

			columns: [
				{
					name: 'address',
					label: 'address',
					width: 'col-sm-6',
					isSortable: false
				},
				{
					name: 'rent_amount',
					label: 'rent_amount',
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

	computed: {
		dates: function() {
			return {
				from: moment(this.range.from).format(),
				to: null
			};
		}
	},

	events: {
		'table-sorted': function(sortKey) {
			this.sortKey = sortKey;
			this.reverse = (this.sortKey == sortKey) ? this.reverse * -1 : 1;
			this.currentPage = 1;
			this.fetchDevices();
		}
	},

	ready: function() {
		this.fetchDevices();
	},

	methods: {
		fetchDevices: function() {
			var append = this.generateUrlVars({
				with: ['property'],
				paginate: this.paginate, 
				page: this.currentPage,
				sort: this.sortKey, 
				asc: this.reverse, 
				dates: {
					from: this.dates.from, 
					to: this.dates.to
				}
			});

			this.$http.get('/' + this.userRole + '/device/all?' + append)
			.success(function(result) {
				for(var i = 0; i < result.data.length; i++)
				{
					result.data[i].rent_amount = Number(result.data[i].rent_amount);
				}
				this.devices = _.map(result.data, function(device) {
					return this.setDeviceAddress(device);
				}.bind(this));
				this.paginated = result;
				this.page = result.current_page;
			});
		},

		fetchPage: function(increment) {
			this.currentPage = Number(this.currentPage) + Number(increment);
			this.fetchDevices();
		},

		refreshTable: function(sortKey, reverse)
		{
			this.fetchDevices();
		},


		setDeviceAddress: function(device) {
			device.address = device.property.address + ', ' + device.location;
			return device;
		},

		alarmsInProperty: function(property) {
			return _.filter(property.devices, function(device) { device.alarm_id != 0 ;}).length;
		},

		inactiveDevicesInProperty: function(property) {
			return _.filter(property.devices, function(device) { device.status != 'active' ;}).length;
		}
	},

});