<?php namespace TenantSync\Models;

use TenantSync\Models\MaintenanceRequest;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model {

	protected $fillable = [
		'landlord_id',
		];

	public function landlord()
	{
		return $this->belongsTo('TenantSync\Models\User', 'landlord_id', 'id');
	}

	public function devices()
	{
		return $this->belongsToMany('TenantSync\Models\Device');
	}

	public function maintenanceRequests()
	{
		return MaintenanceRequest::whereIn('device_id', $this->devices->keyBy('id')->keys()->toArray())->get();
	}

}
