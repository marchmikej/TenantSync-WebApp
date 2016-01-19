<property-manager-table user-role="{{ Auth::user()->role }}" inline-template>
		<div class="row card">
			<div class="col-sm-12">
				<h4 class="card-header">
					Properties
				</h4>
				<!-- <div class="row table-heading">
					<div class="col-sm-5">Address</div>
					<div class="col-sm-2">ROI</div>
					<div class="col-sm-2">Devices</div>
					<div class="col-sm-2">Value</div>
					<div class="col-sm-1"></div>
				</div> -->

				<table-headers :columns="columns" :sort-key.sync="sortKey" :reverse.sync="reverse"></table-headers>
			
				<div class="table-body table-striped">
							
					<div v-for="property in properties | orderBy sortKey reverse" class="table-row row">
						<div class="col-sm-7"><a :href="'/'+ userRole +'/properties/' + property.id">@{{property.address + ', ' + property.city + ' ' + property.state}}</a></div>
						<div class="col-sm-2 text-danger">@{{ property.alarms }}</div>
						<div class="col-sm-2 text-warning">@{{ property.inactives }}</div>
						<div @click="toggleDevices(property.id)" class="col-sm-1 btn btn-clear icon icon-plus p-a-0"></div>

						<div :data-property-id="property.id" class="sub-table" style="display: none;">
							<div class="table-heading row">
								<!-- <div class="col-sm-1 text-right">&nbsp;-</div> -->
								<div class="col-sm-3 col-sm-offset-1">Location</div>
								<div class="col-sm-2">Rent</div>
								<div class="col-sm-2">Contact Name</div>
								<div class="col-sm-2">Contact phone</div>
							</div>
							<div v-for="device in property.devices" class="table-row row">	
									<div class="col-sm-1 text-right"><span class="fa fa-long-arrow-right"></span></div>
									<div class="col-sm-3"><a :href="'/'+ userRole +'/device/' + device.id">@{{ device.location }}</a></div>
									<div class="col-sm-2">$@{{ device.rent_amount }}</div>
									<div class="col-sm-2">@{{ device.contact_name ? device.contact_name : '-' }}</div>
									<div class="col-sm-2">@{{ device.contact_phone ? device.contact_phone : '-' }}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</property-manager-table>