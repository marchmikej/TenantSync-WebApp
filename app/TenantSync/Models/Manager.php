<?php namespace TenantSync\Models;

use TenantSync\Models\Message;
use TenantSync\Models\RentBill;
use Illuminate\Database\Eloquent\Model;
use TenantSync\Models\MaintenanceRequest;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manager extends Model {

	use SoftDeletes;

	/**
     * The attributes that should be mutated to dates.
     * Used for the soft delete.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

	protected $fillable = [
		'landlord_id',
		'first_name',
		'last_name',
		'position',
		'email',
		'phone',
		];

	public function user()
	{
		return $this->belongsTo('TenantSync\Models\User');
	}

	public function landlord()
	{
		return $this->belongsTo('TenantSync\Models\User', 'landlord_id', 'id');
	}

	public function maintenanceRequests($relations)
	{
		$devices = array_map(function($device) {
			return $device->id;
		}, $this->devices()->toArray());

		if(! empty($relations)) {
			return MaintenanceRequest::whereIn('device_id', $devices)->with($relations)->get();
		}
		return MaintenanceRequest::whereIn('device_id', $devices)->get();
	}

	public function properties()
	{
		return $this->belongsToMany('TenantSync\Models\Property');
	}

	public function devices()
	{
		return collect(\DB::table('devices')->whereIn('property_id', $this->properties->keyBy('id')->keys()->toArray())->get());
	}

	public function messages()
	{
		$devices = array_map(function($device) {
			return $device->id;
		}, $this->devices()->toArray());
		return Message::whereIn('device_id', $devices)->with(['device', 'device.property'])->get();
	}

	public function transactions()
	{
		$devices = array_map(function($device) {
			return $device->id;
		}, $this->devices()->toArray());

		return collect(\DB::table('transactions')
			->where(function($queryContainer) use ($devices) {
				$queryContainer
				->where(function($query) {
					$query->where(['payable_type' => 'property'])
						->whereIn('payable_id', $this->properties->keyBy('id')->keys()->toArray());
				})
				->orWhere(function($query) use ($devices) {
					$query->where(['payable_type' => 'device'])
						->whereIn('payable_id', $devices);
				});
			})
			->get());
	}

	public function recurringTransactions()
	{
		$devices = array_map(function($device) {
			return $device->id;
		}, $this->devices()->toArray());

		return collect(\DB::table('recurring_transactions')
			->where(function($queryContainer) use ($devices) {
				$queryContainer
				->where(function($query) {
					$query->where(['payable_type' => 'property'])
						->whereIn('payable_id', $this->properties->keyBy('id')->keys()->toArray());
				})
				->orWhere(function($query) use ($devices) {
					$query->where(['payable_type' => 'device'])
						->whereIn('payable_id', $devices);
				});
			})
			->get());
	}

	public function rentBills()
	{
		$devices = array_map(function($device) {
			return $device->id;
		}, $this->devices()->toArray());

		return RentBIll::where(['user_id' => $this->landlord->id])->whereIn('device_id', $devices)->get();
	}

	public function rentPayments()
	{
		if(! $this->rentBills()) {
			return false;
		}

		$rentBills = array_map(function($rentBill) {
			return $rentBill['id'];
		}, $this->rentBills()->toArray());
		return collect(\DB::table('rent_payments')->whereIn('rent_bill_id', $rentBills)->get());
	}
}
