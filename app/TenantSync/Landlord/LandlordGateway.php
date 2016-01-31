<?php namespace TenantSync\Landlord;

use TenantSync\Models\User;
use TenantSync\Models\Profile;
use TenantSync\Models\PaymentMethod;
use TenantSync\Models\Gateway;
use TenantSync\Models\Device;

class LandlordGateway {

	private $registrationCost = 50;


	public function __construct()
	{

	}

	/**
	 * Create a new Landlord entity
	 *
	 * @return User $user
	 * @author 
	 **/

	public function create($data)
	{
		$data['role'] = 'landlord';

		$user = User::create([
			'email' => $data['email'],
			//'password' => password_hash($data['password'], PASSWORD_BCRYPT),
			'role_id' => $data['role_id'],
		]);

		Profile::create([
			'user_id' => $user->id,
			'first_name' => $data['first_name'],
			'last_name' => $data['last_name'],
			'phone' => $data['phone'],
			]);

		// Registration::create([
		// 	'user_id' => $user->id, 
		// 	'ammount_due' => $this->registrationCost
		// ]);


		Gateway::create([
			'user_id' => $user->id,
		]);


		PaymentMethod::create([
			'user_id' => $user->id,
			'name' => ucfirst($data['type']) . 'ending in ' . isset($data['card_number']) ? substr($data['card_number'], -4) : substr($data['account_number'], -4), 
		]);

		return $user;
	}

	public function update(User $landlord, array $relationships)
	{
		$relations = $landlord->getRelations();
		foreach($relationships as $relationship => $data)
		{
			if(isset($relations[$relationship]))
			{
				$landlord->$relationship = $data;
			}
			continue;
		}
		$landlord->push();
	}
}