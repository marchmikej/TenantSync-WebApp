(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

Vue.component('devices-table', {

	props: ['userRole'],

	components: {
		'table-headers': require('./table-headers')
	},

	data: function data() {
		return {
			sortKey: 'rent_amount',

			reverse: -1,

			currentPage: 1,

			paginated: {},

			search: null,

			range: {
				from: moment().subtract(1, 'month').format('YYYY-MM-DD')
			},

			columns: [{
				name: 'address',
				label: 'address',
				width: 'col-sm-6',
				isSortable: false
			}, {
				name: 'rent_amount',
				label: 'rent_amount',
				width: 'col-sm-2',
				isSortable: true
			}, {
				name: 'status',
				label: 'status',
				width: 'col-sm-2',
				isSortable: true
			}, {
				name: 'alarm_id',
				label: 'alarm',
				width: 'col-sm-2',
				isSortable: true
			}],

			devices: []
		};
	},

	computed: {
		dates: function dates() {
			return {
				from: moment(this.range.from).format(),
				to: null
			};
		}
	},

	events: {
		'table-sorted': function tableSorted(sortKey) {
			this.sortKey = sortKey;
			this.reverse = this.sortKey == sortKey ? this.reverse * -1 : 1;
			this.currentPage = 1;
			this.fetchDevices();
		}
	},

	ready: function ready() {
		this.fetchDevices();
	},

	methods: {
		fetchDevices: function fetchDevices() {
			var append = this.generateUrlVars({
				'with': ['property'],
				paginate: this.paginate,
				page: this.currentPage,
				sort: this.sortKey,
				asc: this.reverse,
				dates: {
					from: this.dates.from,
					to: this.dates.to
				}
			});

			this.$http.get('/' + this.userRole + '/device/all?' + append).success(function (result) {
				for (var i = 0; i < result.data.length; i++) {
					result.data[i].rent_amount = Number(result.data[i].rent_amount);
				}
				this.devices = _.map(result.data, (function (device) {
					return this.setDeviceAddress(device);
				}).bind(this));
				this.paginated = result;
				this.page = result.current_page;
			});
		},

		fetchPage: function fetchPage(increment) {
			this.currentPage = Number(this.currentPage) + Number(increment);
			this.fetchDevices();
		},

		refreshTable: function refreshTable(sortKey, reverse) {
			this.fetchDevices();
		},

		setDeviceAddress: function setDeviceAddress(device) {
			device.address = device.property.address + ', ' + device.location;
			return device;
		},

		alarmsInProperty: function alarmsInProperty(property) {
			return _.filter(property.devices, function (device) {
				device.alarm_id != 0;
			}).length;
		},

		inactiveDevicesInProperty: function inactiveDevicesInProperty(property) {
			return _.filter(property.devices, function (device) {
				device.status != 'active';
			}).length;
		}
	}

});

},{"./table-headers":5}],2:[function(require,module,exports){
'use strict';

Vue.component('most-expensive-property-table', {
	props: ['userRole'],

	components: {
		'table-headers': require('./table-headers')
	},

	data: function data() {
		return {

			columns: [{
				key: 'address',
				label: 'Address',
				width: 'col-sm-10',
				isSortable: false
			},
			// {
			// 	key: 'income',
			// 	label: 'Income',
			// 	width: 'col-sm-2',
			// 	isSortable: false,
			// },
			{
				key: 'expenses',
				label: 'Expenses MTD',
				width: 'col-sm-2',
				isSortable: false
			}],

			// {
			// 	key: 'netIncome',
			// 	label: 'Net Income',
			// 	width: 'col-sm-2',
			// 	isSortable: false,
			// }
			properties: []
		};
	},

	ready: function ready() {
		this.fetchProperties();
	},

	methods: {

		fetchProperties: function fetchProperties() {
			this.$http.get('/' + this.userRole + '/properties/all').success(function (result) {
				this.properties = _.map(result.data, (function (property) {
					return this.setTotalExpenses(property);
				}).bind(this));
			});
		},

		setTotalExpenses: function setTotalExpenses(property) {
			var expenses = _.filter(property.expenses, function (expense) {
				return moment(expense.date) >= moment().subtract(1, 'month');
			});
			var totalExpenses = _.reduce(expenses, function (memo, current) {
				return Number(memo) + Number(current.amount) * -1;
			}, 0);
			property = _.extend(property, { totalExpenses: totalExpenses });
			return property;
		}
	}

});

},{"./table-headers":5}],3:[function(require,module,exports){
'use strict';

Vue.component('portfolio-table', {

	components: {
		'table-headers': require('./table-headers')
	},

	data: function data() {
		return {
			sortKey: 'roi',

			reverse: -1,

			currentPage: 1,

			paginated: {},

			search: null,

			range: {
				from: moment().subtract(1, 'month').format('YYYY-MM-DD')
			},

			columns: [{
				name: 'address',
				label: 'Address',
				width: 'col-sm-5',
				isSortable: false
			}, {
				name: 'roi',
				label: 'ROI',
				width: 'col-sm-2',
				isSortable: true
			}, {
				name: 'devices',
				label: 'Devices',
				width: 'col-sm-2',
				isSortable: true
			}, {
				name: 'value',
				label: 'Value',
				width: 'col-sm-2',
				isSortable: true
			}, {
				name: '',
				label: '',
				width: 'col-sm-1',
				isSortable: false
			}],

			properties: [],

			numeral: window.numeral
		};
	},

	events: {
		'table-sorted': function tableSorted(sortKey) {
			this.sortKey = sortKey;
			this.reverse = this.sortKey == sortKey ? this.reverse * -1 : 1;
			this.currentPage = 1;
			this.fetchProperties();
		}
	},

	ready: function ready() {
		this.fetchProperties();
		var numeral = numeral;
	},

	methods: {

		refreshTable: function refreshTable(sortKey, reverse) {
			this.fetchProperties(1, sortKey, reverse);
		},

		fetchProperties: function fetchProperties(page, sortKey, reverse) {
			//var append = this.generateUrlVars({paginate: this.paginate, sort: sortKey, page: page, asc: reverse});

			this.$http.get('/landlord/properties/all?').success(function (result) {
				this.properties = _.map(result.data, (function (property) {
					return this.setTotalExpenses(property);
				}).bind(this));
				this.paginated = result;
				this.currentPage = result.current_page;
			});
		},

		showDetails: function showDetails(id) {
			var property = _.where(this.properties, { id: id });

			$('[data-property-id=' + id + ']').toggle();
		},

		setTotalExpenses: function setTotalExpenses(property) {
			var totalExpenses = _.reduce(property.expenses, function (memo, current) {
				return Number(memo) + Number(current.amount) * -1;
			}, 0);
			property = _.extend(property, { totalExpenses: totalExpenses });
			return property;
		}
	}
});

},{"./table-headers":5}],4:[function(require,module,exports){
'use strict';

Vue.component('property-manager-table', {

	props: ['userRole'],

	components: {
		'table-headers': require('./table-headers')
	},

	data: function data() {
		return {
			sortKey: '',

			reverse: -1,

			currentPage: 1,

			paginated: {},

			search: null,

			range: {
				from: moment().subtract(1, 'month').format('YYYY-MM-DD')
			},

			columns: [{
				name: 'address',
				label: 'Address',
				width: 'col-sm-7',
				isSortable: false
			}, {
				name: 'alarms',
				label: 'Alarms',
				width: 'col-sm-2',
				isSortable: false
			}, {
				name: 'inactive',
				label: 'Inactive',
				width: 'col-sm-2',
				isSortable: false
			}],

			properties: [],

			messages: [],

			maintenanceRequests: [],

			showDevices: [],

			numeral: window.numeral
		};
	},

	ready: function ready() {
		this.fetchProperties();
		var numeral = numeral;
	},

	methods: {

		fetchProperties: function fetchProperties(page, sortKey, reverse) {
			var append = this.generateUrlVars({ 'with': 'devices', paginate: this.paginate, sort: sortKey, page: page, asc: reverse });

			this.$http.get('/' + this.userRole + '/properties/all?' + append).success(function (result) {
				this.properties = _.map(result.data, (function (property) {
					property = this.inactiveDevicesInProperty(property);
					return this.alarmsInProperty(property);
				}).bind(this));
				this.paginated = result;
			});
		},

		alarmsInProperty: function alarmsInProperty(property) {
			var alarms = _.filter(property.devices, function (device) {
				device.alarm_id != 0;
			}).length;
			property = _.extend(property, { alarms: alarms });
			return property;
		},

		inactiveDevicesInProperty: function inactiveDevicesInProperty(property) {
			var inactives = _.filter(property.devices, function (device) {
				device.status != 'active';
			}).length;
			property = _.extend(property, { inactives: inactives });
			return property;
		},

		toggleDevices: function toggleDevices(id) {
			$('[data-property-id=' + id + ']').toggle();
		}
	}

});

},{"./table-headers":5}],5:[function(require,module,exports){
'use strict';

module.exports = {

	props: ['columns', 'sortKey', 'reverse'],

	template: '<div class="table-heading row">\
				<div v-for="column in columns" @click="sortBy(column)" :class="[column.width, column.isSortable ? \'sortable\' : \'\' ]">{{ toTitleCase(column.label) }}<span :class="sortKeyClasses(column)"></span></div>\
			</div>',

	data: function data() {
		return {

			currentPage: 1
		};
	},

	methods: {
		sortBy: function sortBy(column) {
			//var sortKey = column.name;
			// var reverse = (this.sortKey == sortKey) ? this.reverse * -1 : 1;

			if (!column.isSortable) {
				return false;
			}
			this.$dispatch('table-sorted', column.name);

			// var sortKey = sortKey;			
			// this.refreshTable(sortKey, reverse);
			// this.reverse = reverse;
			// this.sortKey = sortKey;
		},

		sortKeyClasses: function sortKeyClasses(column) {
			if (!column.isSortable) {
				return false;
			}
			var key = column.name;
			var classes = ['icon'];

			if (key == this.sortKey) {
				classes.push('text-warning');
				if (this.reverse > 0) {
					classes.push('icon-chevron-up');
					return classes;
				}
				classes.push('icon-chevron-down');
				return classes;
			}
			classes.push('icon-chevron-up', 'text-muted');
			return classes;
		}
	}
};

},{}],6:[function(require,module,exports){
'use strict';

Vue.component('transactions-table', {
	props: ['userRole'],

	components: {
		'table-headers': require('./table-headers')
	},

	data: function data() {
		return {
			sortKey: 'date',

			reverse: -1,

			currentPage: 1,

			paginated: {},

			search: null,

			range: {
				from: moment().subtract(1, 'month').format('YYYY-MM-DD')
			},

			columns: [{
				name: 'amount',
				label: 'Amount',
				width: 'col-sm-2',
				isSortable: true
			}, {
				name: 'address',
				label: 'Applied To',
				width: 'col-sm-2',
				isSortable: false
			}, {
				name: 'description',
				label: 'Description',
				width: 'col-sm-5',
				isSortable: true
			}, {
				name: '',
				label: '',
				width: 'col-sm-1',
				isSortable: false
			}, {
				name: 'date',
				label: 'date',
				width: 'col-sm-1',
				isSortable: true
			}, {
				name: '',
				label: '',
				width: 'col-sm-1',
				isSortable: false
			}],

			showModal: false,

			modal: {
				amount: '',
				description: '',
				transaction: null,
				date: '',
				payable: {
					id: TenantSync.landlord,
					type: 'user',
					search: null,
					selected: 'General'
				},
				recurring: false,
				schedule: null
			},

			transactions: [],

			properties: []
		};
	},

	computed: {
		dates: function dates() {
			return {
				from: moment(this.range.from).format(),
				to: null
			};
		}
	},

	ready: function ready() {
		this.fetchTransactions();
		this.fetchProperties();
	},

	events: {
		'table-sorted': function tableSorted(sortKey) {
			this.sortKey = sortKey;
			this.reverse = this.sortKey == sortKey ? this.reverse * -1 : 1;
			this.currentPage = 1;
			this.fetchTransactions();
		}
	},

	methods: {
		fetchTransactions: function fetchTransactions() {
			var append = this.generateUrlVars({
				paginate: this.paginate,
				sort: this.sortKey,
				page: this.page,
				asc: this.reverse,
				dates: {
					from: this.dates.from,
					to: this.dates.to
				}
			});

			this.$http.get('/' + this.userRole + '/transaction/all?' + append).success(function (result) {
				_.each(result.data, function (transaction) {
					transaction.amount = Number(transaction.amount);
				});
				this.transactions = result.data;
				this.paginated = result;
				this.currentPage = result.current_page;
			});
		},

		fetchProperties: function fetchProperties() {
			var append = this.generateUrlVars({
				'with': ['devices']
			});

			this.$http.get('/' + this.userRole + '/properties/all?' + append).success(function (result) {
				this.properties = result.data;
				//console.log(result);
			});
		},

		generateModal: function generateModal(id) {
			if (id + 1 > 0) {
				this.modal.amount = this.transactions[id].amount;
				this.modal.transaction = this.transactions[id];
				this.modal.description = this.transactions[id].description ? this.transactions[id].description : '';
				this.modal.date = this.transactions[id].date;
				this.modal.payable = {
					id: this.transactions[id].payable_id,
					type: this.getTransactionPayable(this.transactions[id]),
					selected: this.transactions[id].address
				};
				this.modal.schedule = this.transactions[id].recurring ? this.transactions[id].recurring.schedule : null;
				this.modal.recurring = this.transactions[id].recurring ? true : false;
			}
			this.showModal = true;
		},

		hideModal: function hideModal() {
			this.modal = {
				amount: '',
				description: '',
				transaction: null,
				date: '',
				payable: {
					id: TenantSync.landlord,
					type: 'user',
					search: null,
					selected: 'General'
				},
				recurring: false,
				schedule: null
			};
			this.showModal = false;
		},

		submitTransaction: function submitTransaction() {
			var data = {
				amount: this.modal.amount,
				description: this.modal.description,
				payable_id: this.modal.payable.id,
				payable_type: this.modal.payable.type,
				is_rent: this.modal.is_rent,
				date: this.modal.date,
				recurring: this.modal.recurring,
				schedule: this.modal.schedule
			};

			if (this.modal.transaction) {
				this.updateTransaction(data);
			} else {
				data.user_id = TenantSync.landlord;
				this.createTransaction(data);
			}
		},

		setPayable: function setPayable(type, id, string) {
			this.modal.is_rent == false;
			this.modal.payable.type = type;
			if (type == 'user') {
				this.modal.payable.selected = 'General';
				this.modal.payable.id = TenantSync.landlord;
				return true;
			}

			this.modal.payable.selected = string;
			this.modal.payable.id = id;
			return true;
		},

		createTransaction: function createTransaction(data) {
			this.$http.post('/' + this.userRole + '/transaction', data).success(function (transaction) {
				this.hideModal();
				this.fetchTransactions(1, this.sortKey, this.reverse);
			});
		},

		updateTransaction: function updateTransaction(data) {

			this.$http.patch('/' + this.userRole + '/transaction/' + this.modal.transaction.id, data).success(function (transaction) {
				this.hideModal();
				this.fetchTransactions(1, this.sortKey, this.reverse);
			});
		},

		deleteTransaction: function deleteTransaction(id) {

			if (confirm('Are you sure you want to delete this transaction?')) {
				this.$http['delete']('/' + this.userRole + '/transaction/' + id).success(function () {
					this.fetchTransactions(1, this.sortKey, this.reverse);
				});
			}
		},

		getTransactionPayable: function getTransactionPayable(transaction) {

			switch (transaction.payable_type) {
				case 'TenantSync\\Models\\Property':
					return 'property';
					break;
				case 'TenantSync\\Models\\Device':
					return 'device';
					break;
				case 'TenantSync\\Models\\User':
					return 'user';
					break;
			}
		}

	}

});
// getTransactionPayable: function(transaction) {

// 	switch (transaction.payable_type) {
// 		case 'TenantSync\\Models\\Property':
// 			return transaction.payable.address;
// 			break;
// 		case 'TenantSync\\Models\\Device':
// 			return transaction.payable.location + ', ' + transaction.property.address;
// 			break;
// 		case 'TenantSync\\Models\\User':
// 			return 'General';
// 			break;
// 	}
// }

},{"./table-headers":5}],7:[function(require,module,exports){
'use strict';

Vue.http.headers.common['X-CSRF-TOKEN'] = document.getElementById('_token').getAttribute('value');

var math = {
	'+': function _(a, b) {
		return a + b;
	},
	'-': function _(a, b) {
		return a - b;
	},
	'>': function _(a, b) {
		return a > b;
	},
	'<': function _(a, b) {
		return a < b;
	}
};

var toTitleCase = function toTitleCase(string) {
	var strings = string.replace('_', ' ').split(' ');
	for (var i = 0; i < strings.length; i++) {
		strings[i] = strings[i].charAt(0).toUpperCase() + strings[i].slice(1);
	}
	return strings.join(' ');
};

Vue.prototype.toTitleCase = toTitleCase;
Vue.prototype.numeral = window.numeral;
Vue.prototype.moment = window.moment;
Vue.prototype._ = window._;

Vue.mixin({
	methods: {
		generateUrlVars: function generateUrlVars(includes) {
			var include = $.param(includes);
			return include;
		}
	}
});

Vue.filter('search', function (list, string) {
	if (!string) {
		return list;
	}

	return _.filter(list, (function (object) {
		return _.find(object, (function (property) {
			if (typeof property === 'string') {
				return property.toLowerCase().includes(string.trim().toLowerCase());
			}
			return false;
		}).bind(string));
	}).bind(string));
});

Vue.filter('whereNotIn', function (list, sourceList, property) {
	if (!sourceList || !property) {
		return list;
	}

	return _.filter(list, function (object) {
		return !_.size(_.where(sourceList, { 'id': object[property] }));
	});
});

},{}]},{},[7,6,4,2,1,3]);

//# sourceMappingURL=app.js.map
