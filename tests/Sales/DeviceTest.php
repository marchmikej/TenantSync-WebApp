<?php

use Carbon\Carbon;
use TenantSync\Models\Property;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DeviceTest extends TestCase
{
	/**
     * Gets a device 
     *
     * @return void
     * @test
     */
    public function it_gets_all_devices()
	{
		$user = $this->it_logs_in_as('sales');
	}

	/**
     * Gets a device 
     *
     * @return void
     * @test
     */
    public function it_gets_one_device()
	{
		
	}

     /**
     * Creates a device for a landlord
     *
     * @return void
     * @test
     */
    public function it_creates_device()
	{
		$user = $this->it_logs_in_as('sales');

		$property = factory(Property::class)->create();

		$location = $this->faker->secondaryAddress;

		$this->call('POST', '/sales/properties/'. $property->id .'/device/', [
			'_token' => csrf_token(),
			'serial' => str_random(10),
			'token' => str_random(5),
			'payment_method_id' => 0,
			'property_id' => $property->id, 
			'vacant' => 1, 
			'late_fee' => 30, 
			'grace_period' => 5, 
			'location' => $location, 
			'rent_amount' => 500, 
			'rent_due' => Carbon::parse('first day of next month')->toDateTimeString(),
			'monthly_cost' => 5, 
			'address' => $this->faker->address,
			'city' => $this->faker->city,
			'zip' => $this->faker->postCode,
			'state' => $this->faker->state,
		]);

		$this->seeInDatabase('devices', ['user_id' => $property->owner()->id, 'location' => $location]);

		$this->seeInDatabase('orders', ['user_id' => $property->owner()->id]);

		$this->assertResponseStatus(302);
	}
}
