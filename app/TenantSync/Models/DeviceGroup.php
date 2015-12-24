<?php namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceGroup extends Model {

		/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'device_groups';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['user_id', 'title', 'manager_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	public function devices()
	{
		return $this->hasMany('TenantSync\Models\Device');
	}

	public function manager()
	{
		return $this->belongsTo('TenantSync\Models\User', 'manager_id');
	}

	public function owner()
	{
		return $this->belongsTo('TenantSync\Models\User', 'user_id');
	}

}
