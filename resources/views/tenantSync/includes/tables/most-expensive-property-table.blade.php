<most-expensive-property-table user-role="{{ Auth::user()->role }}" inline-template>
		<div class="row card">
			<div class="col-sm-12">
				<h3 class="card-header m-t-0">Most Expensive</h3>

				<table-headers 
					:columns="columns" 
					:sort-key.sync="sortKey" 
					:reverse.sync="reverse"
				>
				</table-headers>

				<div class="table-body table-striped">
					<div v-if="$index < 3" v-for="property in properties | orderBy 'totalExpenses' -1" class="table-row row">
						<div class="col-sm-10"><a :href="'/'+ userRole +'/properties/' + property.id">@{{property.address + ', ' + property.city + ' ' + property.state}}</a></div>
						<div class="col-sm-2 text-danger">$@{{ property.totalExpenses }}</div>
						<!-- <div class="col-sm-2">$@{{ property.netIncome }}</div> --><!--$@{{ numeral(property.netIncome).format('0,0.00') }}-->
					</div>
				</div>

			</div>	
		</div>
	</most-expensive-property-table>