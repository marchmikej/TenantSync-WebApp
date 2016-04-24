<accounting-stats inline-template>
	<div class="card row">
		<div id="stats" class="col-sm-12">
			<h4 class="card-header">Overview</h4>
			<div class="col-sm-3 card-column">
				<p class="text-center">Net Income MTD</p>
				<p class="stat text-success text-center">
				@{{ money(stats.net_income) }}
				</p>
			</div>
			<div @click="toggleStat('recurring')" class="col-sm-3 card-column">
				<p class="text-center">Monthly Recurring Expenses</p>
				<p class="stat clickable text-primary text-center">
				@{{ money(stats.recurring) }}
				</p>
			</div>
			<div @click="toggleStat('expenses')" class="col-sm-3 card-column">
				<p class="text-center">Total Expenses MTD</p>
				<p class="stat clickable text-danger text-center">
				@{{ money(stats.expenses) }}
				</p>
			</div>
			<div @click="toggleStat('revenue')" class="col-sm-3 card-column">
				<p class="text-center">Revenue  MTD</p>
				<p class="stat clickable text-warning text-center">
				@{{ money(stats.revenue) }}
				</p>
			</div>
		</div>
	</div>
	
	<modal id="stat-modal">
		<div class="modal-wrapper">
			<div v-if="showStat.recurring">
				<div v-if="stats.recurring == 0">
					No results found.	
				</div>
			
				<div v-if="stats.recurring != 0" class="h-md col-sm-12 scrollable">
			
					<div class="table-heading row">
						<div class="col-sm-2">
							Amount
						</div>
			
						<div class="col-sm-5">
							Address
						</div>
			
						<div class="col-sm-3">
							Schedule
						</div>
					</div>
			
					<div class="table-body table-striped">
						<div v-for="transaction in recurringTransactions" class="table-row row">
							<div :class="transaction.amount > 0 ? 'text-success' : 'text-danger'" class="col-sm-2">
								@{{ money(transaction.amount) }}
							</div>		
							<div class="col-sm-5">
								<!-- <a :href="'/'+ user().role +'/'device'/'+ transaction.payable_id"> -->
									@{{ transaction.address }}
								<!-- </a> -->
							</div>		
							<div class="col-sm-3">
								@{{ 'Every '+ transaction.schedule }}
							</div>
							<div class="col-sm-2">
								<button @click="generateRecurringModal(transaction.id)" class="btn btn-clear p-a-0">
									<span class="text-primary icon icon-edit"></span>
								</button>
								<button @click="deleteRecurringTransaction(transaction.id)" class="btn btn-clear p-y-0 p-r-0">
									<span class="text-danger icon icon-cross"></span>
								</button>
							</div>
							</div>	
						</div>
					</div>
				
				</div>
			</div>
			
			<div v-if="showStat.expenses">
				<div v-if="stats.expenses == 0">
					No results found.	
				</div>
			
				<div v-if="stats.expenses != 0" class="h-md col-sm-12 scrollable">
					<div class="table-heading row">
						<div class="col-sm-6">
							Address
						</div>
			
						<div class="col-sm-3 col-sm-offset-3">
							Amount
						</div>
					</div>
			
					<div class="table-body table-striped">
						<div v-for="transaction in expenseTransactions()" class="table-row row">
							<div class="col-sm-6">
								<!-- <a :href="'/'+ user().role +'/device/'+ device.id"> -->
									@{{ transaction.address }}
								<!-- </a> -->
							</div>		
							<div class="col-sm-3 col-sm-offset-3 text-danger">
								@{{ money(transaction.amount) }}
							</div>		
						</div>
					</div>
			
				</div>
			</div>
			
			<div v-if="showStat.revenue">
				<div v-if="stats.revenue == 0">
					No results found.	
				</div>
			
				<div v-if="stats.revenue != 0" class="h-md col-sm-12 scrollable">
					<div class="table-heading row">
						<div class="col-sm-6">
							Address
						</div>
			
						<div class="col-sm-3 col-sm-offset-3">
							Amount
						</div>
					</div>
			
					<div class="table-body table-striped">
						<div v-for="transaction in revenueTransactions()" class="table-row row">
							<div class="col-sm-6">
								<!-- <a :href="'/'+ user().role +'/device/'+ rentBill.device_id"> -->
									@{{ transaction.address }}
								<!-- </a> -->
							</div>		
							<div :class="transaction.amount > 0 ? 'text-success' : 'text-danger'" class="col-sm-3 col-sm-offset-3">
								@{{ money(transaction.amount) }}
							</div>		
						</div>
					</div>
				</div>
			</div>
		</div>
	</modal>
</accounting-stats>