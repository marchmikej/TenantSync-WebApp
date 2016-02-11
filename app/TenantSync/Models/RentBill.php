<?php

namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;

class RentBill extends Model
{
    protected $fillable = [
    	'user_id',
    	'device_id',
    	'rent_month',
    	'bill_amount',
    	'balance_due',
        'paid',
        'vacant'
    ];


    public function user()
    {
    	return $this->belongsTo('TenantSync\Models\User');
    }

    public function device()
    {
    	return $this->belongsTo('TenantSync\Models\Device');
    }

    public function transactions()
    {
    	return $this->belongsToMany('TenantSync\Models\Transaction', 'rent_payments', 'rent_bill_id', 'transaction_id')->withTimestamps();;
    }

    public static function getRentBillsForUser($user, $with = [], $fromDate = '-1 month') 
    {   

        return $user->rentBills()->where('rent_month', '>=', date('Y-m-d', strtotime($fromDate)))->with($with)->get();
    }

}
