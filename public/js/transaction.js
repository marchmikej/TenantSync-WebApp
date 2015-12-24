


Vue.filter('numeric', function (item, field, operator, value) {
  console.log(item);
})

var vue = new Vue({

	el: '#ledger',


	data: {
		showModal: false,

		modal: {
			amount: '',
			description: '',
			transactionId: 0,
			expense: false
		},
		
		incomes: [

		],
		expenses: [

		],

		transactions: [

		],

		properties: {

		},

		numeral: window.numeral,
	},


	ready: function() {
		this.fetchTransactions();
		this.fetchProperties();
	},


	methods: {

		generateModal: function(id) {
			this.modal.amount = '';
			this.modal.transactionId = null;
			this.modal.description = '';
			if(id)
			{
				this.modal.amount = this.transactions[id].amount;
				this.modal.transactionId = id;
				this.modal.description = (this.transactions[id].description) ? this.transactions[id].description : '';
			}
			this.showModal = true;
			// document.getElementById('modal-amount').focus();
		},

		submitTransaction: function() {
			if(this.modal.expense)
			{
				this.modal.amount = this.modal.amount * -1;
			}
			var data = {
				amount: this.modal.amount,
				description: this.modal.description
			};

			if(this.modal.transactionId)
			{
				this.updateTransaction(data);
			}
			else
			{
				data.user_id = document.getElementById('user_id').getAttribute('value');
				this.createTransaction(data);
			}
		},

		createTransaction: function(data) {
			this.$http.post('/landlord/transaction', data)
				.success( function(transaction){
					this.transactions[transaction.id] = transaction;
					this.fetchTransactions();
					this.modal.amount = '';
					this.modal.description = '';
					this.showModal = false;
				});
		},

		updateTransaction: function(data) {
			this.transactions[this.modal.transactionId].amount = this.modal.amount;
			this.transactions[this.modal.transactionId].description = this.modal.description;
		
			this.$http.patch('/landlord/transaction/' + this.modal.transactionId, data)
				.success( function(transaction) {
					console.log(transaction);
				});
			this.showModal = false;
		},

		deleteTransaction: function(id) {
			this.$http.delete('/landlord/transaction/' + id)
				.success( function() {
					delete this.transactions[id];
					console.log('Transaction deleted.')
					this.fetchTransactions();
				});
		},

		fetchTransactions: function() {
			this.$http.get('/landlord/transaction/all')
				.success( function(transactions) {
					this.transactions = transactions;
					this.incomes = [];
					this.expenses = [];
					this.splitTransactions();
				})
				// .error( function() {
				// 	console.log('Error fetching transactions');
				// })
			;
		},

		splitTransactions: function() {
			for(var transaction in this.transactions) {
				if (this.transactions[transaction].amount >= 0) {
					this.incomes.push(this.transactions[transaction]);
				}
				else {
					this.expenses.push(this.transactions[transaction]);
				}
			}

		},

		fetchProperties: function() {
			this.$http.get('/landlord/properties/all?sortBy=netIncome')
			.success(function(properties) {
				this.properties = properties;
			});
		}

	},


	// filters: {
	// 	numeric: function(array, field, operator, value ) {
	// 		console.log(array);
	// 		// return array.filter(function(item) {
	// 		// 	console.log(item);
	// 		// 	if (item.$value)
	// 		// 	{
	// 		// 		return math[operator](item.$value[field], value)  ? item : null;
	// 		// 	}
	// 		// });
	// 	}
	// }
});