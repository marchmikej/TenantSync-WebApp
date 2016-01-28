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

			paginated: {},

			search: null,

			range: {
				from: moment().subtract(1, 'month').format('YYYY-MM-DD'),
			},

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
					isSortable: false
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
		}
	},

	computed: {
		dates: function() {
			return {
				from: moment(this.range.from).format(),
				to: null
			};
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
			this.currentPage = 1;
			this.fetchTransactions();
		},

		'modal-hidden': function() {
			this.refreshForm();
		},
	},

	methods: {
		fetchTransactions: function() {
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

			this.$http.get('/'+ this.userRole +'/transaction/all', append)
				.success( function(result) {
					_.each(result.data, function(transaction) { transaction.amount = Number(transaction.amount); });
					this.transactions = result.data;
					this.paginated = result;
					this.currentPage = result.current_page;
				});
		},

		fetchProperties: function() {
			var append = this.generateUrlVars({
				with: ['devices'],
			});

			this.$http.get('/'+ this.userRole +'/properties/all?' + append)
				.success( function(result) {
					this.properties = result.data;
					//console.log(result);
				});
		},

		generateModal: function(transactionId) {
			if(typeof transactionId !== 'undefined')
			{
				this.populateForm(transactionId);
			}
			this.showModal();
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
				amount: '',
				description: '',
				transaction: null,
				date: '',
				payable_id: TenantSync.landlord,
				payable_type: 'user',
				payable_search: null,
				payable_selected: 'General',
				recurring: false,
				schedule: null,
			});
		},

		refreshForm: function() {
			this.initializeForm();
		},

		showModal: function() {
			this.$broadcast('show-modal');
		},

		submitTransaction: function() {
			if(this.forms.transaction.transaction)
			{
				this.updateTransaction();
			}
			else
			{
				this.createTransaction();
			}
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

		createTransaction: function() {
			var self = this;

			TS.post('/'+ this.userRole +'/transaction', this.forms.transaction)
				.then( function(transaction){
					self.$broadcast('hide-modal');
					self.refreshForm();
					self.fetchTransactions(1, self.sortKey, self.reverse);
				});
		},

		updateTransaction: function() {
			var self = this;
		
			TS.patch('/'+ this.userRole +'/transaction/' + this.forms.transaction.transaction.id, this.forms.transaction)
				.then( function(transaction) {
					self.$broadcast('hide-modal');
					self.refreshForm();
					self.fetchTransactions(1, self.sortKey, self.reverse);
				});
		},

		deleteTransaction: function(id) {
			TS.delete('/'+ this.userRole +'/transaction/' + id)
				.then( function() {
					this.fetchTransactions(1, this.sortKey, this.reverse);
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
	},

});