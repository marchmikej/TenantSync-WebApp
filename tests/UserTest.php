<?php

use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{

	public function __construct()
	{
		$this->faker = Faker::create();
	}

    /**
     * Test the home page for 200 response.
     *
     * @return void
     * @test
     */
    public function see_devices_on_home_page()
    {
    	$this->call('GET', '/');
        
        $this->assertResponseOk();
    }

    /**
     * Calculates recurring amount based on devices cost and financing of installment
     *
     * @return void
     * @test
     **/
    public function calculates_recurring_charge_amount()
    {
    	$user = factory(TenantSync\Models\User::class, 'landlord')->create();

    	$this->assertTrue(is_numeric($user->recurringAmount()));
    }

    /**
     * Calculates recurring amount based on devices cost and financing of installment
     *
     * @return void
     * @test
     **/
    public function calculates_net_income()
    {
    	$user = factory(TenantSync\Models\User::class, 'landlord')->create();

    	$this->assertTrue(is_numeric($user->netIncome()));
    }
    
    // /**
    //  * Creates  a new Manager
    //  *
    //  * @return void
    //  * @test
    //  **/
    // public function creates_new_manager()
    // {
    //     $this->seeInDatabase('users', ['email' => 'test@example.com']);
    // }
}
