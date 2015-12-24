<?php namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;

class RentPayment extends Model {

	protected $fillable = [
		'transaction_id',
		'user_id',
		'device_id',
	];

	public function user()
	{
		return $this->belongsTo('TenantSync\Models\User');
	}

}
