@extends('TenantSync::manager/layout')

@section('content')

	<div id="maintenance">
		<div class="row">
			<h4 class="m-t-0 text-primary">{{ $maintenanceRequest->device->property->address . ', ' . $maintenanceRequest->device->location }}</h4>
			<div class="col-sm-12 card">
				<div class="col-sm-6">
					<h3 class="text-info m-t-0">Request</h3>
					<p class="">{{ ucfirst($maintenanceRequest->request) }}</p>
				</div>
				<div class="col-sm-4 col-sm-offset-2">
					<p class="text-center">Status</p>
					<h3 class="text-primary text-center m-y-0">{{ ucfirst(str_replace('_', ' ', $maintenanceRequest->status)) }}</h3>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12 card">
		
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-3">
							<p class="text-center m-t-0">Days Open</p>
							<h4 class="text-danger text-center m-t-0 m-b-0">{{ $maintenanceRequest->daysOpen() }}</h4>
						</div>
						<div class="col-sm-3">
							<p class="text-center p-x-0">Cost</p>
							<h4 class="text-warning text-center">${{count($maintenanceRequest->transaction) ? $maintenanceRequest->transaction->amount : ''}}</h4>
						</div>
						
						<div class="col-sm-3">
							<p class="text-center p-x-0">Appointment</p>
							<h4 class="text-success text-center">{{ date('M j, Y', strtotime($maintenanceRequest->appointment_date)) }}</h4>
						</div>
						
						<!-- <div class="col-sm-2">
							<p class="text-center p-x-0">Attempts</p>
							<h4 class="text-primary text-center">3</h4>
						</div> -->
						
						<div class="col-sm-3">
							<p class="text-center p-x-0">Submitted</p>
							<h4 class="text-muted text-center">{{ date('M j, Y', strtotime($maintenanceRequest->created_at)) }}</h4>
						</div>
					</div>
				
					<hr>
		
				</div>
		
				<div class="col-sm-12">
					<h3 class="text-info m-t-0 p-b">Appointment Date</h3>
					<form id="maintenanceForm" action="/manager/maintenance/{{ $maintenanceRequest->id }}" method="POST" class="form">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="_method" value="PATCH">
				
						<div class="text-gray form-group" id="datetimepicker1">
							<input type="hidden" name="appointment_date" value="{{ $maintenanceRequest->appointment_date }}" v-model="appointmentDate">
						</div>
				
						<div class="form-group">
							<label for="response" class="control-label">Additional response</label>
							<textarea class="form-control" name="response"  placeholder="Type your response here..." cols="30" rows="3">{{ $maintenanceRequest->response }}</textarea>
						</div>
				
						<div class="form-group">
							<label for="cost" class="control-label">Cost</label>
							<input class="form-control" type="text" value="${{ count($maintenanceRequest->transaction) ? $maintenanceRequest->transaction->amount : '' }}" name="cost" placeholder="Cost $0.00">
						</div>
				
				
						<!--  <div class="form-group">
							<label for="status" class="control-label">Status</label>
							<select name="status" class="form-control" >
								<option disabled selected>-- Status --</option>
								<option value="open">Open</option>
								<option value="pending">Pending</option>
								<option value="closed">Closed</option>
							</select>
						</div> -->
				
				
						<button class="col-sm-3 btn btn-primary">Respond</button>
						<button @click.prevent="closeRequest" class="col-sm-3 btn btn-muted col-sm-offset-6">Close</button>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')

	<script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({
            	showClear: true,
            	sideBySide: true,
            	format: 'YYYY/MM/DD h:mm a',
            	inline: true,
            });
            $("[data-action = 'togglePeriod']").removeClass('btn-primary');
        });
    </script>

    <script>
        vue = new Vue({
        	el: '#app',

        	data: {
        		appointmentDate: '',
        	},

        	methods: {
        		closeRequest: function() {

        			this.$http.patch('/manager/maintenance/' + {{ $maintenanceRequest->id }} + '/close')
        			.success(function(response) {
        				window.location = "http://tenantsync.app/manager/maintenance/" + {{ $maintenanceRequest->id }};
        			});
        		}
        	},
        })
    </script>

@endsection
