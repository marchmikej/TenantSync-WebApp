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
		'update_key',
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

	public function transaction()
	{
		return $this->belongsTo('TenantSync\Models\Transaction');
	}

	public function device()
	{
		return $this->belongsTo('TenantSync\Models\Device');
	}

	public static function getRequestsForUser($user, $options = [])
	{
		if($user->role == 'manager') {
			return MaintenanceRequest::whereIn('device_id', $user->manager->devices()->keyBy('id')->keys()->toArray())
				->with($options['with'])
				->orderBy('created_at', 'desc')
				->limit($options['limit'])
				->get();
		}
		return $user->maintenanceRequests()->with($options['with'])->orderBy('created_at', 'desc')->limit($options['limit'])->get();
	}

	public function setAppointmentDateAttribute($date)
	{
		$this->attributes['appointment_date'] = date('Y-m-d H:i:s', strtotime($date));
	}

	public function cost()
	{
		return (!empty($this->cost)) ? $this->cost : '';
	}

	public function daysOpen()
	{
		return round((time() - strtotime($this->created_at))/60/60/24, 0);
	}

	public function isOpen()
	{
		return ! ($this->status == 'closed');
	}

	public function isAwaitingApproval()
	{
		return ! ($this->status == 'awaiting_approval');
	}
}
