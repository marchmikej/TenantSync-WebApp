Vue.component('transactions-table', {
	props: ['userRole'],

	components: {
		'table-headers': require('./table-headers'),
	},

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
					selected: 'General',
				},
				recurring: false,
				schedule: null,
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
	},

	events: {
		'table-sorted': function(sortKey) {
			this.sortKey = sortKey;
			this.reverse = (this.sortKey == sortKey) ? this.reverse * -1 : 1;
			this.currentPage = 1;
			this.fetchTransactions();
		}
	},

	methods: {
		fetchTransactions: function() {
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

			this.$http.get('/'+ this.userRole +'/transaction/all?' + append)
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

		generateModal: function(id) {
			if(id + 1 > 0)
			{
				this.modal.amount = this.transactions[id].amount;
				this.modal.transaction = this.transactions[id];
				this.modal.description = (this.transactions[id].description) ? this.transactions[id].description : '';
				this.modal.date = this.transactions[id].date;
				this.modal.payable = {
					id: this.transactions[id].payable_id,
					type: this.getTransactionPayable(this.transactions[id]),
					selected: this.transactions[id].address,
				};
				this.modal.schedule = this.transactions[id].recurring ? this.transactions[id].recurring.schedule : null;
				this.modal.recurring = this.transactions[id].recurring ? true : false;
			}
			this.showModal = true;
		},

		hideModal: function() {
			this.modal = {
				amount: '',
				description: '',
				transaction: null,
				date: '',
				payable: {
					id: TenantSync.landlord,
					type: 'user',
					search: null,
					selected: 'General',
				},
				recurring: false,
				schedule: null,
			};
			this.showModal = false;
		},

		submitTransaction: function() {
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

			if(this.modal.transaction)
			{
				this.updateTransaction(data);
			}
			else
			{
				data.user_id = TenantSync.landlord;
				this.createTransaction(data);
			}
		},

		setPayable: function(type, id, string) {
			this.modal.is_rent == false;
			this.modal.payable.type = type;
			if(type == 'user') {
				this.modal.payable.selected = 'General';
				this.modal.payable.id = TenantSync.landlord;
				return true;
			}

			this.modal.payable.selected = string;
			this.modal.payable.id = id;
			return true;
		},

		createTransaction: function(data) {
			this.$http.post('/'+ this.userRole +'/transaction', data)
				.success( function(transaction){
					this.hideModal();
					this.fetchTransactions(1, this.sortKey, this.reverse);
				});
		},

		updateTransaction: function(data) {

		
			this.$http.patch('/'+ this.userRole +'/transaction/' + this.modal.transaction.id, data)
				.success( function(transaction) {
					this.hideModal();
					this.fetchTransactions(1, this.sortKey, this.reverse);
				});
		},

		deleteTransaction: function(id) {
			
			if(confirm('Are you sure you want to delete this transaction?'))
			{
				this.$http.delete('/'+ this.userRole +'/transaction/' + id)
					.success( function() {
						this.fetchTransactions(1, this.sortKey, this.reverse);
					});
			}
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
	},

});