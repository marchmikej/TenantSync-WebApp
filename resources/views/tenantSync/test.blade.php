@extends('TenantSync::bare')

@section('content')

	<table id="test-table" class="table table-striped display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td></td>
                <td>Name</td>
                <td>Position</td>
                <td>Office</td>
                <td>Salary</td>
            </tr>
        </tfoot>
    </table>

@endsection

@section('scripts')

	<link rel="stylesheet" type="text/css" href="vendor/datatables/datatables.min.css"/>
	<script type="text/javascript" src="vendor/datatables/datatables.min.js"></script>

	<script>
		/* Formatting function for row details - modify as you need */
		function format ( d ) {
		    // `d` is the original data object for the row
		    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
		        '<tr>'+
		            '<td>Full name:</td>'+
		            '<td>'+d.name+'</td>'+
		        '</tr>'+
		        '<tr>'+
		            '<td>Extension number:</td>'+
		            '<td>'+d.extn+'</td>'+
		        '</tr>'+
		        '<tr>'+
		            '<td>Extra info:</td>'+
		            '<td>And any further details here (images etc)...</td>'+
		        '</tr>'+
		    '</table>';
		}
		 
		$(document).ready(function() {
		    var table = $('#test-table').DataTable( {
		    	"processing": true,
        		//"serverSide": true, // Gets rid of pagination because you would be paginating server side.
		        "ajax": "objects.txt",
		        "columns": [
		            {
		                "className":      'details-control icon icon-plus text-primary',
		                "orderable":      false,
		                "data":           null,
		                "defaultContent": ''
		            },
		            { "data": "name" },
		            { "data": "position" },
		            { "data": "office" },
		            { "data": "salary" }
		        ],
		        "order": [[1, 'asc']]
		    } );
		     
		    // Add event listener for opening and closing details
		    $('#test-table tbody').on('click', 'td.details-control', function () {
		        var tr = $(this).closest('tr');
		        var row = table.row( tr );
		 
		        if ( row.child.isShown() ) {
		            // This row is already open - close it
		            row.child.hide();
		            tr.removeClass('shown');
		        }
		        else {
		            // Open this row
		            row.child( format(row.data()) ).show();
		            tr.addClass('shown');
		        }
		    } );
		} );
	</script>

@endsection