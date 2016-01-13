<?php namespace TenantSync\Models;

use TenantSync\Models\MaintenanceRequest;
use TenantSync\Models\Message;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model {

	protected $fillable = [
		'landlord_id',
		];

	public function landlord()
	{
		return $this->belongsTo('TenantSync\Models\User', 'landlord_id', 'id');
	}

	public function maintenanceRequests($relations)
	{
		$devices = array_map(function($device) {
			return $device->id;
		}, $this->devices());

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
		return \DB::table('devices')->whereIn('property_id', $this->properties->keyBy('id')->keys()->toArray())->get();
		// return \DB::table('devices')->whereIn('property_id', $this->properties->keyBy('id')->keys()->toArray())->select('devices.*')->get();
	}

	public function messages()
	{
		$devices = array_map(function($device) {
			return $device->id;
		}, $this->devices());
		return Message::whereIn('device_id', $devices)->with(['device', 'device.property'])->get();
	}
}
