Vue.component('payment-methods', {
	data: function() {
		return {
			newPaymentMethod: false,
			showModal: false,
			payment: {
					object: null,
					id: null,
					type: null,
					method_name: null,
					card_number: '',
					expiration: '',
					cvv2: '',
					account_number: '',
					routing_number: '',
				},
			paymentMethods: [],
		}
	},

	ready: function() {
		this.fetchPaymentMethods();
	},

	methods: {
		fetchPaymentMethods: function() {
			this.$http.get('/landlord/payment/' + TenantSync.landlord)
			.success(function(paymentMethods) {
				this.paymentMethods = paymentMethods;
				console.log(paymentMethods);
			});
		},
		submitPayment: function(payment) {			
			this.$http.patch('/landlord/payment/' + this.payment.id, this.payment)
			.success(function(response) {
				this.fetchPaymentMethods();
				this.resetPaymentFields();
				this.showModal = false;
			});	
		},

		setMethodDetails: function() {
			if(this.payment.object == null) 
			{
				this.resetPaymentFields();
				return false;
			}

			this.payment.id = this.payment.object.MethodID;
			this.payment.object.MethodType == 'cc' ? this.setCardFields() : this.setCheckFields();

		},

		setCardFields: function() {
			this.payment.type = 'card';
			this.payment.method_name = this.payment.object.MethodName;
			this.payment.expiration = this.payment.object.CardExpiration.substring(5) + '/' + this.payment.object.CardExpiration.substring(2, 4);
			this.payment.sortOrder = 0;
		},

		setCheckFields: function() {
			this.payment.type = 'check';
			this.payment.method_name = this.payment.object.MethodName;
		},

		resetPaymentFields: function() {
			this.payment.object = null; 
			this.payment.id = null;
			this.payment.type = null;
			this.payment.method_name = null;
			this.payment.card_number = '';
			this.payment.expiration = '';
			this.payment.cvv2 = '';
			this.payment.account_number = '';
			this.payment.routing_number = '';
		},
	}
});