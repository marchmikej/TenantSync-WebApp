@extends('TenantSync::sales/layout')

@section('content')

	<div class="row card">
		<div class="col-sm-12">
			<h1 class="m-t-0">
				Landlords<a href="/sales/landlord/create"><button class=" btn btn-clear text-muted p-y-0"><h3 class="m-a-0 icon icon-plus"></h3></button></a>
			</h1>
				
			<table id="landlord-table" class="table">
				<thead>
					<!-- <th><input type="checkbox" name="landlords[]"></th> -->
					<th>Name</th>
					<th>Address</th>
					<th>Email</th>
					<th>Phone</th>
				</thead>
				<tbody>
					@foreach($landlords as $landlord)
					<tr>
						<!-- <td><input type="checkbox" name="landlords[]"></td> -->
						<td><a href="/sales/landlord/{{$landlord->id}}">{{ $landlord->profile->first_name.' '.$landlord->profile->last_name }}</a></td>
						<td>{{ $landlord->profile->address }}</td>
						<td>{{ $landlord->email }}</td>
						<td>{{ $landlord->profile->phone }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		
	</div>

@endsection
