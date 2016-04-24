<?php 

namespace App\Services;

use Validator;
use Carbon\Carbon;
use TenantSync\Models\User;
use TenantSync\Billing\Util;

class Registrar {

	public static function registerLandlord($input)
	{
		$data = Util::flatten(array_merge($input, [
			'role' => 'landlord', 
			'schedule' => 'monthly', 
			'recurring' => true, 
			'description' => 'TenantSync Subscription.',
			'recurring_amount' => 0,
			'next_charge' => Carbon::now()->addDays(60)->toDateString(),
		]));

		// Create user
		$data['password'] = bcrypt($data['password']);

		$user = User::create($data);

		// Create usaepay account
		$customerId = $user->createUsaEpayAccount($data);

		$user->updateCustomerId($customerId);

		// Create profile
		$profile = $user->profile()->create($data);

		// Create gateway
		$gateway = $user->gateway()->create($data);

		// Create manager
		$data['user_id'] = $user->id;
		
		$manager = $user->managers()->create($data);

		return $user;
	}
}