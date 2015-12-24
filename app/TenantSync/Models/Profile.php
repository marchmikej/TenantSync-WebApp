<?php namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'profiles';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [ 'user_id', 'first_name', 'last_name', 'company', 'phone', 'address', 'city', 'state', 'zip'];
	////////////'billing_address', 'billing_city', 'billing_state', 'billing_zip', 

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	public function owner()
	{
		return $this->belongsTo('TenantSync\Models\User', 'user_id');
	}

}
