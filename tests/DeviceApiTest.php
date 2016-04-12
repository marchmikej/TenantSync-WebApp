<?php

use TenantSync\Models\User;
use TenantSync\Models\Device;
use TenantSync\Models\Gateway;
use TenantSync\Models\Message;
use TenantSync\Models\MaintenanceRequest;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeviceApiTest extends TestCase
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 *  It should return a json response with device info
	 *
	 * @return void
	 * @test 
	 **/
	public function it_gets_a_device()
	{
		$this->device = factory(Device::class)->create();

		$this->call('GET', '/device-api/device', [
			'serial' => $this->device->serial, 
			'token' => $this->device->token
		]);

		$this->assertResponseOk();
	}

	/**
	 *  It should get the maintenance requests for device
	 *
	 * @return void
	 * @test 
	 **/
	public function it_gets_maintenance_requests_for_device()
	{
		$this->device = factory(Device::class)->create();

		$maintenanceRequests = factory(MaintenanceRequest::class, 3)->make();

		$this->device->maintenanceRequests()->saveMany($maintenanceRequests);

		$this->call('GET', '/device-api/maintenance', [
			'serial' => $this->device->serial, 
			'token' => $this->device->token
		]);

		$this->assertResponseOk();
	}

	/**
	 *  It should udpate the status of a maintenance request
	 *
	 * @return void
	 * @test 
	 **/
	public function it_updates_a_maintenance_request()
	{
		$this->device = factory(Device::class)->create();

		$maintenanceRequest = factory(MaintenanceRequest::class)->make();

		$this->device->maintenanceRequests()->save($maintenanceRequest);

		$this->call('POST', '/device-api/maintenance/'. $maintenanceRequest->id, [
			'serial' => $this->device->serial, 
			'token' => $this->device->token, 
			'status' => 'scheduled',
		]);

		$this->seeInDatabase('maintenance_requests', [
			'id' => $maintenanceRequest->id, 
			'status' => 'scheduled',
		]);

		$this->assertResponseOk();
	}

	/**
	 *  It should creates a new maintenance request
	 *
	 * @return void
	 * @test 
	 **/
	public function it_creates_a_maintenance_request()
	{
		$randomString = str_random(10);

		$this->device = factory(Device::class)->create();

		$this->call('POST', '/device-api/maintenance', [
			'serial' => $this->device->serial, 
			'token' => $this->device->token, 
			'message' => 'The garbage disposal.'. $randomString, 
			'update_key' => $randomString,
		]);

		$this->seeInDatabase('maintenance_requests', [
			'device_id' => $this->device->id, 
			'request' => 'The garbage disposal.'.$randomString,
		]);
		
		$this->assertResponseOk();
	}

	/**
	 *  It gets all messages for device
	 *
	 * @return void
	 * @test 
	 **/
	public function it_gets_all_messages_for_device()
	{
		$this->device = factory(Device::class)->create();

		$messages = factory(Message::class, 7)->make();

		$this->device->messages()->saveMany($messages);

		$this->call('GET', '/device-api/message', [
			'serial' => $this->device->serial, 
			'token' => $this->device->token
		]);
	
		$this->assertResponseOk();
	}

	/**
	 *  It creates a new message for device
	 *
	 * @return void
	 * @test 
	 **/
	public function it_creates_a_message_for_device()
	{
		$randomString = str_random(10);

		$this->device = factory(Device::class)->create();

		$this->call('POST', '/device-api/message', [
			'serial' => $this->device->serial, 
			'token' => $this->device->token,
			'message' => 'This message.'.$randomString,
			'update_key' => $randomString,
		]);
	
		$this->seeInDatabase('messages', [
			'body' => 'This message.'.$randomString
		]);

		$this->assertResponseOk();
	}

	/**
	 *  It get the device status
	 *
	 * @return void
	 * @test 
	 **/
	public function it_gets_the_device_status()
	{
		$this->device = factory(Device::class)->create();

		$this->call('GET', '/device-api/rent-status', [
			'serial' => $this->device->serial, 
			'token' => $this->device->token,
		]);

		$this->assertResponseOk();
	}

	/**
	 *  It pays the rent for the apartment
	 *
	 * @return void
	 * @test 
	 **/
	public function it_pays_the_rent_for_the_device()
	{
		$rand = rand(100, 1000);

		$user = factory(User::class, 'landlord')->create();

		$this->device = factory(Device::class)->create();

		$user->devices()->save($this->device);

		$user->gateway()->save(factory(Gateway::class)->create());

		$this->call('POST', '/device-api/pay', [
			'_token' => csrf_token(),
			'serial' => $this->device->serial, 
			'token' => $this->device->token,
			'account_holder' => 'Mike',
			'amount' => $rand,
			'description' => 'Test Charge',
			'card' => [
				'card_number' => '4000100211112222',
				'expiration' => '0919',
				'cvv2' => '999',
			],
		]);

		$this->seeInDatabase('transactions', [
			'payable_id' => $this->device->id, 
			'amount' => $rand,
		]);

		$this->assertResponseOk();
	}
}
