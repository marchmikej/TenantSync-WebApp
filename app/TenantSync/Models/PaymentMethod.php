<?php namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model {

	protected $fillable = [
		'user_id',
		'customer_id',
		'name'
		];

	public function user()
	{
		return $this->belongsTo('TenantSync\Models\User');
	}



}
