<?php namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'maintenance_requests';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id', 
		'device_id', 
		'request',
		'response',
		'status',
		'cost',
		'appointment_date',
		'transaction_id',
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	public function user()
	{
		return $this->belongsTo('TenantSync\Models\User');
	}


	public function device()
	{
		return $this->belongsTo('TenantSync\Models\Device');
	}

	public function cost()
	{
		return (!empty($this->cost)) ? $this->cost : '';
	}

	public function daysOpen()
	{
		return round((time() - strtotime($this->created_at))/60/60/24, 0);
	}
}
