@extends('TenantSync::sales/layout')

@section('content')

<div id="payment" class="row card">
	<div class="col-sm-6 col-sm-offset-3">
	<h4 class="card-header">Payment Methods</h4>
		<form class="form form-horizontal">
			<meta type="hidden" id="_token" value="{{ csrf_token() }}">
			
			<div class="form-group">
				<label class="control-label col-sm-3" for="id">Method</label>
				<div class="col-sm-9">
					<select name="id" class="form-control" v-model="payment.id">
						<option></option>
						@foreach($customer as $paymentMethod)
							<option value="{{ $paymentMethod->MethodID }}">{{ $paymentMethod->CardNumber }}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div v-show="newPaymentMethod" class="form-group">
				<label class="control-label col-sm-3" for="type">Type</label>
				<div class="col-sm-9">
					<select name="type" class="form-control" v-model="payment.id">
						<option value="card">Credit Card</option>
						<option value="ach">Bank Transfer</option>
					</select>
				</div>
			</div>

			<button @click.prevent="submitPayment" class="col-sm-3 col-sm-offset-9 btn btn-primary">Submit</button>
		</form>
	</div>
</div>

@endsection

@section('scripts')

<script>
	vue = new Vue({
		el: '#payment',

		data: {
			newPaymentMethod: false,
			payment: {
				id: null,
				type: null,
			},
		},

		methods: {
			submitPayment: function(payment) {

				this.$http.post('/sales/payment/' + payment.id, this.payment)
				.success(function(response, e) {
					e.preventDefault();
					console.log(response);
				});	
			},
		},
	})

</script>

@endsection