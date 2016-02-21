<?php

namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;
use TenantSync\Models\RecurringTransaction;

class RecurringTransaction extends Model
{
    protected $types = [
        'property' => 'TenantSync\Models\Property',
        'device' => 'TenantSync\Models\Device',
        'user' => 'TenantSync\Models\User'
    ];

	protected $fillable = [
		'amount',
		'user_id',
		'description',
		'payable_type',
		'payable_id',
		'schedule',
		'day',
		'last_ran',
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

    public function address()
    {
        switch($this->payable_type) {
            case 'TenantSync\\Models\\Device': 
                $device = Device::find($this->payable_id);
                return $device->property->address . ', ' . $device->location;
            case 'TenantSync\\Models\\Property':
                return Property::find($this->payable_id)->address;
            default:
                return 'General';
        }
    }

    public static function getTransactionsForUser($user, $with = [])
    {
        if($user->role == 'manager') {
            $transactions = array_map(function($transaction) {
                return $transaction->id;
            }, $user->manager->recurringTransactions()->toArray());

            return self::whereIn('id', $transactions)->with($with)->get(); 
        }

        return $user->recurringTransactions()->with($with)->get(); 
    }
}
