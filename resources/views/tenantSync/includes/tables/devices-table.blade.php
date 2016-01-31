<devices-table user-role="{{ Auth::user()->role }}" inline-template>
			<div class="row card">
				<div class="col-sm-12">
					<h4 class="card-header">Devices</h4>
					<table-headers :columns="columns" :sort-key.sync="sortKey" :reverse.sync="reverse"></table-headers>
			
					<div class="table-body table-striped">
						<div v-for="device in devices | orderBy sortKey reverse" class="table-row row">
							<div class="col-sm-6"><a :href="'/'+ userRole +'/device/' + device.id">@{{ device.address }}</a></div>
							<div class="col-sm-2">@{{ device.rent_amount }}</div>
							<div class="col-sm-2">@{{ device.status }}</div>
							<div class="col-sm-2" :class="device.alarm_id ? 'text-danger' : 'text-success'">@{{ device.alarm_id ? device.alarm.slug : 'Off' }}</div>
						</div>
					</div>
					<div class="col-sm-4 col-sm-offset-4 text-center">
						<button class="btn btn-clear text-primary"
							v-if="paginated.current_page > 1"
							@click="fetchPage(-1)" 
						>
							<span class="icon icon-chevron-left"></span>
						</button>
						<button class="btn btn-clear text-primary"
							v-if="paginated.last_page > paginated.current_page"
							@click="fetchPage(1)"
						>
							<span class="icon icon-chevron-right"></span>
						</button>
					</div>
				</div>
			</div>
		</devices-table>