<?php

namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    	'user_id',
    	'device_id',
    	'address',
    	'city',
    	'state',
    	'zip',
    	'financed',
    ];

    public function user()
    {
    	return $this->belongsTo('TenantSync\Models\User');
    }

    public function device()
    {
    	return $this->belongsTo('TenantSync\Models\Device');
    }
}
