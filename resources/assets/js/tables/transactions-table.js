Vue.component('transactions-table', {
	props: ['userRole'],

	// components: {
	// 	'table-headers': require('./table-headers'),
	// },

	data: function() {
		return {
			sortKey: 'date',

			reverse: -1,

			currentPage: 1,

			search: null,

			columns: [
				{
					name: 'amount',
					label: 'Amount',
					width: 'col-sm-2',
					isSortable: true
				},
				{
					name: 'address',
					label: 'Applied To',
					width: 'col-sm-2',
					isSortable: true
				},
				{
					name: 'description',
					label: 'Description',
					width: 'col-sm-5',
					isSortable: true
				},
				{
					name: '',
					label: '',
					width: 'col-sm-1',
					isSortable: false
				},
				{
					name: 'date',
					label: 'date',
					width: 'col-sm-1',
					isSortable: true
				},
				{
					name: '',
					label: '',
					width: 'col-sm-1',
					isSortable: false
				}
			],

			forms : {
				transaction: {},
			},

			transactions: [],

			properties: [],

			dates: {
				from: moment().subtract(1, 'month').format(dateString),
				to: moment().format(dateString)
			},
		}
	},

	ready: function() {
		this.fetchTransactions();
		this.fetchProperties();
		this.initializeForm();
	},

	events: {
		'table-sorted': function(sortKey) {
			this.sortKey = sortKey;
			this.reverse = (this.sortKey == sortKey) ? this.reverse * -1 : 1;
			//this.currentPage = 1;
			//this.fetchTransactions();
		},

		'modal-hidden': function() {
			this.refreshForm();
		},
	},

	methods: {

		fetchTransactions: function() {
			var data = {
				set: ['address']
			};
			this.$http.get('/api/transactions', data)
				.success( function(transactions) {
					_.each(transactions, function(transaction) { transaction.amount = Number(transaction.amount); });
					this.transactions = transactions;
				});
		},

		fetchProperties: function() {
			var data = {
				with: ['devices'],
			};

			this.$http.get('/api/properties', data)
				.success( function(properties) {
					this.properties = properties;
					//console.log(result);
				});
		},

		submitTransaction: function() {
			if(! this.forms.transaction.payable_id) {
				swal( 'Error', 'No property or device selected!');
				return false;
			}

			if(this.forms.transaction.transaction)
			{
				this.updateTransaction();
			}
			else
			{
				this.createTransaction();
			}
		},

		createTransaction: function() {
			var that = this;
			TS.post('/api/transactions', this.forms.transaction)
				.then( function(transaction){
					that.fetchTransactions();
					that.$broadcast('hide-modal');
					that.refreshForm();
				});
		},

		updateTransaction: function() {
			var that = this;
		
			TS.patch('/api/transactions/' + this.forms.transaction.transaction.id, this.forms.transaction)
				.then( function(transaction) {
					that.$broadcast('hide-modal');
					that.refreshForm();
					that.fetchTransactions();
				});
		},

		deleteTransaction: function(id) {
			var that = this;

			TS.delete('/api/transactions/' + id, this.forms.transaction)
				.then( function() {
					that.fetchTransactions();
				});
		},

		getTransactionPayable: function(transaction) {
				
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

		generateModal: function(transactionId) {
			if(typeof transactionId !== 'undefined')
			{
				this.populateForm(transactionId);
			}
			this.showModal();
		},

		showModal: function() {
			this.$broadcast('show-modal');
		},

		populateForm: function(transactionId) {
			this.forms.transaction.amount = this.transactions[transactionId].amount;
			this.forms.transaction.transaction = this.transactions[transactionId];
			this.forms.transaction.description = (this.transactions[transactionId].description) ? this.transactions[transactionId].description : '';
			this.forms.transaction.date = this.transactions[transactionId].date;
			this.forms.transaction.payable_id = this.transactions[transactionId].payable_id,
			this.forms.transaction.payable_type = this.getTransactionPayable(this.transactions[transactionId]),
			this.forms.transaction.payable_selected = this.transactions[transactionId].address,
			this.forms.transaction.schedule = this.transactions[transactionId].recurring ? this.transactions[transactionId].recurring.schedule : null;
			this.forms.transaction.recurring = this.transactions[transactionId].recurring ? true : false;
			return this.forms.transaction;
		},

		initializeForm: function() {
			this.forms.transaction = 
			new TSForm({
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
				schedule: null,
			});
		},

		refreshForm: function() {
			this.initializeForm();
		},

		setPayable: function(type, id, string) {
			this.forms.transaction.is_rent == false;
			this.forms.transaction.payable_type = type;
			if(type == 'user') {
				this.forms.transaction.payable_selected = 'General';
				this.forms.transaction.payable_id = TenantSync.landlord;
				return true;
			}

			this.forms.transaction.payable_selected = string;
			this.forms.transaction.payable_id = id;
			return true;
		},

		withinDates: function(transaction) {
			var from = Number(moment(this.dates.from).format('X'));

			var to = Number(moment(this.dates.to).format('X'));

			var transactionDate = Number(moment(transaction.$value.date).format('X'));

			if(from <= transactionDate && transactionDate <= to) {

				return true;

			}
			return false;
		},
	},

});