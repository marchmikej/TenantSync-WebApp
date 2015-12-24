<?php namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model {

	protected $fillable = [
		'user_id',
		'pin',
		'key',
	];

	public function user()
	{
		return $this->belongsTo('TenantSync\Models\User');
	}

}
