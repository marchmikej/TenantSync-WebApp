<?php

use Carbon\Carbon;
use TenantSync\Models\User;
use TenantSync\Models\Gateway;
use TenantSync\Models\Profile;
use TenantSync\Models\Property;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LandlordTest extends TestCase
{
	/**
     * Gets all the landlords
     *
     * @return void
     * @test
     **/
    public function it_gets_all_landlords()
    {
        $this->it_logs_in_as('sales');

        $this->call('GET', '/sales/landlord');

        $this->assertResponseOk();
    }

    /**
     * Gets all the landlords
     *
     * @return void
     * @test
     **/
    public function it_gets_one_landlord()
    {
        $this->it_logs_in_as('sales');

        $landlord = factory(Profile::class)->create()->landlord;

        $this->call('GET', '/sales/landlord/'. $landlord->id);

        $this->assertResponseOk();
    }

	/**
     * Creates  a new landlord
     *
     * @return void
     * @test
     **/
    public function it_creates_new_landlord()
    {
        $user = $this->it_logs_in_as('sales');

        $password = str_random(8);

        $firstName = $this->faker->firstName;

        $email = $this->faker->email;

        $response = $this->call('POST', '/sales/landlord', [
            '_token' => csrf_token(),
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
            'first_name' => $firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'company' => str_random(8),
            'description' => 'lalalalalalal', //optional
            'recurring' => true,
            'recurring_amount' => 0,
            'schedule' => 'monthly',
            'next_charge' => Carbon::now()->addDays(60)->toDateString(),
            // 'card' => [
            //     'card_number' => '4000100211112222',
            //     'expiration' => '0919',
            //     'cvv2' => '999',
            // ], 
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => $this->faker->postCode,
            'key' => 'thisisakey',
            'pin' => 'thisispin',
        ]);

        $this->seeInDatabase('users', ['email' => $email, 'role' => 'landlord']);
        $this->seeInDatabase('profiles', ['first_name' => $firstName]);
    	$this->seeInDatabase('gateways', ['key' => 'thisisakey']);

    }

    /**
     * It updates a landlord
     *
     * @return void
     * @test
     **/
    public function it_updates_a_landlord()
    {
    	$this->it_logs_in_as('sales');

    	$landlord = factory(Profile::class)->create()->landlord;

    	$gateway = factory(Gateway::class)->make()->toArray();
    	
    	$landlord->save($gateway);

    	$this->call('PATCH', '/sales/landlord/'. $landlord->id, [
    		'_token' => csrf_token(),
    	]);

    	$this->assertResponseOk();
    }
}
