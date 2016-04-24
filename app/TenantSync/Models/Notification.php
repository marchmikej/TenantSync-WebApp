<?php

namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
    	'notification',
    	'manager_id',
    ];

}
