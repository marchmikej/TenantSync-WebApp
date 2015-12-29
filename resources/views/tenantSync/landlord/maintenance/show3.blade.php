@extends('TenantSync::landlord/layout')

@section('content')

	<div class="row">
		<div class="col-sm-12">
			<h4 class=" m-t-0">5042 Parker rd Hamburg, NY 14075</h4>
		</div>
		<div class="col-sm-12 card">
			<div class="col-sm-3">
				<div class="row">
					<h5 class=" text-center m-t-0">Days Open</h5>
				</div>
				<div class="row">
					<h2 class="text-danger text-center m-t-0 m-b-0">10</h2>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="row">
					<h5 class=" text-center m-t-0">Cost</h5>
				</div>
				<div class="row">
					<h2 class="text-warning text-center m-t-0 m-b-0">50.00</h2>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="row">
					<h5 class=" text-center m-t-0">Appointment</h5>
				</div>
				<div class="row">
					<h2 class="text-success text-center m-t-0 m-b-0">1/23/2015</h2>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="row">
					<h5 class=" text-center m-t-0">Status</h5>
				</div>
				<div class="row">
					<h2 class="text-primary text-center m-t-0 m-b-0">Open</h2>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
	<!-- 	<div class="col-sm-12">
			<h4 class="text-muted m-t-0">5042 Parker rd Hamburg, NY 14075</h4>
		</div> -->
		<div class="col-sm-12 card">
			<div class="col-sm-3">
				<!-- @if( $maintenanceRequest->status !== 'closed')
					<div class="row">
						<h4 class="col-sm-5 m-y-0 p-x-0">Days Open:</h4>
						<h4 class="text-danger m-y-0">{{ $maintenanceRequest->daysOpen() }}</h4>
					</div>

					<hr>

				@endif
				<div class="row">
					<h4 class="col-sm-5 m-y-0 p-x-0">Cost:</h4>
					<h4 class="text-warning m-y-0">{{ $maintenanceRequest->cost }}</h4>
				</div>

				<hr>

				<div class="row">
					<h4 class="col-sm-5 m-y-0 p-x-0">Appointment:</h4>
					<h4 class="text-success m-y-0">{{ date('M j, Y', strtotime($maintenanceRequest->appointment_date)) }}</h4>
				</div>

				<hr>
 -->
				<div class="row">
					<h4 class="col-sm-5 m-y-0 p-x-0">Attempts:</h4>
					<h4 class=" m-y-0">3</h4>
				</div>

				<hr>

				<!-- <div class="row">
					<h4 class="col-sm-5 m-y-0 p-x-0">Submitted:</h4>
					<h4 class="text-muted m-y-0">{{ date('M j, Y', strtotime($maintenanceRequest->created_at)) }}</h4>
				</div> -->

			</div>
			
			<div class="col-sm-9 b-l">
				<h3 class="text-info m-t-0">Problem</h3 >
				<p class="">{{ $maintenanceRequest->request }}</p>
			
				<hr>
			
				<h3 class="text-info">Appointment Date</h3>
				<form action="/landlord/maintenance/{{ $maintenanceRequest->id }}/edit" method="POST" class="form">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
			
					<div class="form-group" id="datetimepicker1">
						<input type="hidden" name="appointment_date" value="{{ $maintenanceRequest->appointment_date }}">
					</div>
			
					<div class="form-group">
						<label for="response" class="control-label">Additional response</label>
						<textarea class="form-control" name="response"  placeholder="Type your response here..." cols="30" rows="3">{{ $maintenanceRequest->response }}</textarea>
					</div>
			
					<div class="form-group">
						<label for="cost" class="control-label">Cost</label>
						<input class="form-control" type="text" value="{{ $maintenanceRequest->cost() }}" name="cost" placeholder="Cost $0.00">
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
					<button class="col-sm-3 btn btn-primary col-sm-offset-9">Close</button>
				</form>
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
        });
    </script>

@endsection
