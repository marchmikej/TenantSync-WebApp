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

	window.dateString = 'YYYY-MM-DD';

	window.humanDateString = 'MMM, D';

	window.displayDateString = 'MMM D, YY';

</script>