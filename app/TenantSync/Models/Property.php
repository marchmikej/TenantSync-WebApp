<?php 

namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\RoiCalculator;

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

	// Additional attributes to set on the class
	protected $appends = ['roi', 'net_income', 'all_transactions'];

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

	public function getAllTransactionsAttribute()
	{
		return $this->allTransactions();
	}

	public function allTransactions()
	{
		$transactions = collect(\DB::table('transactions')
			->where(function($queryContainer) {
				$queryContainer
				->where(function($query) {
					$query->where(['payable_type' => 'property'])
						->where(['payable_id' => $this->id]);
				})
				->orWhere(function($query) {
					$query->where(['payable_type' => 'device'])
						->whereIn('payable_id', $this->devices->pluck('id')->toArray());
				});
			})
			->get());

		return $transactions;
	}

	public function getRoiAttribute($value)
	{
		return $this->roi();
	}

	public function roi()
	{
		if(empty($this->value) || $this->value == 0) {
			return 0;
		}

		$appreciation = (new RoiCalculator)->appreciationRoi($this);

		$equity = (new RoiCalculator)->equityRoi($this);

		$cash = (new RoiCalculator)->cashRoi($this);

		$roi = ($appreciation + $equity + $cash) / 3;

		return $roi;
	}

	public function getNetIncomeAttribute($value)
	{
		return $this->netIncome('first of the year');
	}

	public function netIncome($fromDate = '-1 month')
	{
		$transactions = $this->allTransactions();

		$transactions = $transactions->filter(function($transaction) use ($fromDate) {
				return strtotime($transaction->date) >= strtotime($fromDate);
		});

		$netIncome = array_sum($transactions->pluck('amount')->toArray());

		return $netIncome;
	}

	public function incomes()
	{
		return $this->allTransactions()->filter(function($transaction) {
			return $transaction->amount <= 0;
		});
	}

	public function expenses()
	{
		return $this->allTransactions()->filter(function($transaction) {
			return $transaction->amount > 0;
		});
	}


}
