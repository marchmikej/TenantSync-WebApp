(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
// Get all the random stuff in the vue-helpers file
'use strict';

require('./vue-helpers.js');

// Get all the table components
require('./tables/table-headers.js');

// Get all the form components
require('./forms/bootstrap.js');
require('./forms/transaction-form.js');

// Get all the table instances
require('./tables/instance.js');
require('./tables/devices-table.js');
require('./tables/most-expensive-property-table.js');
require('./tables/portfolio-table.js');
require('./tables/property-manager-table.js');
require('./tables/transactions-table.js');

// Get modal stuff
require('./components/modal.js');

// Get the Stat components
require('./components/portfolio-stats.js');
require('./components/accounting-stats.js');
require('./components/recent-maintenance.js');
require('./components/recent-messages.js');

},{"./components/accounting-stats.js":2,"./components/modal.js":3,"./components/portfolio-stats.js":4,"./components/recent-maintenance.js":5,"./components/recent-messages.js":6,"./forms/bootstrap.js":7,"./forms/transaction-form.js":12,"./tables/devices-table.js":13,"./tables/instance.js":14,"./tables/most-expensive-property-table.js":15,"./tables/portfolio-table.js":16,"./tables/property-manager-table.js":17,"./tables/table-headers.js":18,"./tables/transactions-table.js":19,"./vue-helpers.js":20}],2:[function(require,module,exports){
'use strict';

Vue.component('accounting-stats', {

	data: function data() {
		return {
			showStat: {
				net_income: false,
				expenses: false,
				recurring: false,
				revenue: false
			},

			forms: {
				recurringTransaction: {}
			},

			transactions: [],

			recurringTransactions: []
		};
	},

	ready: function ready() {
		this.fetchTransactions();
		this.fetchRecurringTransactions();
	},

	events: {
		'modal-hidden': function modalHidden() {
			this.hideStats();
		},

		'transactions-updated': function transactionsUpdated() {
			this.fetchTransactions();
			this.fetchRecurringTransactions();
		}
	},

	computed: {
		stats: function stats() {
			return {
				net_income: this.netIncome(),
				expenses: this.expenses(),
				recurring: this.recurring(),
				revenue: this.revenue()
			};
		}
	},

	methods: {
		fetchTransactions: function fetchTransactions() {
			var data = {
				from: '-1 month',
				set: 'address'
			};

			this.$http.get('/api/transactions', data).success(function (transactions) {
				this.transactions = transactions;
			});
		},

		fetchRecurringTransactions: function fetchRecurringTransactions() {
			var data = {
				set: ['address']
			};

			this.$http.get('/api/transactions/recurring', data).success(function (recurringTransactions) {
				this.recurringTransactions = recurringTransactions;
			});
		},

		toggleStat: function toggleStat(stat) {
			this.showStat[stat] = !this.showStat[stat];

			this.$dispatch('show-modal', 'stat-modal');
		},

		hideStats: function hideStats() {
			for (var i = 0; i < _.size(this.showStat); i++) {
				var key = Object.keys(this.showStat)[i];

				this.showStat[key] = false;
			}
		},

		generateRecurringModal: function generateRecurringModal(id) {
			this.$dispatch('recurring-modal-generated', _.find(this.recurringTransactions, { id: id }));
			this.$dispatch('show-modal', 'recurring-modal');
		},

		deleteRecurringTransaction: function deleteRecurringTransaction(id) {
			this.$dispatch('delete-recurring', id);
		},

		netIncome: function netIncome() {
			return _.reduce(this.transactions, function (initial, transaction) {
				return initial + Number(transaction.amount);
			}, 0);
		},

		expenseTransactions: function expenseTransactions() {
			return _.filter(this.transactions, function (transaction) {
				return Number(transaction.amount) < 0;
			});
		},

		expenses: function expenses() {
			var transactions = this.expenseTransactions();

			return _.reduce(transactions, function (initial, transaction) {
				return initial + Number(transaction.amount);
			}, 0);
		},

		recurring: function recurring() {
			return _.reduce(this.recurringTransactions, function (initial, transaction) {
				return initial + Number(transaction.amount);
			}, 0);
		},

		revenueTransactions: function revenueTransactions() {
			return _.filter(this.transactions, function (transaction) {
				return Number(transaction.amount) > 0;
			});
		},

		revenue: function revenue() {
			var transactions = this.revenueTransactions();

			return _.reduce(transactions, function (initial, transaction) {
				return initial + Number(transaction.amount);
			}, 0);
		}
	}
});

},{}],3:[function(require,module,exports){
'use strict';

Vue.component('modal', {
	props: ['title', 'id'],

	template: '<div><div v-if="visible" class="vue-modal row">\
	<div id="modal" class="modal-dialog">\
		<div class="modal-content col-sm-12 p-b m-b">\
			<div class="modal-header row">\
	        	<button @click="hide" class="col-sm-1 icon icon-cross btn btn-clear" :class="{\'col-sm-offset-11\' : !title}"></button>\
	        	<h4 v-if="title" class="modal-title">{{ title}}</h4>\
	      	</div>\
		  	<div class="modal-body">\
		  		<slot></slot>\
		  	</div>\
		</div><!-- /.modal-content -->\
	</div><!-- /.modal-dialog -->\
</div></div>',

	data: function data() {
		return {
			visible: false
		};
	},

	events: {
		'show-modal': function showModal(id) {
			if (id == this.id) {
				this.show();
			}
		},

		'hide-modal': function hideModal() {
			this.hide();
		},

		'toggle-modal': function toggleModal() {
			this.visible = !this.visible;
		}
	},

	methods: {
		show: function show() {
			this.visible = true;
			this.$dispatch('modal-shown');
		},

		hide: function hide() {
			this.visible = false;
			this.$dispatch('modal-hidden');
		}
	}

});

},{}],4:[function(require,module,exports){
'use strict';

Vue.component('portfolio-stats', {

	data: function data() {
		return {
			showStat: {
				paid_rent: false,
				deliquent_rent: false,
				vacant_rent: false
			},

			properties: [],

			transactions: [],

			rentBills: []
		};
	},

	computed: {
		stats: function stats() {
			return {
				roi: this.averageRoi(),
				paid_rent: this.paidRent(),
				deliquent_rent: this.deliquentRent(),
				vacant_rent: this.vacantRent()
			};
		}
	},

	events: {
		'modal-hidden': function modalHidden() {
			this.hideStats();
		}
	},

	ready: function ready() {
		this.fetchRentBills();

		this.fetchTransactions();

		this.fetchProperties();
	},

	methods: {
		fetchRentBills: function fetchRentBills() {
			var data = {
				from: '-1 year',

				'with': ['device']
			};

			this.$http.get('/api/rent-bills', data).success(function (rentBills) {
				this.rentBills = rentBills;
			});
		},

		fetchProperties: function fetchProperties() {
			var data = {
				set: ['transactions', 'roi']
			};

			return this.$http.get('/api/properties', data).success(function (properties) {
				this.properties = properties;
			});
		},

		fetchTransactions: function fetchTransactions() {
			var data = {
				from: '-1 year',

				set: ['address']
			};

			this.$http.get('/api/transactions', data).success(function (transactions) {
				this.transactions = transactions;
			});
		},

		toggleStat: function toggleStat(stat) {
			this.showStat[stat] = !this.showStat[stat];

			this.$broadcast('show-modal');
		},

		hideStats: function hideStats() {
			for (var i = 0; i < _.size(this.showStat); i++) {
				var key = Object.keys(this.showStat)[i];

				this.showStat[key] = false;
			}
		},

		averageRoi: function averageRoi() {
			var roiSum = _.reduce(this.properties, function (initial, property) {
				return initial + Number(property.roi);
			}, 0);

			var roiAsFraction = roiSum / this.properties.length;

			return numeral(roiAsFraction).format('0%');
		},

		paidRentTransactions: function paidRentTransactions() {
			return _.filter(this.transactions, function (transaction) {
				var from = Number(moment().subtract(1, 'year').format('X'));

				var transactionDate = Number(moment(transaction.date).format('X'));

				if (from < transactionDate && transaction.payable_type == 'TenantSync\\Models\\Device') {
					return true;
				}

				return false;
			});
		},

		paidRent: function paidRent() {
			var transactions = this.paidRentTransactions();

			return _.reduce(transactions, function (initial, transaction) {
				return initial + Number(transaction.amount);
			}, 0);
		},

		deliquentDevices: function deliquentDevices() {
			var deviceListWithDuplicates = _.pluck(this.rentBills, 'device');

			var devices = [];

			_.each(deviceListWithDuplicates, function (device) {
				if (_.find(devices, { 'id': device.id })) {
					return false;
				}

				return devices.push(device);
			});

			_.each(devices, (function (device) {
				var rentBills = _.where(this.rentBills, { 'device_id': device.id });

				var rentPayments = _.where(this.paidRentTransactions(), { 'payable_id': device.id });

				var rentBillTotal = _.reduce(rentBills, function (initial, bill) {
					return initial + Number(bill.bill_amount);
				}, 0);

				var rentPaymentTotal = _.reduce(rentPayments, function (initial, payment) {
					return initial + Number(payment.amount);
				}, 0);

				if (rentBillTotal > rentPaymentTotal) {
					device.balance_due = rentBillTotal - rentPaymentTotal;
				}
			}).bind(this));

			devices = _.filter(devices, function (device) {
				return device.balance_due;
			});

			return devices;
		},

		deliquentRent: function deliquentRent() {
			var totalBills = _.reduce(this.rentBills, function (initial, bill) {
				return initial + Number(bill.bill_amount);
			}, 0);

			return totalBills - this.paidRent();
		},

		vacantRentBills: function vacantRentBills() {
			return _.filter(this.rentBills, function (bill) {
				return bill.vacant;
			});
		},

		vacantRent: function vacantRent() {
			var bills = this.vacantRentBills();

			return _.reduce(bills, function (initial, bill) {
				return initial + Number(bill.bill_amount);
			}, 0);
		}
	}
});

},{}],5:[function(require,module,exports){
'use strict';

Vue.component('recent-maintenance', {

	data: function data() {
		return {

			maintenanceRequests: [],

			forms: {
				message: new TSForm({
					device_id: [],
					body: '',
					search: null
				})
			}
		};
	},

	ready: function ready() {
		this.fetchMaintenance();
	},

	methods: {
		fetchMaintenance: function fetchMaintenance() {
			var data = {
				'with': ['device'],
				limit: 5
			};

			this.$http.get('/api/maintenance/', data).success(function (maintenance) {
				this.maintenanceRequests = maintenance;
			});
		}
	}
});

},{}],6:[function(require,module,exports){
'use strict';

Vue.component('recent-messages', {

	data: function data() {
		return {
			messages: [],

			properties: [],

			numeral: window.numeral,

			forms: {
				message: new TSForm({
					device_id: [],
					body: '',
					search: null
				})
			}
		};
	},

	ready: function ready() {
		this.fetchMessages();
		this.fetchProperties();
	},

	events: {
		'modal-hidden': function modalHidden() {
			this.forms.message.device_id = [], this.forms.message.body = '', this.forms.message.search = null;
		}
	},

	methods: {

		fetchMessages: function fetchMessages() {
			var data = {
				limit: 5,
				'with': ['device']
			};

			this.$http.get('/api/messages', data).success(function (messages) {
				this.messages = messages;
			});
		},

		fetchProperties: function fetchProperties() {
			var data = {
				'with': ['devices']
			};

			this.$http.get('/api/properties', data).success(function (properties) {
				this.properties = properties;
			});
		},

		newMessage: function newMessage() {
			this.$broadcast('show-modal', 'message-modal');
		},

		sendMessage: function sendMessage() {
			TS.post('/api/messages', this.forms.message).then((function (response) {
				swal('Success!', 'Your message has been sent');
				this.$broadcast('hide-modal');
			}).bind(this));
		},

		toggleAllDevices: function toggleAllDevices(event) {
			if (event.target.checked) {
				$('[data-name^=property').each(function (index, element) {

					if (!element.checked) {
						element.click();
					}

					return true;
				});

				return true;
			}

			$('#message-form input[type="checkbox"]').each((function (index, element) {
				this.removeDeviceFromMessage(element);
			}).bind(this));
		},

		toggleDevicesInProperty: function toggleDevicesInProperty(event) {
			var checkbox = event.target;

			var selector = checkbox.parentElement.parentElement;

			$(selector).find(':checkbox').each((function (index, element) {
				if (element.dataset.name == event.target.dataset.name) {
					return true;
				}

				if (event.target.checked === true) {
					if (!element.checked) {
						this.addDeviceToMessage(element);
					}

					return true;
				}

				this.removeDeviceFromMessage(element);
			}).bind(this));
		},

		toggleDeviceForMessage: function toggleDeviceForMessage(event) {
			var element = event.target;

			if (element.checked) {
				this.addDeviceToMessage(element);

				return true;
			}

			this.removeDeviceFromMessage(element);
		},

		addDeviceToMessage: function addDeviceToMessage(element) {
			this.forms.message.device_id.push(Number(element.dataset.id));

			return element.checked = true;
		},

		removeDeviceFromMessage: function removeDeviceFromMessage(element) {
			this.forms.message.device_id.$remove(Number(element.dataset.id));

			element.checked = false;
		}
	}
});

},{}],7:[function(require,module,exports){
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

},{"./components":8,"./errors":9,"./http":10,"./instance":11}],8:[function(require,module,exports){
/**
 * Text field input component for Bootstrap.
 */
'use strict';

Vue.component('ts-text', {
    props: ['display', 'form', 'name', 'input', 'show'],

    template: '<div><div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input type="text" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div></div>'
});

/**
 * Date field input component for Bootstrap.
 */
Vue.component('ts-date', {
    props: ['display', 'form', 'name', 'input', 'show'],

    template: '<div><div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input type="date" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div></div>'
});

/**
 * E-mail field input component for Bootstrap.
 */
Vue.component('ts-email', {
    props: ['display', 'form', 'name', 'input', 'show'],

    template: '<div><div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input type="email" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div></div>'
});

/**
 * Password field input component for Bootstrap.
 */
Vue.component('ts-password', {
    props: ['display', 'form', 'name', 'input', 'show'],

    template: '<div><div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input type="password" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div></div>'
});

/**
 * Checkbox field input component for Bootstrap.
 */
Vue.component('ts-checkbox', {
    props: ['display', 'form', 'name', 'input', 'show'],

    template: '<div><div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input type="checkbox" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div></div>'
});

/**
 * Select input component for Bootstrap.
 */
Vue.component('ts-select', {
    props: ['display', 'form', 'name', 'items', 'input', 'show'],

    template: '<div><div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
            <slot></slot>\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div></div>'
});

/**
 * Textarea input component for Bootstrap.
 */
Vue.component('ts-textarea', {
    props: ['display', 'form', 'name', 'items', 'input', 'show'],

    template: '<div><div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <textarea v-model="input" class="form-control" rows="4"></textarea>\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div></div>'
});

/**
 * General Input field input component for Bootstrap.
 */
Vue.component('ts-input', {
    props: ['display', 'form', 'name', 'input', 'show', 'type'],

    template: '<div><div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input :type="type" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div></div>'
});

},{}],9:[function(require,module,exports){
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

},{}],10:[function(require,module,exports){
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

},{}],11:[function(require,module,exports){
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

},{}],12:[function(require,module,exports){
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

},{"./components.js":8}],13:[function(require,module,exports){
'use strict';

Vue.component('devices-table', TSTable.extend({

	data: function data() {
		return {

			perPage: 10,

			listName: 'devices',

			columns: [{
				name: 'address',
				label: 'Address',
				width: 'col-sm-6',
				isSortable: false
			}, {
				name: 'rent_owed',
				label: 'Rent Owed',
				width: 'col-sm-2',
				isSortable: true
			}, {
				name: 'status',
				label: 'Status',
				width: 'col-sm-2',
				isSortable: true
			}, {
				name: 'alarm_id',
				label: 'Alarm',
				width: 'col-sm-2',
				isSortable: true
			}],

			devices: []
		};
	},

	ready: function ready() {
		this.fetchDevices();
	},

	methods: {
		fetchDevices: function fetchDevices() {
			var data = {
				'with': ['property', 'alarm'],
				set: ['address', 'rent_owed']
			};

			this.$http.get('/api/devices', data).success(function (list) {
				this.devices = list;
				for (var i = 0; i < list.length; i++) {
					list[i].rent_amount = Number(list[i].rent_amount);
				}
			});
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

}));

},{}],14:[function(require,module,exports){
'use strict';

window.TSTable = Vue.component('ts-table', {

	props: [{
		name: 'search',
		'default': null
	}],

	data: function data() {
		return {
			sortKey: null,

			reverse: -1,

			currentPage: 1,

			lastPage: 1,

			perPage: 15,

			range: {
				from: moment().subtract(1, 'month').format(dateString),
				to: moment().format(dateString)
			}
		};
	},

	computed: {
		filteredList: function filteredList() {
			var filter = Vue.filter('filterBy');
			return filter(this[this.listName], this.search);
		},

		lastPage: function lastPage() {
			return Math.ceil(Number(_.size(this.filteredList)) / Number(this.perPage));
		}
	},

	events: {
		'table-sorted': function tableSorted(sortKey) {
			this.sortKey = sortKey;
			this.reverse = this.sortKey == sortKey ? this.reverse * -1 : 1;
		},

		'modal-hidden': function modalHidden() {
			if (this.hasOwnProperty('modalHidden')) {
				this.modalHidden();
			}
		}
	},

	methods: {

		previousPage: function previousPage() {
			this.currentPage--;
		},

		nextPage: function nextPage() {
			this.currentPage++;
		},

		isLastPage: function isLastPage() {
			return this.currentPage == this.lastPage;
		},

		inCurrentPage: function inCurrentPage(index) {
			return (this.currentPage - 1) * this.perPage <= index && index < this.currentPage * this.perPage;
		}
	}
});

},{}],15:[function(require,module,exports){
'use strict';

Vue.component('most-expensive-property-table', {
	props: ['userRole'],

	// components: {
	// 	'table-headers': require('./table-headers')
	// },

	data: function data() {
		return {

			columns: [{
				name: 'address',
				label: 'Address',
				width: 'col-sm-10',
				isSortable: false
			}, {
				name: 'expenses',
				label: 'Expenses MTD',
				width: 'col-sm-2',
				isSortable: false
			}],

			properties: []
		};
	},

	ready: function ready() {
		this.fetchProperties();
	},

	methods: {

		fetchProperties: function fetchProperties() {
			var data = {
				set: ['transactions']
			};

			this.$http.get('/api/properties', data).success(function (properties) {
				this.properties = _.map(properties, (function (property) {
					return this.setTotalExpenses(property);
				}).bind(this));
			});
		},

		setTotalExpenses: function setTotalExpenses(property) {
			var transactions = _.filter(property.transactions, function (transaction) {
				return moment(transaction.date) >= moment().subtract(1, 'month');
			});
			var totalExpenses = _.reduce(transactions, function (memo, transaction) {
				return Number(memo) + Number(transaction.amount) * -1;
			}, 0);
			property = _.extend(property, { totalExpenses: totalExpenses });
			return property;
		}
	}

});

},{}],16:[function(require,module,exports){
'use strict';

Vue.component('portfolio-table', TSTable.extend({

	// components: {
	// 	'table-headers': require('./table-headers'),
	// },

	data: function data() {
		return {
			perPage: 10,

			listName: 'properties',

			columns: [{
				name: 'address',
				label: 'Address',
				width: 'col-sm-5',
				isSortable: false
			}, {
				name: 'roi',
				label: 'ROI YTD',
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

			properties: []
		};
	},

	events: {
		'table-sorted': function tableSorted(sortKey) {
			this.sortKey = sortKey;
			this.reverse = this.sortKey == sortKey ? this.reverse * -1 : 1;
			// this.currentPage = 1;
		}
	},

	ready: function ready() {
		this.fetchProperties();
	},

	methods: {

		fetchProperties: function fetchProperties(page, sortKey, reverse) {
			var data = {
				'with': ['devices'],
				set: ['roi']
			};

			this.$http.get('/api/properties', data).success(function (properties) {
				this.properties = properties;
				this.$dispatch('properties-loaded', properties);
			});
		},

		showDetails: function showDetails(id) {
			var property = _.where(this.properties, { id: id });
			$('[data-property-id=' + id + ']').toggle();
		}
	}
}));

},{}],17:[function(require,module,exports){
'use strict';

Vue.component('property-manager-table', TSTable.extend({

	data: function data() {
		return {
			perPage: 10,

			listName: 'properties',

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

			showDevices: []
		};
	},

	ready: function ready() {
		this.fetchProperties();
	},

	methods: {

		fetchProperties: function fetchProperties(page, sortKey, reverse) {
			var data = {
				'with': ['devices', 'devices.alarm'],
				set: ['roi', 'net_income', 'transactions']
			};

			this.$http.get('/api/properties', data).success(function (properties) {
				this.properties = _.map(properties, (function (property) {
					property = this.inactiveDevicesInProperty(property);
					return this.alarmsInProperty(property);
				}).bind(this));
			});
		},

		alarmsInProperty: function alarmsInProperty(property) {
			var alarms = _.filter(property.devices, function (device) {
				return device.alarm_id != 0;
			}).length;
			property = _.extend(property, { alarms: alarms });
			return property;
		},

		inactiveDevicesInProperty: function inactiveDevicesInProperty(property) {
			var inactives = _.filter(property.devices, function (device) {
				return device.status != 'active';
			}).length;
			property = _.extend(property, { inactives: inactives });
			return property;
		},

		toggleDevices: function toggleDevices(id) {
			$('[data-property-id=' + id + ']').toggle();
		}
	}

}));

},{}],18:[function(require,module,exports){
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

},{}],19:[function(require,module,exports){
'use strict';

Vue.component('transactions-table', {
	props: [{
		name: 'dates',
		'default': function _default() {
			return {
				from: moment().subtract(1, 'month').format(dateString),
				to: moment().add(1, 'year').format(dateString)
			};
		}
	}, {
		name: 'search',
		'default': null
	}],

	data: function data() {
		return {
			sortKey: 'date',

			reverse: -1,

			currentPage: 1,

			columns: [{
				name: 'amount',
				label: 'Amount',
				width: 'col-sm-2',
				isSortable: true
			}, {
				name: 'address',
				label: 'Applied To',
				width: 'col-sm-2',
				isSortable: true
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
				transaction: {},
				recurringTransaction: {}
			},

			transactionsUrl: '/api/transactions',

			propertiesUrl: '/api/properties',

			transactions: [],

			properties: []
		};
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
		},

		'modal-hidden': function modalHidden() {
			this.refreshForm();
		},

		'recurring-modal-generated': function recurringModalGenerated(transaction) {
			this.forms.recurringTransaction = new TSForm({
				id: transaction.id,
				user_id: transaction.user_id,
				amount: transaction.amount,
				description: transaction.description,
				schedule: transaction.schedule,
				day: transaction.day,
				payable_type: this.getTransactionPayable(transaction),
				payable_id: transaction.payable_id,
				payable_search: null,
				payable_selected: transaction.address,
				last_ran: moment(transaction.last_ran).format(dateString)
			});
		},

		'delete-recurring': function deleteRecurring(id) {
			this.deleteRecurringTransaction(id);
		}
	},

	methods: {

		fetchTransactions: function fetchTransactions() {
			var data = {
				set: ['address']
			};

			this.$http.get(this.transactionsUrl, data).success(function (transactions) {
				_.each(transactions, function (transaction) {
					transaction.amount = Number(transaction.amount);
				});
				this.transactions = transactions;
			});
		},

		fetchProperties: function fetchProperties() {
			var data = {
				'with': ['devices']
			};

			this.$http.get(this.propertiesUrl, data).success(function (properties) {
				this.properties = properties;
			});
		},

		submitRecurringTransaction: function submitRecurringTransaction() {
			var that = this;

			TS.patch('/api/transactions/recurring/' + this.forms.recurringTransaction.id, this.forms.recurringTransaction).then(function () {
				swal('Success!', 'Recurring transaction updated successfully!');
				that.$dispatch('transactions-updated');
			})['catch'](function () {
				swal('Error!', 'There was a problem with your input.');
			});
		},

		submitTransaction: function submitTransaction() {
			if (!this.forms.transaction.payable_id) {
				swal('Error', 'No property or device selected!');
				return false;
			}

			if (this.forms.transaction.transaction) {
				this.updateTransaction();
			} else {
				this.createTransaction();
			}
		},

		createTransaction: function createTransaction() {
			var that = this;
			TS.post('/api/transactions', this.forms.transaction).then(function (transaction) {
				that.$broadcast('hide-modal');
				that.refreshForm();
				that.fetchTransactions();
				that.$dispatch('transactions-updated');
			});
		},

		updateTransaction: function updateTransaction() {
			var that = this;

			TS.patch('/api/transactions/' + this.forms.transaction.transaction.id, this.forms.transaction).then(function (transaction) {
				that.$broadcast('hide-modal');
				that.refreshForm();
				that.fetchTransactions();
				that.$dispatch('transactions-updated');
			});
		},

		deleteRecurringTransaction: function deleteRecurringTransaction(id) {
			var that = this;

			this.$http['delete']('/api/transactions/recurring/' + id).success(function () {
				that.$dispatch('transactions-updated');
			});
		},

		deleteTransaction: function deleteTransaction(id) {
			var that = this;

			TS['delete']('/api/transactions/' + id, this.forms.transaction).then(function () {
				that.fetchTransactions();
				that.$dispatch('transactions-updated');
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
		},

		generateModal: function generateModal(transactionId) {
			if (typeof transactionId !== 'undefined') {
				this.populateForm(transactionId);
			}
			this.showModal();
		},

		showModal: function showModal() {
			this.$broadcast('show-modal', 'transaction-modal');
		},

		populateForm: function populateForm(transactionId) {
			this.forms.transaction.amount = this.transactions[transactionId].amount;
			this.forms.transaction.transaction = this.transactions[transactionId];
			this.forms.transaction.description = this.transactions[transactionId].description ? this.transactions[transactionId].description : '';
			this.forms.transaction.date = this.transactions[transactionId].date;
			this.forms.transaction.payable_id = this.transactions[transactionId].payable_id, this.forms.transaction.payable_type = this.getTransactionPayable(this.transactions[transactionId]), this.forms.transaction.payable_selected = this.transactions[transactionId].address;
			return this.forms.transaction;
		},

		initializeForm: function initializeForm() {
			this.forms.transaction = new TSForm({
				user_id: TenantSync.landlord,
				amount: '',
				description: '',
				transaction: null,
				date: '',
				payable_id: null,
				payable_type: null,
				payable_search: null,
				payable_selected: null,
				recurring: false,
				recurring_amount: null,
				schedule: 'day',
				day: null
			});
		},

		refreshForm: function refreshForm() {
			this.initializeForm();
		},

		setPayable: function setPayable(form, type, id, string) {
			form.is_rent = false;

			form.payable_type = type;

			if (type == 'user') {
				form.payable_selected = 'General';

				form.payable_id = TenantSync.landlord;

				return true;
			}
			form.payable_selected = string;

			form.payable_id = id;
			console.log(form);

			return true;
		},

		withinDates: function withinDates(transaction) {
			var from = Number(moment(this.dates.from).format('X'));

			var to = Number(moment(this.dates.to).format('X'));

			var transactionDate = Number(moment(transaction.$value.date).format('X'));

			if (from <= transactionDate && transactionDate <= to) {

				return true;
			}
			return false;
		}
	}

});

},{}],20:[function(require,module,exports){
'use strict';

Vue.config.debug = true;

Vue.http.headers.common['X-CSRF-TOKEN'] = document.getElementById('_token').getAttribute('value');

Vue.prototype.numeral = window.numeral;
Vue.prototype.moment = window.moment;
Vue.prototype._ = window._;
Vue.prototype.dateString = window.dateString;

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

		confirm: function confirm(options) {
			var method = options.method;

			var id = options.id;

			// var data = options.data;

			swal({
				title: 'Just Checking',
				text: 'Are you sure you want to do this?',
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes',
				closeOnConfirm: true }, (function (confirmed) {
				return confirmed ? this[method](id) : false;
			}).bind(this));
		},

		user: function user() {
			return TenantSync.user;
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
