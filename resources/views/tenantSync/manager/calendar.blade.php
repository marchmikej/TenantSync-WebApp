@extends('TenantSync::manager/layout')
@section('head')
	<link rel="stylesheet" href="/css/fullcalendar.min.css">
@endsection

@section('content')

	<div class="row">
		<div class="card col-sm-12 p-b " id="container">
			<div id="calendar">
				
			</div>
			<!-- <pre>@{{ $data | json }}</pre> -->
		</div>
	</div>

@endsection

@section('scripts')
<script>
	var container = new Vue({

		el: '#app',

		data: {
			events:[
			]
		},

		ready: function(){
			this.$http.get('/' + this.user().role + '/calendar/all')
			.success(function(events){
				console.log(events);
				for (var i = events.length - 1; i >= 0; i--) {
					if(events[i].appointment_date){
						var event = {start: events[i].appointment_date.replace(' ', 'T').substring(0, events[i].appointment_date.length-3), title: events[i].request, maintenance_id: events[i].id};
						this.events.push(event);
					}
					continue;
				};

				var self = this;
				$('#calendar').fullCalendar({
			        // put your options and callbacks here
			        eventClick: function(maintenance, jsEvent, view) {
			        	window.location = '/' + self.user().role + '/maintenance/' + maintenance.maintenance_id;
			        },

			       	events: this.events,

			       	startParam: 'appointment_date',
			    });

			});
		}
	});


</script>

@endsection