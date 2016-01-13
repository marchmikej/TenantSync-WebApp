<script>

	window.TenantSync = {
		user: {!! Auth::user() ? Auth::user() : 'null' !!},
		landlord: function() {
			if({!! Auth::user() ? true : 'null' !!}) {
				return {!! Auth::user()->role == 'landlord' ? Auth::user() : Auth::user()->manager->landlord !!};
			};
		}
	};

</script>