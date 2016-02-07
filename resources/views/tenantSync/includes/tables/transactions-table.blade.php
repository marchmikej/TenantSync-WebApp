<transactions-table  user-role="{{ Auth::user()->role }}" inline-template>
		<div class="card row">
			<div class="col-sm-12">
				<h3 class="card-header">
					<div>
						Transactions
						<button @click="generateModal()" class=" btn btn-clear text-primary p-y-0"><h3 class="m-a-0 icon icon-plus"></h3></button>
						<input type="text" class="col-sm-2 col-xs-12 pull-right form-control" placeholder="search..." v-model='search'>
						<input @change="fetchTransactions()" type="date" class="col-sm-2 col-xs-12 pull-right form-control" v-model="dates.from">
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
							<button @click=" generateModal( transaction.id )" class="btn btn-clear p-a-0"><span class="text-primary icon icon-edit"></span></button>
							<button @click=" confirm('delete', 'Transaction', transaction.id )" class="btn btn-clear p-y-0 p-r-0"><span class="text-danger icon icon-cross"></span></button>
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
		<modal>
			<div slot="one" class="">
				<form role="form" class="form form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-3" for="payable">Apply To</label>
						<div class="col-sm-9">
							<input v-model="forms.transaction.payable_selected" class="form-control col-sm-8" type="text" style="border: none;" readonly/>
							<input v-model="forms.transaction.payable_search" class="form-control col-sm-4" type="text" name="payable" placeholder="Search..."/>
						</div>
					</div>
				
					<div class="well col-sm-9 col-sm-offset-3" style="max-height: 150px; overflow-y: scroll;">
						<ul class="list-select">
							<li v-if="userRole == 'landlord'" @click.stop="setPayable('user')"><strong>General</strong></li>
							<li @click.stop="setPayable('property', property.id, property.address)" v-for="(key, property) in properties | search forms.transaction.payable_search" class="col-sm-12">
								<strong>@{{ property.address }}</strong>
								<ul>
									<li @click.stop="setPayable('device', device.id, property.address + ', ' + device.location)" v-for="device in property.devices" >
										@{{ device.location }}
									</li>
								</ul>
							</li>
						</ul>
					</div>

					<!-- <ts-checkbox
						:name="'is_rent'"
						:display="'Rent Payment'"
						:form="forms.transaction"
						:input.sync="forms.transaction.is_rent"
						:show="forms.transaction.payable_type == 'device'"
					> -->
					</ts-checkbox>

					<ts-text
						:name="'amount'"
						:display="'Amount'"
						:form="forms.transaction"
						:input.sync="forms.transaction.amount"
					>
					</ts-text>

					<ts-text
						:name="'description'"
						:display="'Description'"
						:form="forms.transaction"
						:input.sync="forms.transaction.description"
					>
					</ts-text>

					<ts-date
						:name="'date'"
						:display="'Date'"
						:form="forms.transaction"
						:input.sync="forms.transaction.date"
					>
					</ts-date>

					<button @click.prevent="submitTransaction" class="btn btn-primary form-control col-md-3 col-md-offset-9">Submit</button>
				</form>
			</div>
		</modal><!-- /.modal -->
	</transactions-table>


