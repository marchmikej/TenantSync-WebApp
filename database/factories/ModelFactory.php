<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$modelPath = 'TenantSync\\Models\\';

$factory->defineAs($modelPath.User::class, 'landlord', function ($faker) {
    return [
        'email' => $faker->email,
        'password' => bcrypt('test'),
        'role' => 'landlord',
    ];
});

$factory->defineAs($modelPath.User::class, 'sales', function ($faker) {
    return [
        'email' => $faker->email,
        'password' => bcrypt('test'),
        'role' => 'sales',
    ];
});

$factory->defineAs($modelPath.User::class, 'manager', function ($faker) {
    return [
        'email' => $faker->email,
        'password' => bcrypt('test'),
        'role' => 'manager',
    ];
});

$factory->define($modelPath.Device::class, function ($faker) use ($modelPath) {
	return [
		'serial' => str_random(10),
		'token' => str_random(6),
		'user_id' => factory($modelPath.User::class, 'landlord')->create()->id, 
		'property_id' => factory($modelPath.Property::class)->create()->id, 
		'alarm_id' => 0, 
		'status' => 'active',
		'vacant' => 0, 
		'late_fee' => rand(0, 30), 
		'grace_period' => rand(0, 10), 
		'location' => $faker->secondaryAddress, 
		'rent_amount' => rand(500, 1000), 
		'rent_due' => \Carbon\Carbon::parse('first day of +1 month')->toDateTimeString(),
		'monthly_cost' => 5, 
		'contact_name' => $faker->firstName, 
		'contact_phone' => $faker->phoneNumber,
	];
});

$factory->define($modelPath.Property::class, function ($faker) use ($modelPath) {
	$price = rand(100000, 600000);

	return [
		'user_id' => factory($modelPath.User::class, 'landlord')->create()->id, 
		'address' => $faker->address, 
		'city' => $faker->city, 
		'state' => $faker->state, 
		'zip' => $faker->postCode, 
		'closing_costs' => rand(500, 4000), 
		'taxes' => rand(1000, 3000), 
		'expenses' => rand(1000, 6000), 
		'purchase_price' => $price,
		'purchase_date' => $faker->date(), 
		'insurance' => rand(500, 3000), 
		'down_payment' => rand($price/5, $price/2), 
		'mortgage_rate' => rand(3, 6), 
		'mortgage_term' => rand(300, 400)
	];
});

$factory->define($modelPath.MaintenanceRequest::class, function($faker) use ($modelPath) {
	return [
		'request' => $faker->realText,
		'response' => '',
		'status' => 'awaiting_response',
		'update_key' => str_random(10),
	];
});

$factory->define($modelPath.Message::class, function($faker) use ($modelPath) {
	$device = factory($modelPath.Device::class)->create();

	return [
		'user_id' => $device->owner->id,
		'device_id' => $device->id,
		'body' => $faker->realText,
		'from_device' => 1, 
		'update_key' => str_random(10),
	];
});

$factory->define($modelPath.Gateway::class, function($faker) use ($modelPath) {

	return [
		'key' => '_OAo2776ws1599T3Y5yLvX65d4j5G0y0', 
		'pin' => '1234',
	];
});

$factory->define($modelPath.Profile::class, function($faker) use ($modelPath) {

	return [
		'user_id' => factory($modelPath.User::class, 'landlord')->create()->id, 
		'first_name' => $faker->firstName, 
		'last_name' => $faker->lastName, 
		'company' => '', 
		'phone' => $faker->phoneNumber, 
		'address' => $faker->address, 
		'city' => $faker->city, 
		'state' => $faker->state, 
		'zip' => $faker->postcode
	];
});
