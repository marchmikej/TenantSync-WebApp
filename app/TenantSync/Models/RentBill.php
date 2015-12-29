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
    ];


    public function user()
    {
    	return $this->belongsTo('TenantSync\Models\User');
    }

    public function device()
    {
    	return $this->belongsTo('TenantSync\Models\Device');
    }

    public function addPayment()
    {
    	//
    }

}
