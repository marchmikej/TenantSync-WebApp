<?php

namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    protected $fillable = [];

    protected $table = 'user_devices';

    public function user()
    {
    	return $this->belongsTo('TenantSync\Models\User');
    }
}
