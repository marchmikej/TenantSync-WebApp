<payment-methods inline-template>
	<div class="form form-horizontal">
		<div class="form-group">
			<label class="control-label col-sm-3">Payment Method</label>
			<div class="col-sm-9">
				<input :value="paymentMethods.hasOwnProperty(0) ? paymentMethods[0].MethodName : 'Add Method...'" class="col-sm-10 form-control" type="text"  placeholder="" disabled readonly/>
				<button @click.prevent="showModal = true" class="btn btn-clear col-sm-2"><span class="icon icon-edit"></span></button>
			</div>
		</div>
	</div>
	
	
	<!--// MODAL -->
	<div @click="showModal = false" v-show="showModal" id="modal" class="vue-modal" style="display: none;">
	  	<div class="modal-dialog">
	    	<div @click.stop="showModal = true" class="modal-content">
		      	<!-- <div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        	<h4 class="modal-title text-info">Edit Transaction</h4>
		      	</div> -->
		      	<form class="form form-horizontal">
					<meta type="hidden" id="_token" value="{{ csrf_token() }}">
					
					<div class="modal-body">
						<div class="form-group">
							<label class="control-label col-sm-3" for="id">Method</label>
							<div class="col-sm-9">
								<select @change="setMethodDetails" class="form-control" v-model="payment.object">
									<option :value="null" number>New Payment Method</option>
									<option v-for="paymentMethod in paymentMethods" :value="paymentMethod" number>@{{ paymentMethod.MethodName }}</option>
								</select>
							</div>
						</div>
						
						<div v-show="!payment.object" class="form-group">
							<label class="control-label col-sm-3" for="type">Type</label>
							<div class="col-sm-9">
								<select name="type" class="form-control" v-model="payment.type">
									<option :value="null" ></option>
									<option value="card">Credit Card</option>
									<option value="check">Bank Transfer</option>
								</select>
							</div>
						</div>
					
	
						<div v-if="payment.type == 'card'" id="card-fields">
	
							<div class="form-group">
								<label class="control-label col-sm-3" for="method_name">Method Name</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="method_name" placeholder="Method Name" v-model="payment.method_name"/>
								</div>
							</div>
	
							<div class="form-group">
								<label class="control-label col-sm-3" for="card_number">Card Number</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="card_number" placeholder="Card Number" v-model="payment.card_number"/>
								</div>
							</div>
	
							<div class="form-group">
								<label class="control-label col-sm-3" for="expiration">Expiration</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="expiration" placeholder="MM/YY" v-model="payment.expiration"/>
								</div>
							</div>
	
							<div class="form-group">
								<label class="control-label col-sm-3" for="cvv2">CVV2</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="cvv2" placeholder="CVV2" v-model="payment.cvv2"/>
								</div>
							</div>
						</div>
	
						<div v-if="payment.type == 'check'" id="check-fields">
							
							<div class="form-group">
								<label class="control-label col-sm-3" for="method_name">Method Name</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="method_name" placeholder="Method Name" v-model="payment.method_name"/>
								</div>
							</div>
	
							<div class="form-group">
								<label class="control-label col-sm-3" for="account_number">Account Number</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="account_number" placeholder="Account Number" v-model="payment.account_number"/>
								</div>
							</div>
	
							<div class="form-group">
								<label class="control-label col-sm-3" for="routing_number">Routing Number</label>
								<div class="col-sm-9">
									<input class="form-control" type="text" name="routing_number" placeholder="Routing Number" v-model="payment.routing_number"/>
								</div>
							</div>
						</div>
					</div>
	
					<div class="modal-footer">
						<button @click.stop="showModal = false" type="button" class="col-sm-2 btn btn-default">Close</button>
						<button @click.prevent="submitPayment" class="btn btn-primary">Submit</button>
					</div>
				</form>
	
	    	</div><!-- /.modal-content -->
	  	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</payment-methods>