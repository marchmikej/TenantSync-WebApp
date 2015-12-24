<?php namespace TenantSync\Models;

use TenantSync\Billing\Billable2;
use Illuminate\Database\Eloquent\Model;

class Device extends Model {

	use Billable2;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'devices';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id', 
		'token', 
		'property_id', 
		'serial', 
		'alarm', 
		'status', 
		'late_fee', 
		'grace_period', 
		'location', 
		'rent_amount', 
		'rent_due',
		'balance_due', 
		'contact_name', 
		'contact_phone'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	protected $morphClass = 'device';


	public function owner()
	{
		return $this->belongsTo('TenantSync\Models\User', 'user_id');
	}

	public function property()
	{
		return $this->belongsTo('TenantSync\Models\Property');
	}

	public function maintenanceRequests()
	{
		return $this->hasMany('TenantSync\Models\MaintenanceRequest');
	}

	public function groups()
	{
		return $this->belongsToMany('TenantSync\Models\DeviceGroup');
	}

	public function messages()
	{
		return $this->hasMany('TenantSync\Models\Message');
	}

	public function alarm()
	{
		return $this->belongsTo('TenantSync\Models\Alarm');
	}

	public function beneficiary()
	{
		return [
			'key' => $this->owner->gateway->key,
			'pin' => $this->owner->gateway->pin
			];
	}

	public function managers()
	{
		return $this->belongsToMany('TenantSync\Models\Manager');
	}

	public function transactions()
	{
		return $this->morphMany('TenantSync\Models\Transaction', 'payable');
	}


}
