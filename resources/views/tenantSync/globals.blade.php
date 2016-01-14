<script>

	window.TenantSync = {
		user: {!! Auth::user() ? Auth::user() : 'null' !!},
		landlord: {!! Auth::user()->role == 'manager' ? Auth::user()->manager->landlord->id : Auth::user()->id !!}
	};

</script>