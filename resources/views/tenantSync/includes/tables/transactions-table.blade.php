<transactions-table  user-role="{{ Auth::user()->role }}" inline-template>
		<div class="card row">
			<div class="col-sm-12">
				<h3 class="card-header">
					<div>
						Transactions
						<button @click="generateModal()" class=" btn btn-clear text-primary p-y-0"><h3 class="m-a-0 icon icon-plus"></h3></button>
						<input type="text" class="col-sm-2 col-xs-12 pull-right form-control" placeholder="search..." v-model='search'>
						<input @change="fetchTransactions()" type="date" class="col-sm-2 col-xs-12 pull-right form-control" v-model="range.from">
					</div>
				</h3>

				<table-headers :columns="columns" :sort-key.sync="sortKey" :reverse.sync="reverse"></table-headers>

				<div class="table-body table-striped">
					<div v-for="transaction in transactions | orderBy sortKey reverse | search search" class="table-row row">
						<div :class="transaction.amount > 0 ? 'text-success' : 'text-danger'" class="col-sm-2"><strong>@{{ transaction.amount }}</strong></div>
						<div class="col-sm-2">@{{ transaction.address }}</div>
						<div class="col-sm-6">@{{ transaction.description }}</div>
						<div class="col-sm-1">@{{ (transaction.date.substring(5) + '/' + transaction.date.substring(2, 4)).replace('-', '/') }}</div>
						<div class="col-sm-1">
							<button @click=" generateModal( $index )" class="btn btn-clear p-a-0"><span class="text-primary icon icon-edit"></span></button>
							<button @click=" deleteTransaction( transaction.id )" class="btn btn-clear p-y-0 p-r-0"><span class="text-danger icon icon-cross"></span></button>
						</div>
					</div>
				</div>
				
			<!-- 	<div class="col-sm-4 col-sm-offset-4 text-center">
					<button class="btn btn-clear text-primary"
						v-if="paginated.current_page > 1"
						@click="fetchTransactions(paginated.current_page - 1, sortKey, reverse)" 
					>
						<span class="icon icon-chevron-left"></span>
					</button>
					<button class="btn btn-clear text-primary"
						v-if="paginated.last_page > 1"
						@click="fetchTransactions(paginated.current_page + 1, sortKey, reverse)"
					>
						<span class="icon icon-chevron-right"></span>
					</button>
				</div> -->

			</div>
		</div>

		<!--// MODAL -->
		<div v-show="showModal" id="modal" class="vue-modal" style="display: none;">
		  	<div class="modal-dialog">
		    	<div class="modal-content">
			      	<!-- <div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        	<h4 class="modal-title text-info">Edit Transaction</h4>
			      	</div> -->
			      	<form @keyup.enter=" submitTransaction" class="form form-horizontal">
			      		<meta type="hidden" id="_token" value="{{ csrf_token() }}">
			      		<div class="modal-body">
							
							<div class="form-group">
								<label class="control-label col-sm-3" for="payable">Apply To</label>
								<div class="col-sm-9">
									<input v-model="modal.payable.selected" class="form-control col-sm-8" type="text" style="border: none;" readonly />
									<input v-model="modal.payable.search" class="form-control col-sm-4" type="text" name="payable" placeholder="Search..."/>
								</div>
							</div>

							<div v-show="modal.payable.search" class="well col-sm-9 col-sm-offset-3" style="max-height: 150px; overflow-y: scroll;">
								<ul class="list-select">
									<li @click.stop="setPayable('user')"><strong>General</strong></li>
									<li @click.stop="setPayable('property', property.id, property.address)" v-for="(key, property) in properties | search modal.payable.search" class="col-sm-12">
										<strong>@{{ property.address }}</strong>
										<ul>
											<li @click.stop="setPayable('device', device.id, property.address + ', ' + device.location)" v-for="device in property.devices" >
												@{{ device.location }}
											</li>
										</ul>
									</li>
								</ul>
							</div>

							<div v-if="modal.payable.type == 'device'" class="form-group">
								<label class="control-label col-sm-3" for="is_rent">Rent Payment</label>
								<div class="col-sm-9">
									<input v-model="modal.is_rent" class="form-control" type="checkbox" name="is_rent" value=""/>
								</div>
							</div>

			        		<div class="form-group">
			        			<label class="control-label col-sm-3" for="amount">Amount</label>
			        			<div class="col-sm-9">
			        				<input id="modal-amount" class="form-control" type="text" name="amount" placeholder="Amount" v-model="modal.amount"/>
			        			</div>
			        		</div>

			        		<div class="form-group">
			        			<label class="control-label col-sm-3" for="description">Description</label>
			        			<div class="col-sm-9">
			        				<input class="form-control" type="text" name="description" placeholder="Description" v-model="modal.description"/>
			        			</div>
			        		</div>

			        		<div class="form-group">
			        			<label class="control-label col-sm-3" for="date">Date</label>
			        			<div class="col-sm-9">
			        				<input class="form-control" type="date" name="date" placeholder="mm/dd/yyyy" v-model="modal.date" />
			        			</div>
			        		</div>

			      		</div>
				      	<div class="modal-footer">
				        	<button @click="hideModal" type="button" class="btn btn-default">Close</button>
				        	<button  @click="submitTransaction" type="button" class="btn btn-primary">Save changes</button>
				      	</div>
			      	</form>
		    	</div><!-- /.modal-content -->
		  	</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</transactions-table>