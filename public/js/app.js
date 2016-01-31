(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
// Get all the random stuff in the vue-all file
'use strict';

require('./vue-all.js');

// Get all the table components
require('./tables/table-headers.js');

// Get all the form components
require('./forms/bootstrap.js');
require('./forms/transaction-form.js');

// Get all the table instances
require('./tables/devices-table.js');
require('./tables/most-expensive-property-table.js');
require('./tables/portfolio-table.js');
require('./tables/property-manager-table.js');
require('./tables/transactions-table.js');

// Get modal stuff
require('./components/modal.js');

},{"./components/modal.js":2,"./forms/bootstrap.js":3,"./forms/transaction-form.js":8,"./tables/devices-table.js":9,"./tables/most-expensive-property-table.js":10,"./tables/portfolio-table.js":11,"./tables/property-manager-table.js":12,"./tables/table-headers.js":13,"./tables/transactions-table.js":14,"./vue-all.js":15}],2:[function(require,module,exports){
'use strict';

Vue.component('modal', {
	props: ['title'],

	template: '<div v-if="visible" class="vue-modal row">\
	<div id="modal" class="modal-dialog">\
		<div class="modal-content col-sm-12 p-b">\
			<div class="modal-header row">\
	        	<button @click="hide" class="col-sm-1 icon icon-cross btn btn-clear" :class="{\'col-sm-offset-11\' : !title}"></button>\
	        	<h4 v-if="title" class="modal-title">{{ title}}</h4>\
	      	</div>\
		  	<div class="modal-body">\
		  		<slot name="one"></slot>\
		  	</div>\
		</div><!-- /.modal-content -->\
	</div><!-- /.modal-dialog -->\
</div>',

	data: function data() {
		return {
			visible: false
		};
	},

	events: {
		'show-modal': function showModal() {
			this.show();
		},

		'hide-modal': function hideModal() {
			this.hide();
		}
	},

	methods: {
		show: function show() {
			this.visible = true;
		},

		hide: function hide() {
			//reset the content to empty

			// hide modal
			this.visible = false;
			this.$dispatch('modal-hidden');
		}
	}

});

},{}],3:[function(require,module,exports){
/**
 * Initialize the Spark form extension points.
 */
'use strict';

TS.forms = {
  transaction: {},
  updateProfileBasics: {},
  updateTeamOwnerBasics: {}
};

/**
 * Load the SparkForm helper class.
 */
require('./instance');

/**
 * Define the form error collection class.
 */
require('./errors');

/**
 * Add additional form helpers to the Spark object.
 */
$.extend(TS, require('./http'));

/**
 * Define the Spark form input components.
 */
require('./components');

},{"./components":4,"./errors":5,"./http":6,"./instance":7}],4:[function(require,module,exports){
/**
 * Text field input component for Bootstrap.
 */
'use strict';

Vue.component('ts-text', {
    props: ['display', 'form', 'name', 'input', 'show'],

    template: '<div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input type="text" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});

/**
 * Date field input component for Bootstrap.
 */
Vue.component('ts-date', {
    props: ['display', 'form', 'name', 'input', 'show'],

    template: '<div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input type="date" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});

/**
 * E-mail field input component for Bootstrap.
 */
Vue.component('ts-email', {
    props: ['display', 'form', 'name', 'input', 'show'],

    template: '<div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input type="email" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});

/**
 * Password field input component for Bootstrap.
 */
Vue.component('ts-password', {
    props: ['display', 'form', 'name', 'input', 'show'],

    template: '<div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input type="password" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});

/**
 * Checkbox field input component for Bootstrap.
 */
Vue.component('ts-checkbox', {
    props: ['display', 'form', 'name', 'input', 'show'],

    template: '<div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input type="checkbox" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});

/**
 * Select input component for Bootstrap.
 */
Vue.component('ts-select', {
    props: ['display', 'form', 'name', 'items', 'input', 'show'],

    template: '<div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-8">\
        <select class="form-control" v-model="input">\
            <option v-for="item in items" :value="item.value">\
                {{ item.text }}\
            </option>\
        </select>\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});

},{}],5:[function(require,module,exports){
/**
 * Spark form error collection class.
 */
'use strict';

window.TSFormErrors = function () {
    this.errors = {};

    /**
     * Determine if the collection has any errors.
     */
    this.hasErrors = function () {
        return !_.isEmpty(this.errors);
    };

    /**
     * Determine if the collection has errors for a given field.
     */
    this.has = function (field) {
        return _.indexOf(_.keys(this.errors), field) > -1;
    };

    /**
     * Get all of the raw errors for the collection.
     */
    this.all = function () {
        return this.errors;
    };

    /**
     * Get all of the errors for the collection in a flat array.
     */
    this.flatten = function () {
        return _.flatten(_.toArray(this.errors));
    };

    /**
     * Get the first error message for a given field.
     */
    this.get = function (field) {
        if (this.has(field)) {
            return this.errors[field][0];
        }
    };

    /**
     * Set the raw errors for the collection.
     */
    this.set = function (errors) {
        if (typeof errors === 'object') {
            this.errors = errors;
        } else {
            this.errors = { 'field': ['Something went wrong. Please try again.'] };
        }
    };

    /**
     * Forget all of the errors currently in the collection.
     */
    this.forget = function () {
        this.errors = {};
    };
};

},{}],6:[function(require,module,exports){
'use strict';

module.exports = {
    /**
     * A few helper methods for making HTTP requests and doing common form actions.
     */
    post: function post(uri, form) {
        return TS.sendForm('post', uri, form);
    },

    put: function put(uri, form) {
        return TS.sendForm('put', uri, form);
    },

    patch: function patch(uri, form) {
        return TS.sendForm('patch', uri, form);
    },

    'delete': function _delete(uri, form) {
        return TS.sendForm('delete', uri, form);
    },

    /**
     * Send the form to the back-end server. Perform common form tasks.
     *
     * This function will automatically clear old errors, update "busy" status, etc.
     */
    sendForm: function sendForm(method, uri, form) {
        return new Promise(function (resolve, reject) {
            form.startProcessing();

            Vue.http[method](uri, form).success(function (response) {
                form.finishProcessing();

                resolve(response);
            }).error(function (errors) {
                form.errors.set(errors);
                form.busy = false;

                reject(errors);
            });
        });
    }
};

},{}],7:[function(require,module,exports){
/**
 * SparkForm helper class. Used to set common properties on all forms.
 */
"use strict";

window.TSForm = function (data) {
    var form = this;

    $.extend(this, data);

    this.errors = new TSFormErrors();
    this.busy = false;
    this.successful = false;

    this.startProcessing = function () {
        form.errors.forget();
        form.busy = true;
        form.successful = false;
    };

    this.finishProcessing = function () {
        form.busy = false;
        form.successful = true;
    };
};

},{}],8:[function(require,module,exports){
'use strict';

Vue.component('transaction-form', {

	components: require('./components.js'),

	data: function data() {
		return {
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
	},

	ready: function ready() {},

	events: {},

	methods: {
		submitTransaction: function submitTransaction() {
			var payload = {
				amount: this.amount,
				description: this.description,
				payable_id: this.payable.id,
				payable_type: this.payable.type,
				is_rent: this.is_rent,
				date: this.date,
				recurring: this.recurring,
				schedule: this.schedule
			};

			if (this.transaction) {
				this.updateTransaction(payload);
			} else {
				payload.user_id = TenantSync.landlord;
				this.createTransaction(payload);
			}
		},

		setPayable: function setPayable(type, id, string) {
			this.is_rent = false;
			this.payable.type = type;
			if (type == 'user') {
				this.payable.selected = 'General';
				this.payable.id = TenantSync.landlord;
				return true;
			}

			this.payable.selected = string;
			this.payable.id = id;
			return true;
		},

		createTransaction: function createTransaction(payload) {
			this.$http.post('/' + TenantSync.user.role + '/transaction', payload).success(function (transaction) {
				this.hideModal();
				this.fetchTransactions(1, this.sortKey, this.reverse);
			});
		},

		updateTransaction: function updateTransaction(payload) {
			this.$http.patch('/' + TenantSync.user.role + '/transaction/' + this.transaction.id, payload).success(function (transaction) {
				this.hideModal();
				this.fetchTransactions(1, this.sortKey, this.reverse);
			});
		},

		deleteTransaction: function deleteTransaction(id) {
			this.$http['delete']('/' + TenantSync.user.role + '/transaction/' + id).success(function () {
				this.fetchTransactions(1, this.sortKey, this.reverse);
			});
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

},{"./components.js":4}],9:[function(require,module,exports){
'use strict';

Vue.component('devices-table', {

	props: ['userRole'],

	// components: {
	// 	'table-headers': require('./table-headers'),
	// },

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
				'with': ['property', 'alarm'],
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

},{}],10:[function(require,module,exports){
'use strict';

Vue.component('most-expensive-property-table', {
	props: ['userRole'],

	// components: {
	// 	'table-headers': require('./table-headers')
	// },

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

},{}],11:[function(require,module,exports){
'use strict';

Vue.component('portfolio-table', {

	// components: {
	// 	'table-headers': require('./table-headers'),
	// },

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

},{}],12:[function(require,module,exports){
'use strict';

Vue.component('property-manager-table', {

	props: ['userRole'],

	// components: {
	// 	'table-headers': require('./table-headers'),
	// },

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

},{}],13:[function(require,module,exports){
'use strict';

Vue.component('table-headers', {

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
});

},{}],14:[function(require,module,exports){
'use strict';

Vue.component('transactions-table', {
	props: ['userRole'],

	// components: {
	// 	'table-headers': require('./table-headers'),
	// },

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

			forms: {
				transaction: {}
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
		this.initializeForm();
	},

	events: {
		'table-sorted': function tableSorted(sortKey) {
			this.sortKey = sortKey;
			this.reverse = this.sortKey == sortKey ? this.reverse * -1 : 1;
			this.currentPage = 1;
			this.fetchTransactions();
		},

		'modal-hidden': function modalHidden() {
			this.refreshForm();
		}
	},

	methods: {
		fetchTransactions: function fetchTransactions() {
			var append = {
				paginate: this.paginate,
				sort: this.sortKey,
				page: this.page,
				asc: this.reverse,
				dates: {
					from: this.dates.from,
					to: this.dates.to
				}
			};

			this.$http.get('/' + this.userRole + '/transaction/all', append).success(function (result) {
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

		generateModal: function generateModal(transactionId) {
			if (typeof transactionId !== 'undefined') {
				this.populateForm(transactionId);
			}
			this.showModal();
		},

		populateForm: function populateForm(transactionId) {
			this.forms.transaction.amount = this.transactions[transactionId].amount;
			this.forms.transaction.transaction = this.transactions[transactionId];
			this.forms.transaction.description = this.transactions[transactionId].description ? this.transactions[transactionId].description : '';
			this.forms.transaction.date = this.transactions[transactionId].date;
			this.forms.transaction.payable_id = this.transactions[transactionId].payable_id, this.forms.transaction.payable_type = this.getTransactionPayable(this.transactions[transactionId]), this.forms.transaction.payable_selected = this.transactions[transactionId].address, this.forms.transaction.schedule = this.transactions[transactionId].recurring ? this.transactions[transactionId].recurring.schedule : null;
			this.forms.transaction.recurring = this.transactions[transactionId].recurring ? true : false;
			return this.forms.transaction;
		},

		initializeForm: function initializeForm() {
			this.forms.transaction = new TSForm({
				user_id: TenantSync.landlord,
				amount: '',
				description: '',
				transaction: null,
				date: '',
				payable_id: TenantSync.landlord,
				payable_type: 'user',
				payable_search: ' ',
				payable_selected: 'General',
				recurring: false,
				schedule: null
			});
		},

		refreshForm: function refreshForm() {
			this.initializeForm();
		},

		showModal: function showModal() {
			this.$broadcast('show-modal');
		},

		submitTransaction: function submitTransaction() {
			if (this.forms.transaction.transaction) {
				this.updateTransaction();
			} else {
				this.createTransaction();
			}
		},

		setPayable: function setPayable(type, id, string) {
			this.forms.transaction.is_rent == false;
			this.forms.transaction.payable_type = type;
			if (type == 'user') {
				this.forms.transaction.payable_selected = 'General';
				this.forms.transaction.payable_id = TenantSync.landlord;
				return true;
			}

			this.forms.transaction.payable_selected = string;
			this.forms.transaction.payable_id = id;
			return true;
		},

		createTransaction: function createTransaction() {
			var self = this;

			TS.post('/' + this.userRole + '/transaction', this.forms.transaction).then(function (transaction) {
				self.$broadcast('hide-modal');
				self.refreshForm();
				self.fetchTransactions(1, self.sortKey, self.reverse);
			});
		},

		updateTransaction: function updateTransaction() {
			var self = this;

			TS.patch('/' + this.userRole + '/transaction/' + this.forms.transaction.transaction.id, this.forms.transaction).then(function (transaction) {
				self.$broadcast('hide-modal');
				self.refreshForm();
				self.fetchTransactions(1, self.sortKey, self.reverse);
			});
		},

		deleteTransaction: function deleteTransaction(id) {
			var self = this;
			TS['delete']('/' + this.userRole + '/transaction/' + id, this.forms.transaction).then(function () {
				self.fetchTransactions(1, self.sortKey, self.reverse);
			});
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

},{}],15:[function(require,module,exports){
'use strict';

Vue.http.headers.common['X-CSRF-TOKEN'] = document.getElementById('_token').getAttribute('value');

Vue.config.debug = true;

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

Vue.prototype.numeral = window.numeral;
Vue.prototype.moment = window.moment;
Vue.prototype._ = window._;

Vue.mixin({
	methods: {
		generateUrlVars: function generateUrlVars(includes) {
			var include = $.param(includes);
			return include;
		},

		toTitleCase: function toTitleCase(string) {
			var strings = string.replace('_', ' ').split(' ');
			for (var i = 0; i < strings.length; i++) {
				strings[i] = strings[i].charAt(0).toUpperCase() + strings[i].slice(1);
			}
			return strings.join(' ');
		},

		confirm: function confirm(action, object, id) {
			swal({
				title: 'Just Checking',
				text: 'Are you sure you want to ' + action + ' this ' + object.toLowerCase() + '?',
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes',
				closeOnConfirm: true }, (function (confirmed) {
				return confirmed ? this[action + object](id) : false;
			}).bind(this));
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

/* TenantSync Initializing */
window.TS = {};

},{}]},{},[1]);

//# sourceMappingURL=app.js.map
