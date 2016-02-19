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

	public static function getMessagesForUser($user, $options = [])
	{
		if ($user->role == 'manager') {
			$devices = array_map(function($device) {
				return $device->id;
			}, $user->manager->devices()->pluck('id')->toArray());
			return Message::whereIn('device_id', $devices)->with($options['with'])->limit($options['limit'])->get();
		}

		return $user->messages()->with($options['with'])->limit($options['limit'])->get();
	}

}
