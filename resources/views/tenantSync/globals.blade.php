<script>

	window.TenantSync = {
		user: {!! Auth::user() ? Auth::user() : 'null' !!},
		landlord: {!! Auth::user()->role == 'manager' ? Auth::user()->manager->landlord->id : Auth::user()->id !!}
	};

	var math = {
		    '+': function(a, b) { return a + b },
		    '-': function(a, b) { return a - b },
		    '>': function(a, b) { return a > b },
		    '<': function(a, b) { return a < b },
		};

	var dateString = 'YYYY-MM-DD';

</script>