Vue.component('transactions-table', {
	props: ['userRole'],

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
				recurringTransaction: {},
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
		},

		'modal-hidden': function() {
			this.refreshForm();
		},

		'recurring-modal-generated': function(transaction) {
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
				last_ran: moment(transaction.last_ran).format(dateString),
			});
		},

		'delete-recurring': function(id) {
			this.deleteRecurringTransaction(id);
		}
	},

	methods: {

		fetchTransactions: function() {
			var data = {
				set: ['address'],
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
				});
		},

		submitRecurringTransaction: function() {
			var that = this;

			TS.patch('/api/transactions/recurring/'+ this.forms.recurringTransaction.id, this.forms.recurringTransaction)
				.then(function() {
					swal(
						'Success!',
							'Recurring transaction updated successfully!'
					);
					that.$dispatch('transactions-updated');
				})
				.catch(function() {
					swal(
						'Error!',
							'There was a problem with your input.'
					);
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
					that.$broadcast('hide-modal');
					that.refreshForm();
					that.fetchTransactions();
					that.$dispatch('transactions-updated');
				});
		},

		updateTransaction: function() {
			var that = this;
		
			TS.patch('/api/transactions/' + this.forms.transaction.transaction.id, this.forms.transaction)
				.then( function(transaction) {
					that.$broadcast('hide-modal');
					that.refreshForm();
					that.fetchTransactions();
					that.$dispatch('transactions-updated');
				});
		},

		deleteRecurringTransaction: function(id) {
			var that = this;

			this.$http.delete('/api/transactions/recurring/' + id)
				.success( function() {
					that.$dispatch('transactions-updated');
				});
		},

		deleteTransaction: function(id) {
			var that = this;

			TS.delete('/api/transactions/' + id, this.forms.transaction)
				.then( function() {
					that.fetchTransactions();
					that.$dispatch('transactions-updated');
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
			this.$broadcast('show-modal', 'transaction-modal');
		},

		populateForm: function(transactionId) {
			this.forms.transaction.amount = this.transactions[transactionId].amount;
			this.forms.transaction.transaction = this.transactions[transactionId];
			this.forms.transaction.description = (this.transactions[transactionId].description) ? this.transactions[transactionId].description : '';
			this.forms.transaction.date = this.transactions[transactionId].date;
			this.forms.transaction.payable_id = this.transactions[transactionId].payable_id,
			this.forms.transaction.payable_type = this.getTransactionPayable(this.transactions[transactionId]),
			this.forms.transaction.payable_selected = this.transactions[transactionId].address;
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
				recurring_amount: null,
				schedule: 'day',
				day: null,
			});
		},

		refreshForm: function() {
			this.initializeForm();
		},

		setPayable: function(form, type, id, string) {
			form.is_rent = false;

			form.payable_type = type;

			if(type == 'user') {
				form.payable_selected = 'General';

				form.payable_id = TenantSync.landlord;

				return true;
			}
			form.payable_selected = string;

			form.payable_id = id;
			console.log(form);

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