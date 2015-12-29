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

	// Custom attributes so they can be loaded with the model for javascript
	public $roi;

	// Name for morph relationship
	protected $morphClass = 'property';

	public function owner()
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

	public function roi()
	{
		if(empty($this->purchase_price) || $this->purchase_price == 0) {
			$this->attributes['roi'] = 0;
			return false;
		}

		$appreciation = (new RoiCalculator)->appreciationRoi($this);
		$equity = (new RoiCalculator)->equityRoi($this);
		$cash = (new RoiCalculator)->cashRoi($this);

		$roi = ($appreciation + $equity + $cash) / 3;
		//$roi = (new RoiCalculator)->calculateRoi([$this->$incomes, ($this->value - $this->purchase_price)/$this->down_payment], [$this->expenses]);
		$this->attributes['roi'] = $roi;
		return $roi;
	}

	public function netIncome()
	{
		$amounts = array();
		foreach($this->incomes() as $income)
		{
			$amounts[] = $income->amount;
		}

		foreach($this->expenses() as $expense)
		{
			$amounts[] = $expense->amount;
		}

		return array_sum($amounts);
		//return array_sum($this->incomes()->fetch('amount')->toArray()) - abs(array_sum($this->expenses()->fetch('amount')->toArray()));
	}

	public function incomes()
	{
		$transactions = \DB::table('transactions')
			->where('amount', '>=', 0)
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
			->get();

		return $transactions;

	}

	public function expenses()
	{
		$transactions = \DB::table('transactions')
			->where('amount', '<', 0)
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
			->get();

		return $transactions;
	}

	public function totalExpenses()
	{
		$amounts = array();
		foreach($this->expenses() as $expense)
		{
			$amounts[] = $expense->amount;
		}		
		return array_sum($amounts);
	}

}
