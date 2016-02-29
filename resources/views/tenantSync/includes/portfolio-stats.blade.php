<portfolio-stats inline-template>
	<div>
		<div class="row card">
			<div class="col-sm-12">
		
				<h4 class="card-header">Overview</h4>
		
				<div class="col-sm-3 card-column">
					<p class="text-center">ROI YTD</p>
					<p class="stat text-primary text-center">
						@{{ stats.roi }}
					</p>
				</div>
		
				<div @click="toggleStat('paid_rent')" class="col-sm-3 card-column">
					<p class="text-center">Revenue YTD</p>
					<p class="stat clickable text-success text-center">
						@{{ stats.paid_rent}}
					</p>
				</div>
		
				<div @click="toggleStat('deliquent_rent')" class="col-sm-3 card-column">
					<p class="text-center">Delinquency YTD</p>
					<p class="stat clickable text-warning text-center">
						@{{ stats.deliquent_rent }}
					</p>
				</div>
		
				<div @click="toggleStat('vacant_rent')" class="col-sm-3 card-column">
					<p class="text-center">Vacancy YTD</p>
					<p class="stat clickable text-danger text-center">
						@{{ stats.vacant_rent }}
					</p>
				</div>
		
			</div>
		</div>
		
		
		<modal>
			<div slot="one">
				<div v-if="showStat.paid_rent">
					<div v-if="stats.paid_rent == 0">
						No results found.	
					</div>
		
					<div v-if="stats.paid_rent != 0" class="h-md col-sm-12 scrollable-y">
		
						<div class="table-heading row">
							<div class="col-sm-3">
								Amount
							</div>
		
							<div class="col-sm-6">
								Address
							</div>
		
							<div class="col-sm-3">
								Date
							</div>
						</div>
		
						<div class="table-body table-striped">
							<div v-for="transaction in paidRentTransactions()" class="table-row row">
								<div :class="transaction.amount > 0 ? 'text-success' : 'text-danger'" class="col-sm-3">
									@{{ transaction.amount }}
								</div>		
								<div class="col-sm-6">
									<a :href="'/'+ user().role +'/device/'+ transaction.payable_id">
										@{{ transaction.address }}
									</a>
								</div>		
								<div class="col-sm-3">
									@{{ transaction.date }}
								</div>		
							</div>
						</div>
					
					</div>
				</div>
				
				<div v-if="showStat.deliquent_rent">
					<div v-if="stats.deliquent_rent == 0">
						No results found.	
					</div>
		
					<div v-if="stats.deliquent_rent != 0" class="h-md col-sm-12 scrollable-y">
						<div class="table-heading row">
							<div class="col-sm-6">
								Address
							</div>
		
							<div class="col-sm-3 col-sm-offset-3">
								Balance Due
							</div>
						</div>
		
						<div class="table-body table-striped">
							<div v-for="device in deliquentDevices()" class="table-row row">
								<div class="col-sm-6">
									<a :href="'/'+ user().role +'/device/'+ device.id">
										@{{ device.address }}
									</a>
								</div>		
								<div class="col-sm-3 col-sm-offset-3 text-danger">
									@{{ device.balance_due }}
								</div>		
							</div>
						</div>
		
					</div>
				</div>
		
				<div v-if="showStat.vacant_rent">
					<div v-if="stats.vacant_rent == 0">
						No results found.	
					</div>
		
					<div v-if="stats.vacant_rent != 0" class="h-md col-sm-12 scrollable-y">
						<div class="table-heading row">
							<div class="col-sm-6">
								Address
							</div>
		
							<div class="col-sm-3 col-sm-offset-3">
								Amount
							</div>
						</div>
		
						<div class="table-body table-striped">
							<div v-for="bill in vacantRentBills()" class="table-row row">
								<div class="col-sm-6">
									<a :href="'/'+ user().role +'/device/'+ rentBill.device_id">
										@{{ bill.address }}
									</a>
								</div>		
								<div class="col-sm-3 col-sm-offset-3 text-danger">
									@{{ bill.bill_amount }}
								</div>		
							</div>
						</div>
		
					</div>
				</div>
			</div>
		</modal>
	</div>
</portfolio-stats>