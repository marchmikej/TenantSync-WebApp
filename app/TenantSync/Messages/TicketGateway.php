<?php namespace TenantSync\Messages;


class TicketGateway {

	public function __construct(Ticket $ticket)
	{
		$this->ticket = $ticket;
	}

	public function processResponse($input)
	{
		//create message
		Message::create(['body' => $input['response']]);
		//create user message
		UserMessage::create([
			'user_id' => \Auth::user()->id,
			'message_id' => $message_id,
			'type' => 'ticket_response',
			'status' => $input['status']
		]);
		// populate ticket table
		return Ticket::create();
		//return ticket
		

	}
}