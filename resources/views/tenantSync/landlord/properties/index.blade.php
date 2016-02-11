@extends('TenantSync::landlord/layout')

@section('content')

<div id="portfolio">
	<ytd-stats inline-template>
		<div class="row card">
			<div class="col-sm-12">
		
				<h4 class="card-header">Overview</h4>
		
				<div class="col-sm-3 card-column">
					<p class="text-center">ROI YTD</p>
					<p class="stat text-primary text-center">
						@{{ stats.roi }}
					</p>
				</div>
		
				<div class="col-sm-3 card-column">
					<p class="text-center">Revenue YTD</p>
					<p class="stat text-success text-center">
						@{{ stats.paid_rent}}
					</p>
				</div>
		
				<div class="col-sm-3 card-column">
					<p class="text-center">Delinquency YTD</p>
					<p class="stat text-warning text-center">
						@{{ stats.deliquent_rent }}
					</p>
				</div>
		
				<div class="col-sm-3 card-column">
					<p class="text-center">Vacancy YTD</p>
					<p class="stat text-danger text-center">
						@{{ stats.vacant_rent }}
					</p>
				</div>
		
			</div>
		</div>
	</ytd-stats>

	@include('TenantSync::includes.tables.portfolio-table')

</div>



@endsection

@section('scripts')

	<script>

		var vue = new Vue({
			el: '#app'
		});
		
	</script>


@endsection