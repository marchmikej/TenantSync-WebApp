@extends('TenantSync::manager/layout')

@section('content')

	@foreach($messages as $message)
	<div class="row">

		{{ $message->message->body }} <br>
		{{ $message->type->name }} <br>
		@if( !empty($message->parent_id) )
			{{ $message->parent->message->body }}
		@endif
		
	</div> <br>
	@endforeach

@endsection