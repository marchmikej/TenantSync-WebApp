<?php namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

	protected $fillable = [
		'user_id',
		'device_id',
		'body',
		'hidden',
		'is_from_device',
		'update_key',
		'created_at'
	];


	public function landlord()
	{
		return $this->belongsTo('TenantSync\Models\User');
	}

	public function device()
	{
		return $this->belongsTo('TenantSync\Models\Device');
	}

}
