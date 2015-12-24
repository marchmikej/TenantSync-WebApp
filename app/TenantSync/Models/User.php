<?php namespace TenantSync\Models;

use TenantSync\Auth\UserACL;
use TenantSync\Billing\Billable2;
use Illuminate\Auth\Authenticatable;
use TenantSync\Auth\UserRelationships;

use TenantSync\Auth\AuthorizesUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, AuthorizableContract {

	use Authenticatable, CanResetPassword, Authorizable;

	/**
	 * Application's Traits (Separation of various types of methods)
	 */
	use AuthorizesUser, Billable2;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['email', 'password', 'role', 'status', 'customer_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	protected $morphClass = 'user';


	public function profile()
	{
		return $this->hasOne('TenantSync\Models\Profile');
	}

	public function hasRole($role)
	{
		if(is_string($role))
		{
			return $this->roles->contains('name', $role);
		}

		return !! $role->intersect($this->roles)->count();
	}

	public function paymentMethods()
	{
		return $this->hasMany('TenantSync\Models\PaymentMethod');
	}

	public function devices()
	{
		return $this->hasMany('TenantSync\Models\Device');
	}

	public function properties()
	{
		return $this->hasMany('TenantSync\Models\Property');
	}

	public function gateway()
	{
		return $this->hasOne('TenantSync\Models\Gateway');
	}

	public function role()
	{
		return $this->belongsTo('TenantSync\Models\Role');
	}

	public function messages()
	{
		return $this->hasMany('TenantSync\Models\Message');
	}

	public function maintenanceRequests()
	{
		return $this->hasMany('TenantSync\Models\MaintenanceRequest');
	}

	public function managers()
	{
		return $this->hasMany('TenantSync\Models\Manager');
	}

	public function registration()
	{
		return $this->hasOne('TenantSync\Models\Registration');
	}

	public function transactions()
	{
		return $this->hasMany('TenantSync\Models\Transaction');
	}

	public function isRegistered()
	{
		return $this->registration->is_paid;
	}

}
