<div>
	<div class="card row">
		<div class="col-sm-12">
			<div class="card-header">
				<h3>
					Transactions
					<button @click="generateModal()" class=" btn btn-clear text-primary p-y-0"><h3 class="m-a-0 icon icon-plus"></h3></button>
				</h3>
			
					<input type="text" class="col-sm-2 col-xs-12 pull-right form-control" placeholder="search..." v-model='search'>
					 
					<input type="date" class="col-sm-2 col-xs-12 pull-right form-control" v-model="dates.to">
					<span class="pull-right floated-label">
					 	To
					</span>
					
					<input @click="toggleInput()" id="test" type="date" class="col-sm-2 col-xs-12 pull-right form-control" v-model="dates.from">
					<span class="pull-right floated-label">
						From
					</span>
				
			</div>
			<table-headers :columns="columns" :sort-key.sync="sortKey" :reverse.sync="reverse"></table-headers>
	
			<div class="table-body table-striped">
				<div v-for="transaction in transactions | orderBy sortKey reverse | filterBy search | filterBy withinDates" class="table-row row">
					<div :class="transaction.amount > 0 ? 'text-success' : 'text-danger'" class="col-sm-2"><strong>@{{ money(transaction.amount) }}</strong></div>
					<div class="col-sm-2">@{{ transaction.address }}</div>
					<div class="col-sm-6">@{{ transaction.description }}</div>
					<div class="col-sm-1">@{{ (transaction.date.substring(5) + '/' + transaction.date.substring(2, 4)).replace('-', '/') }}</div>
					<div class="col-sm-1">
						<button 
							@click="generateModal( transaction.id )"
							class="btn btn-clear p-t-0 p-r-0"
						><span class="text-primary icon icon-edit"></span></button>
						<button 
							@click="confirm({method:'deleteTransaction', id: transaction.id})" 
							class="btn btn-clear p-t-0 p-r-0"
						><span class="text-danger icon icon-cross"></span></button>
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
	<modal id="transaction-modal">
		<div slot="one">
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
						<li v-if="user().role == 'landlord' && _.size(properties) > 1" @click.stop="setPayable(forms.transaction, 'user')"><strong>General</strong></li>
						<li @click.stop="setPayable(forms.transaction, 'property', property.id, property.address)" v-for="property in properties | filterBy forms.transaction.payable_search" class="col-sm-12">
							<strong>@{{ property.address }}</strong>
							<ul>
								<li @click.stop="setPayable(forms.transaction, 'device', device.id, property.address + ', ' + device.location)" v-for="device in property.devices" >
									@{{ device.location }}
								</li>
							</ul>
						</li>
					</ul>
				</div>
	
				<ts-checkbox
					:name="'recurring'"
					:display="'Recurring'"
					:form="forms.transaction"
					:input.sync="forms.transaction.recurring"
					:show="!forms.transaction.transaction"
				>
				</ts-checkbox>
	
				<ts-select
					:name="'schedule'"
					:display="'Every'"
					:form="forms.transaction"
					:input.sync="forms.transaction.schedule"
					:show="forms.transaction.recurring"
				>
					<select class="form-control" v-model="forms.transaction.schedule">
						<option value="day" default>Day</option>
						<option value="week">Week</option>
						<option value="month">Month</option>
					</select>
				</ts-select>
	
				<ts-select
					:name="'day'"
					:display="'Day (1 is Sunday)'"
					:form="forms.transaction"
					:input.sync="forms.transaction.day"
					:show="(forms.transaction.schedule && forms.transaction.schedule !== 'day' && forms.transaction.recurring)"
				>
					<select class="form-control" v-model="forms.transaction.day">
						<option default>Select one...</option>
						<option v-for="number in 7" :value="number + 1">@{{ number + 1 }}</option>
						<option v-for="number in 23" v-if="forms.transaction.schedule == 'month'" :value="number + 8">@{{ number + 8 }}</option>
					</select>
				</ts-select>
	
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
	
	<modal id="recurring-modal">
		<div slot="one">
			<form role="form" class="form form-horizontal">
				<div class="form-group">
					<label class="control-label col-sm-3" for="payable">Apply To</label>
					<div class="col-sm-9">
						<input v-model="forms.recurringTransaction.payable_selected" class="form-control col-sm-8" type="text" style="border: none;" readonly/>
						<input v-model="forms.recurringTransaction.payable_search" class="form-control col-sm-4" type="text" name="payable" placeholder="Search..."/>
					</div>
				</div>
			
				<div class="well col-sm-9 col-sm-offset-3" style="max-height: 150px; overflow-y: scroll;">
					<ul class="list-select">
						<li v-if="userRole == 'landlord'" @click.stop="setPayable(forms.recurringTransaction, 'user')"><strong>General</strong></li>
						<li @click.stop="setPayable(forms.recurringTransaction, 'property', property.id, property.address)" v-for="property in properties | filterBy forms.recurringTransaction.payable_search" class="col-sm-12">
							<strong>@{{ property.address }}</strong>
							<ul>
								<li @click.stop="setPayable(forms.recurringTransaction, 'device', device.id, property.address + ', ' + device.location)" v-for="device in property.devices" >
									@{{ device.location }}
								</li>
							</ul>
						</li>
					</ul>
				</div>
	
				<ts-select
					:name="'schedule'"
					:display="'Every'"
					:form="forms.recurringTransaction"
					:input.sync="forms.recurringTransaction.schedule"
				>
					<select class="form-control" v-model="forms.recurringTransaction.schedule">
						<option value="day" default>Day</option>
						<option value="week">Week</option>
						<option value="month">Month</option>
					</select>
				</ts-select>
	
				<ts-select
					:name="'day'"
					:display="'Day (1 is Sunday)'"
					:form="forms.recurringTransaction"
					:input.sync="forms.recurringTransaction.day"
					:show="(forms.recurringTransaction.schedule && forms.recurringTransaction.schedule !== 'day')"
				>
					<select class="form-control" v-model="forms.recurringTransaction.day">
						<option default>Select one...</option>
						<option v-for="number in 7" :value="number + 1">@{{ number + 1 }}</option>
						<option v-for="number in 21" v-if="forms.recurringTransaction.schedule == 'month'" :value="number + 8">@{{ number + 8 }}</option>
					</select>
				</ts-select>
	
				<ts-text
					:name="'amount'"
					:display="'Amount'"
					:form="forms.recurringTransaction"
					:input.sync="forms.recurringTransaction.amount"
				>
				</ts-text>
	
				<ts-text
					:name="'description'"
					:display="'Description'"
					:form="forms.recurringTransaction"
					:input.sync="forms.recurringTransaction.description"
				>
				</ts-text>
	
				<ts-date
					:name="'last_ran'"
					:display="'Start Date'"
					:form="forms.recurringTransaction"
					:input.sync="forms.recurringTransaction.last_ran"
				>
				</ts-date>
	
				<button 
					@click.prevent="submitRecurringTransaction()" 
					class="btn btn-primary form-control col-md-3 col-md-offset-9"
				>
					Submit
				</button>
	
			</form>
		</div>
	</modal><!-- /.modal -->
</div>


