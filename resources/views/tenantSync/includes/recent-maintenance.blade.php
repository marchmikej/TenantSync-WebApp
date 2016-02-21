<recent-maintenance inline-template>
	<div class="col-sm-6 p-r-md">
		<div class="card row">
			<div class="col-sm-12">
				<h3 class="card-header">
					Recent Maintenance
				</h3>
				<div class="row table-heading">
					<div class="col-sm-4">Unit</div>
					<div class="col-sm-8">Request</div>
				</div>
				<div class="table-body table-striped scrollable row">
					<div v-for="maintenance in maintenanceRequests | orderBy 'created_at' -1" class="table-row col-sm-12">
						<div class="col-sm-4">
							@{{ maintenance.device.property.address + ', ' + maintenance.device.location }}
						</div>
						<div class="col-sm-8">
							<a :href="'/'+ user().role +'/maintenance/'+ maintenance.id">
								@{{ maintenance.request }}
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</recent-maintenance>