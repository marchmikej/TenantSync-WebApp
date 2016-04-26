<property-manager-table user-role="{{ Auth::user()->role }}" inline-template>
	<div class="row card">
		<div class="col-sm-12">
			<h4 class="card-header">
				Properties 
				@if(\Auth::user()->role == 'landlord')
					<button v-if="user().role == 'landlord'" class=" btn btn-clear p-y-0"><a href="/landlord/properties/create"><h3 class="m-a-0 text-primary icon icon-plus"></h3></a></button>
				@endif
				@include('TenantSync::includes.tables.search')
			</h4>

			<table-headers :columns="columns" :sort-key.sync="sortKey" :reverse.sync="reverse"></table-headers>
		
			<div class="table-body table-striped">
						
				<div 
					v-for="property in filteredList 
					| orderBy sortKey reverse 
					| filterBy search"
					v-if="inCurrentPage($index)" 
					class="table-row row"
				>
					<div class="col-sm-7"><a :href="'/'+ user().role +'/properties/' + property.id">@{{property.address + ', ' + property.city + ' ' + property.state}}</a></div>
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
							<div class="col-sm-1">Alarm</div>
						</div>
						<div v-for="device in property.devices" class="table-row row">	
								<div class="col-sm-3 col-sm-offset-1"><a :href="'/'+ user().role +'/device/' + device.id">@{{ device.location }}</a></div>
								<div class="col-sm-2">$@{{ device.rent_amount }}</div>
								<div class="col-sm-2">@{{ device.contact_name ? device.contact_name : '-' }}</div>
								<div class="col-sm-2">@{{ device.contact_phone ? device.contact_phone : '-' }}</div>
								<div class="col-sm-1" :class="device.alarm_id ? 'text-danger' : 'text-success'">@{{ device.alarm_id ? device.alarm.slug : 'Off' }}</div>
						</div>
					</div>
				</div>
			</div>

			@include('TenantSync::includes.tables.pagination')

		</div>
	</div>
</property-manager-table>