<recent-maintenance inline-template>
	<div class="col-sm-6 p-r-md">
		<div class="card row">
			<div class="col-sm-12">
				<h3 class="card-header">
					Recent Maintenance

					<button @click="previousPage" :class="currentPage > 1 ? 'text-primary' : 'text-muted'" class="btn-clear btn icon icon-chevron-left"></button>

					<button @click="nextPage" :class="lastPage == currentPage ? 'text-muted' : 'text-primary'"class="btn-clear btn icon icon-chevron-right"></button>
				</h3>
				<div class="row table-heading">
					<div class="col-sm-4">Unit</div>
					<div class="col-sm-6">Request</div>
					<div class="col-sm-2">Date</div>
				</div>
				<div class="table-body table-striped scrollable row">
					<div 
						v-if="isInCurrentPage($index)" 
						v-for="maintenance in maintenanceRequests | orderBy 'created_at' -1" 
						class="table-row col-sm-12"
					>
						<div class="col-sm-4">
							<a 
								:class="{'text-muted': maintenance.status == 'closed'}"
								:href="'/' + user().role + '/device/' + maintenance.device.id"
							>
								@{{ maintenance.address }}
							</a>
						</div>
						<div class="col-sm-6">
							<a 
								:class="[maintenance.status == 'closed' ? 'text-muted' : 'text-info']"
								:href="'/'+ user().role +'/maintenance/'+ maintenance.id"
							>
								@{{ maintenance.request }}
							</a>
						</div>
						<div
							class="col-sm-2"
							:class="{'text-muted': maintenance.status == 'closed'}"
						>
							@{{ humanDate(maintenance.created_at) }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</recent-maintenance>