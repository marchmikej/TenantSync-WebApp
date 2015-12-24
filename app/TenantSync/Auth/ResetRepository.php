v<?php namespace TenantSync\Password;

use TenantSync\Repositories\EloquentRepository;
use TenantSync\Models\PasswordReset;

class ResetRepository extends EloquentRepository {

	public function __construct(PasswordReset $model)
	{
		$this->model = $model;
	}

	public function save($landlord)
	{
		$token = hash_hmac('sha256', str_random(40), getenv('APP_KEY'));
		$this->model->create(['email' => $landlord->email, 'token' => $token]);
		return $token;
	}
}