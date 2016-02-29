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
		'alarm_id', 
		'status',
		'vacant', 
		'late_fee', 
		'grace_period', 
		'location', 
		'rent_amount', 
		'rent_due',
		'last_contact',
		'balance_due',
		'monthly_cost', 
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

	protected $appends = ['address'];

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

	public function transactions()
	{
		return $this->morphMany('TenantSync\Models\Transaction', 'payable');
	}

	public function rentBills()
	{
		return $this->hasMany('TenantSync\Models\RentBill');
	}

	public static function getDevicesForUser($user, $with = [])
	{
		if($user->role == 'manager') {
			return Device::whereIn('property_id', $user->manager->properties->keyBy('id')->keys()->toArray())->with($with)->get();
		}
		return $user->devices()->with($with)->get();
	}

	public function rentOwed()
	{
		return array_sum($this->rentBills->pluck('bill_amount')->toArray()) - array_sum($this->transactions->pluck('amount')->toArray());
	}
	public function getAddressAttribute()
	{
		return $this->address();
	}
	public function address()
	{
		return $this->property->address . ', ' . $this->location;
	}

	public function balance()
	{
		$rentBills = array_sum($this->rentBills->pluck('bill_amount')->toArray());
		$transactions = array_sum($this->transactions->pluck('amount')->toArray());

		return $rentBills - $transactions;
	}

	public function updateAlarm()
	{		
		$balance = $this->balance();

		if($balance < 0) {
		    $this->alarm_id = 0;

		    $this->save();

		    return false;
		}

		$latestBill = RentBill::where(['device_id' => $this->id])->orderBy('created_at', 'desc')->first();

		if(strtotime($latestBill->rent_month. ' + ' .$this->grace_period. ' days') < time()) {
		    $this->alarm_id = 1;
		}

		$this->save();
	}
}
