@extends('TenantSync::sales.layout')

@section('content')

<div id="property">
	<!-- <div class="row card">
		<div class="col-sm-12">
		<h4 class="card-header">Overview</h4>
			<div class="col-sm-3">
				<p class="text-center">Avg ROI</p>
				<p class="stat text-success text-center">-</p>
			</div>
			<div class="col-sm-3">
				<p class="text-center">Vacancies</p>
				<p class="stat text-primary text-center">-</p>
			</div>
			<div class="col-sm-3">
				<p class="text-center">Something here</p>
				<p class="stat text-danger text-center">-</p>
			</div>
			<div class="col-sm-3">
				<p class="text-center">Something Else</p>
				<p class="stat text-warning text-center">-</p>
			</div>
		</div>
	</div> -->
	
	<div class=" card row">
		<div class="col-sm-12">
			<h4 class="card-header">
				Property Info
				<button class=" btn btn-clear p-y-0"><a href="/sales/properties/{{ $property->id }}/devices/create"><h3 class="m-a-0 text-primary icon icon-plus"></h3></a></button>
			</h4>
			<form :action="'/' + user().role + '/properties/{{$property->id}}'" method="Post" class="form form-horizontal">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="_method" value="PATCH">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label col-sm-3" for="address">Address</label>
							<div class="col-sm-9">
								<input class="form-control" type="text" name="address" placeholder="Address" value="{{ $property->address }}"/>
							</div>
						</div>
					
						<div class="form-group">
							<label class="control-label col-sm-3" for="city">City</label>
							<div class="col-sm-9">
								<input class="form-control" type="text" name="city" placeholder="City" value="{{ $property->city }}"/>
							</div>
						</div>
					
						<div class="form-group">
					
							<label class="control-label col-sm-3" for="state">State</label>
							<div class="col-sm-4">
								<select class="form-control" name="state" id="state" >
									@foreach($states as $slug => $state)
										<option value="{{ $slug }}" {{ strtoupper($property->state) == $slug ? 'selected' : ''}}>{{ strtoupper($slug) }}</option>
									@endforeach
								</select>
							</div>
								
							<label class="control-label col-sm-1" for="zip">Zip</label>
							<div class="col-sm-4">
								<input class="form-control" type="text" name="zip" placeholder="Zip" value="{{ $property->zip }}"/>
							</div>
						</div>
					</div>
				
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label col-sm-3" for="purchase_price">Purchase Price</label>
							<div class="col-sm-9">
								<input class="form-control" type="text" name="purchase_price" placeholder="Purchase Price" value="{{ $property->purchase_price }}"/>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3" for="down_payment">Down Payment</label>
							<div class="col-sm-9">
								<input class="form-control" type="text" name="down_payment" placeholder="Down Payment" value="{{ $property->down_payment }}"/>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3" for="purchase_date">Purchase Date</label>
							<div class="col-sm-9">
								<input class="form-control" type="date" name="purchase_date" placeholder="Purchase Date" value="{{ $property->purchase_date }}"/>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3" for="closing_costs">Closing Costs</label>
							<div class="col-sm-9">
								<input class="form-control" type="text" name="closing_costs" placeholder="Closing Costs" value="{{ $property->closing_costs }}"/>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3" for="taxes">Taxes</label>
							<div class="col-sm-9">
								<input class="form-control" type="text" name="taxes" placeholder="Taxes" value="{{ $property->taxes }}"/>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3" for="expenses">Expenses</label>
							<div class="col-sm-9">
								<input class="form-control" type="text" name="expenses" placeholder="Expenses" value="{{ $property->expenses }}"/>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3" for="insurance">Insurance</label>
							<div class="col-sm-9">
								<input class="form-control" type="text" name="insurance" placeholder="Insurance" value="{{ $property->insurance }}"/>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3" for="mortgage_rate">Mortgage Rate</label>
							<div class="col-sm-9">
								<input class="form-control" type="text" name="mortgage_rate" placeholder="Mortgage Rate" value="{{ $property->mortgage_rate }}"/>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-sm-3" for="mortgage_term">Mortgage Term</label>
							<div class="col-sm-9">
								<input class="form-control" type="text" name="mortgage_term" placeholder="Number of months" value="{{ $property->mortgage_term }}"/>
							</div>
						</div>
					</div>
				</div>

				<button class="form-control col-sm-2 col-sm-offset-10 btn btn-primary">Save</button>
			</form>
		</div>
	</div>

	<div class="card row">
		<div class="col-sm-12">
			<table class="devices-table table">
				<thead>
					<th>Address</th>
					<th>Apt.</th>
					<th>Alarm</th>
					<th>Status</th>
						<th>Serial</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($property->devices as $device)
					<tr>
						<td><a href="/sales/device/{{ $device->id }}">{{ $device->property->address . ', ' .  $device->property->city . ' ' . $device->property->state }}</a></td>
						<td>{{ $device->location }}</td>
						<td class="{{ $device->alarm_id ? 'text-danger': 'text-success' }}">{{ $device->alarm_id ? 'Deliquent': 'Off' }}</td>
						<td>{{ $device->status }}</td>
						<td>{{ $device->serial }}</td>
						
						<td></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection

@section('scripts')

	<script>

		var vue = new Vue({

			el: '#app',


			data: {

				propertyId: '',

				devices: {
					
				},
			},


			ready: function() {
				//this.fetchDevices();
			},


			methods: {

				fetchDevices: function() {
					var data = {
						with: ['alarm']
					};

					var params = window.location.href.split('/');
					this.propertyId = params[5].split('?')[0];

					this.$http.get('/' + this.user().role + '/properties/' + this.propertyId + '/devices')
						.success( function(devices) {
							this.devices = devices;
						})
						.error( function() {
							console.log('Error fetching devices');
						});
				}
			},


			filters: {
				numeric: function(array, field, operator, value ) {
					return array.filter(function(item) {
						console.log(item);
						if (item.$value)
						{
							return math[operator](item.$value[field], value)  ? item : null;
						}
					});
				}
			}
		});

	</script>


@endsection