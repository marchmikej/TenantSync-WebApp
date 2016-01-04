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

	public function maintenanceRequests()
	{
		return MaintenanceRequest::whereIn('device_id', $this->devices()->pluck('id')->toArray())->get();
	}

	public function properties()
	{
		return $this->belongsToMany('TenantSync\Models\Property');
	}

	public function devices()
	{
		return \DB::table('devices')->whereIn('property_id', $this->properties->keyBy('id')->keys()->toArray())->select('devices.*')->get();
	}

}
