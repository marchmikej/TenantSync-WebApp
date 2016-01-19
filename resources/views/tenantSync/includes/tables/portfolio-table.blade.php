<portfolio-table inline-template>
		<div class="row card">
			<div class="col-sm-12">
				<h4 class="card-header">
					Properties<!-- <button  class=" btn btn-clear text-primary"><h4 class="m-a-0 icon icon-plus"></h4></button> -->
				</h4>
				<!-- <div class="row table-heading">
					<div class="col-sm-5">Address</div>
					<div class="col-sm-2">ROI YTD</div>
					<div class="col-sm-2">Devices</div>
					<div class="col-sm-2">Value</div>
					<div class="col-sm-1"></div>
				</div> -->
				<table-headers :columns="columns" :sort-key.sync="sortKey" :reverse.sync="reverse"></table-headers>

				<div class="table-body table-striped">
				
						<div v-for="property in properties | orderBy sortKey reverse" class="table-row row">
							<div class="col-sm-5"><a href="/landlord/properties/@{{ property.id }}">@{{property.address + ', ' + property.city + ' ' + property.state}}</a></div>
							<div class="col-sm-2 text-success">@{{ numeral(property.roi).format('0.0 %') }}</div>
							<div class="col-sm-2 text-danger">@{{ property.devices.length }}</div>
							<div class="col-sm-2 text-primary">$@{{numeral(property.value).format('0,0.00')}}</div>
							<div @click="showDetails(property.id)" class="col-sm-1 btn btn-clear icon icon-plus p-y-0"></div>

							<div :data-property-id="property.id" class="sub-table bg-muted" style="display: none;">
								<div class="table-row p-t-md p-b-md">
									<div class="col-sm-6">
										<div class="col-sm-6 text-left">Z-estimate</div>
										<div class="col-sm-6 text-right">$@{{ property.value ? numeral(property.value).format('0,0.00') : '-'}}</div>
										<div class="col-sm-6 text-left">Purchase Price</div>
										<div class="col-sm-6 text-right">$@{{ property.purchase_price ? numeral(property.purchase_price).format('0,0.00') : '-'}}</div>
										<div class="col-sm-6 text-left">Closing Costs</div>
										<div class="col-sm-6 text-right">$@{{ property.closing_costs ? property.closing_costs : '-' }}</div>
										<div class="col-sm-6 text-left">Expenses</div>
										<div class="col-sm-6 text-right">$@{{ property.expenses.length > 0  ? property.totalExpenses : '-'}}</div>
										<div class="col-sm-6 text-left">Taxes</div>
										<div class="col-sm-6 text-right">$@{{ property.taxes ? property.taxes : '-' }}</div>
										<div class="col-sm-6 text-left">Insurance</div>
										<div class="col-sm-6 text-right">$@{{ property.insurance ? property.insurance : '-' }}</div>
									</div>
									<div class="col-sm-6">
										<div class="col-sm-6 text-left">Mortgage Rate</div>
										<div class="col-sm-6 text-right">@{{ property.rent_due ? property.rent_due : '-' }}</div>
										<div class="col-sm-6 text-left">Mortgagae Payment</div>
										<div class="col-sm-6 text-right">@{{ property.mortgage_payment ? property.mortgage_payment : '-' }}</div>
										<div class="col-sm-6 text-left">Purchase Date</div>
										<div class="col-sm-6 text-right">@{{ property.purchase_date ? property.purchase_date : '-' }}</div>
<!-- 										<div class="col-sm-6 text-left">Aquisition Cost</div>
										<div class="col-sm-6 text-right">@{{ +property.down_payment + +property.closing_costs }}</div>
										<div class="col-sm-6 text-left">Appreciation</div>
										<div class="col-sm-6 text-right">@{{ property.value - property.purchase_price }}</div>
										<div class="col-sm-6 text-left">Appreciation / Aquisition</div>
										<div class="col-sm-6 text-right">@{{ (property.value - property.purchase_price) /  (property.down_payment + property.closing_costs) }}</div> -->
									</div>
								</div>
							</div>
						</div>

				</div>
			</div>
		</div>
	</portfolio-table>