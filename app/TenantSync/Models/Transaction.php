<?php 

namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {

	protected $types = [
        'property' => 'TenantSync\Models\Property',
        'device' => 'TenantSync\Models\Device',
        'user' => 'TenantSync\Models\User'
    ];

	protected $fillable = [
		'amount',
		'user_id',
		'description',
		'reference_number',
		'date',
		'payable_type',
		'payable_id',
		];

	public function user()
	{
		return $this->belongsTo('TenantSync\Models\User');
	}

	public function payable()
	{
		return $this->morphTo();
	}

	public function getPayableTypeAttribute($type) 
    {
	    $type = strtolower($type);
	    return array_get($this->types, $type, $type);
    }

    public function rentBills()
    {
    	return $this->belongsToMany('TenantSync\Models\RentBill', 'rent_payments', 'transaction_id', 'rent_bill_id')->withTimestamps();;
    }

    public function recurringTransaction()
    {
    	return $this->hasOne('TenantSync\Models\RecurringTransaction');
    }

    public function recurring()
    {
    	if($this->recurringTransaction)
    	{
    		$this->attributes['recurring'] = $this->recurringTransaction;
    		return true;
    	}
    	return false;
    }

    public function rentPayments()
    {
    	return \DB::table('rent_payments')->where(['transaction_id' => $this->id])->get();
    }

    public static function getTransactionsForUser($user, $with)
    {
        if($user->role = 'landlord') {
            return self::where(['user_id' => $user->id])->with($with)->get();
        }
        else {
            $transactions = array_map(function($transaction) {
                return $transaction->id;
            }, $user->manager->transactions());

            return self::whereIn('id', $transactions)->with($with)->get();
        }
    }
}
