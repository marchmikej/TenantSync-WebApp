<?php

namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;

class RecurringTransaction extends Model
{
    protected $fillable = [
    	'transaction_id',
    	'schedule',
    	'next_date',
    ];

    public function transaction()
    {
    	return $this->belongsTo('TenantSync\Models\Transaction');
    }
}
