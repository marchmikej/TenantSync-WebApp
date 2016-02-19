@extends('TenantSync::landlord/layout')

@section('content')

<div id="portfolio" v-cloak>

	@include('TenantSync::includes.portfolio-stats')

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