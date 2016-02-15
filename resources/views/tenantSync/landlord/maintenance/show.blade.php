@extends('TenantSync::landlord/layout')

@section('content')

	<div id="maintenance">
		<div class="row">
			<h4 class="m-t-0 text-primary"><a href="/landlord/maintenance/{{ $maintenanceRequest->id }}"> {{ $maintenanceRequest->device->property->address . ', ' . $maintenanceRequest->device->location }}</a></h4>
			<div class="col-sm-12 card">
				<div class="col-sm-6">
					<h3 class="text-info m-t-0">Request</h3>
					<p class="">{{ ucfirst($maintenanceRequest->request) }}</p>
				</div>
				<div class="col-sm-4 col-sm-offset-2">
					<p class="text-center">Status</p>
					<!-- <h3 class="text-primary text-center m-y-0">@{{ ucfirst(str_replace('_', ' ', $maintenanceRequest->status)) }}</h3> -->
					<h3 class="text-primary text-center m-y-0" v-text="forms.maintenanceRequest.status"></h3>
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
							<h4 class="text-warning text-center">{{ '$'.$maintenanceRequest->cost }}</h4>
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
					<form id="maintenanceForm" action="/landlord/maintenance/{{ $maintenanceRequest->id }}" method="POST" class="form">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="_method" value="PATCH">
				
						<div 
							class="form-group" 
							id="datetimepicker1" 
							:class="{'has-error': forms.maintenanceRequest.errors.has('appointment_date')}"
						>
							<input 
								v-model="forms.maintenanceRequest.appointment_date" 
								type="hidden" 
								name="appointment_date" 
								:value="forms.maintenanceRequest.appointment_date"
							>
							<span class="help-block" v-show="forms.maintenanceRequest.errors.has('appointment_date')">
							    <strong>@{{ forms.maintenanceRequest.errors.get('appointment_date') }}</strong>
							</span>
						</div>
				
						<ts-textarea inline-template
							:name="'response'"
							:input.sync="forms.maintenanceRequest.response"
							:display="'Additional response'"
							:form="forms.maintenanceRequest"
						> 
							<div class="form-group" :class="{'has-error': form.errors.has(name)}">
							    <label class="control-label">@{{ display }}</label>
						        <textarea v-model="input" class="form-control" rows="4"></textarea>
						        <span class="help-block" v-show="form.errors.has(name)">
						            <strong>@{{ form.errors.get(name) }}</strong>
						        </span>
							</div>
						</ts-textarea>

						<!-- <div class="form-group">
							<label for="response" class="control-label">Additional response</label>
							<textarea 
								v-model="forms.maintenanceRequest.response" 
								class="form-control" 
								name="response"  
								placeholder="Type your response here..." 
								cols="30" 
								rows="3"
							>
								{{ $maintenanceRequest->response }}
							</textarea>
						</div> -->
				
						<!-- <div class="form-group">
							<label for="cost" class="control-label">Cost</label>
							<input 
								v-model="forms.maintenanceRequest.cost" 
								class="form-control" 
								type="text"  
								name="cost" 
								placeholder="Cost $0.00"
							>
						</div> -->

						<ts-text inline-template
							:name="'cost'"
							:input.sync="forms.maintenanceRequest.cost"
							:display="'Cost'"
							:form="forms.maintenanceRequest"
						>
							<div class="form-group" :class="{'has-error': form.errors.has(name)}">
							    <label class="control-label">@{{ display }}</label>
						        <input type="text" class="form-control" v-model="input">
						        <span class="help-block" v-show="form.errors.has(name)">
						            <strong>@{{ form.errors.get(name) }}</strong>
						        </span>
							</div>
						</ts-text>
				
						<button @click.prevent="submitRequest" class="col-sm-3 btn btn-primary">Respond</button>
						<button @click.prevent="closeRequest" class="col-sm-3 btn btn-muted col-sm-offset-6">Close</button>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')

    <script>

        vue = new Vue({
        	el: '#app',

        	data: {
        		userRole: TenantSync.user.role,

        		forms: {
        			maintenanceRequest: new TSForm({
        				status: null,

        				cost: null,

        				appointment_date: null,

        				response: null,
        			})
        		}
        	},

        	ready: function() {
        		this.forms.maintenanceRequest.id = new URI(document.URL).segment(2);
        		this.fetchMaintenanceRequest();
        	},

        	methods: {
        		fetchMaintenanceRequest: function() {
        			this.$http.get('/'+ this.userRole +'/api/maintenance/'+ this.forms.maintenanceRequest.id)
	        			.success(function(maintenanceRequest) {
	        				this.forms.maintenanceRequest.id =  maintenanceRequest.id;

	        				this.forms.maintenanceRequest.response =  maintenanceRequest.response;

	        				this.forms.maintenanceRequest.cost =  maintenanceRequest.cost;

	        				this.forms.maintenanceRequest.status = this.toTitleCase(maintenanceRequest.status);

	        				this.forms.maintenanceRequest.appointment_date = maintenanceRequest.appointment_date;
	        			})
	        			.then(function () {
	        				this.loadDatepicker();
	        			});
        		},

        		submitRequest: function() {
        			this.forms.maintenanceRequest.appointment_date = $('#datetimepicker1>input').val()

        			TS.patch('/api/maintenance/'+ this.forms.maintenanceRequest.id, this.forms.maintenanceRequest)
	        			.then(function(result) {
	        				this.fetchMaintenanceRequest();

	        				swal(
	        					'Updated!',
	        						'You have updated this maintenance request.'
	        				);
	        			})
	        			.catch(function(errors) {
	        				swal(
	        					'Uh Oh!',
	        						'There was a problem with your input'
	        				);
	        			});
        		},

        		closeRequest: function() {

        			this.$http.patch('/landlord/maintenance/' + {{ $maintenanceRequest->id }} + '/close')
	        			.success(function(response) {
	        				this.fetchMaintenanceRequest();
	        				swal(
	        					'Closed!',
	        						'You have closed this maintenance request.'
	        				);
	        			})
	        			.error(function(response) {
	        				swal(
	        					'Uh Oh!',
	        						'There was an error. Please contact tech support.'
	        				);
	        			});
        		},

        		loadDatepicker: function() {
        			$(function () {
			            $('#datetimepicker1').datetimepicker({
			            	showClear: true,
			            	sideBySide: true,
			            	format: 'YYYY/MM/DD h:mm a',
			            	inline: true,
			            });
			            $("[data-action = 'togglePeriod']").removeClass('btn-primary');
			        });
        		},
        	},
        })
    </script>

@endsection
