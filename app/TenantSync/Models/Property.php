<?php 

namespace TenantSync\Models;

use App\Services\RoiCalculator;
use Illuminate\Database\Eloquent\Model;

class Property extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'properties';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id', 
		'address', 
		'apt', 
		'city', 
		'state', 
		'zip', 
		'closing_costs', 
		'taxes', 
		'expenses', 
		'purchase_price',
		'purchase_date', 
		'insurance', 
		'down_payment', 
		'mortgage_rate', 
		'mortgage_term'
	];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	// Name for morph relationship
	protected $morphClass = 'property';

	public function owner()
	{
		return $this->user;
	}

	public function user()
	{
		return $this->belongsTo('TenantSync\Models\User');
	}

	public function devices()
	{
		return $this->hasMany('TenantSync\Models\Device');
	}

	public function transactions()
	{
		return $this->morphMany('TenantSync\Models\Transaction', 'payable');
	}

	public function managers()
	{
		return $this->belongsToMany('TenantSync\Models\Manager');
	}

	public static function getPropertiesForUser($user, $with = [])
	{
		if($user->role == 'manager') {
			return $user->manager->properties()->with($with)->get();
		}
		
		return $user->properties()->with($with)->get();
	}

	public function netIncome($fromDate = '-1 month')
	{
		$amounts = array();
		$transactions = collect(array_merge($this->incomes()->toArray(), $this->expenses()->toArray()));
		$transactions = $transactions->filter(function($transaction) use ($fromDate) {
				return strtotime($transaction->date) >= strtotime($fromDate);
		});
		foreach($transactions as $transaction)
		{
			$amounts[] = $transaction->amount;
		}

		return array_sum($amounts);
	}

	public function incomes()
	{
		return $this->transactions->filter(function($transaction) {
			return $transaction->amount <= 0;
		});
	}

	public function expenses()
	{
		return $this->transactions->filter(function($transaction) {
			return $transaction->amount > 0;
		});
	}


}
