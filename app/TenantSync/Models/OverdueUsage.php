<?php namespace TenantSync\Models;

use Illuminate\Database\Eloquent\Model;

class OverdueUsage extends Model {
	protected $fillable = [
		'device_id', 
		'overdue_types_id'
	];
	
}
