Vue.component('transaction-form', {

	components: require('./components.js'),

	data: function() {
		return {
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
		}
	},

	ready: function() {

	},

	events: {

	},

	methods: {
		submitTransaction: function() {
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

			if(this.transaction)
			{
				this.updateTransaction(payload);
			}
			else
			{
				payload.user_id = TenantSync.landlord;
				this.createTransaction(payload);
			}
		},

		setPayable: function(type, id, string) {
			this.is_rent = false;
			this.payable.type = type;
			if(type == 'user') {
				this.payable.selected = 'General';
				this.payable.id = TenantSync.landlord;
				return true;
			}

			this.payable.selected = string;
			this.payable.id = id;
			return true;
		},

		createTransaction: function(payload) {
			this.$http.post('/'+ TenantSync.user.role +'/transaction', payload)
				.success( function(transaction){
					this.hideModal();
					this.fetchTransactions(1, this.sortKey, this.reverse);
				});
		},

		updateTransaction: function(payload) {
			this.$http.patch('/'+ TenantSync.user.role +'/transaction/' + this.transaction.id, payload)
				.success( function(transaction) {
					this.hideModal();
					this.fetchTransactions(1, this.sortKey, this.reverse);
				});
		},

		deleteTransaction: function(id) {
			this.$http.delete('/'+ TenantSync.user.role +'/transaction/' + id)
				.success( function() {
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