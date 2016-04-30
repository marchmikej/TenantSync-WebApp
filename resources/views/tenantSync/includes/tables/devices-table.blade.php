<div class="row card">
	<div class="col-sm-12">

		<h4 class="card-header">
			Devices
			<button @click="previousPage" :class="currentPage > 1 ? 'text-primary' : 'text-muted'" class="btn-clear btn icon icon-chevron-left"></button>

			<button @click="nextPage" :class="lastPage == currentPage ? 'text-muted' : 'text-primary'"class="btn-clear btn icon icon-chevron-right"></button>
			
			@include('TenantSync::includes.tables.search')
		</h4>

		<table-headers :columns="columns" :sort-key.sync="sortKey" :reverse.sync="reverse"></table-headers>

		<div class="table-body table-striped">
			<div 
				v-for="device in filteredList | orderBy sortKey reverse | filterBy search" 
				v-if="inCurrentPage($index)"
				class="table-row row"
			>
				<div class="col-sm-6"><a :href="'/'+ user().role +'/device/' + device.id">@{{ device.address }}</a></div>
				<div class="col-sm-2">@{{ money(device.rent_owed) }}</div>
				<div class="col-sm-2">@{{ toTitleCase(device.status) }}</div>
				<div class="col-sm-2" :class="device.alarm_id ? 'text-danger' : 'text-success'">@{{ device.alarm_id ? device.alarm.slug : 'Off' }}</div>
			</div>
		</div>
	</div>
</div>
