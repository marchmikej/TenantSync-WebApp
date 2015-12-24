<?php namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model {

	protected $fillable = [
		'user_id',
		'ammount_due',
		'is_paid'
	];

	public function user()
	{
		return $this->belongsTo('TenantSync\Models\User');
	}

}
