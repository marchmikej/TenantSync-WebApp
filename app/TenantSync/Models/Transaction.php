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

	public function getPayableTypeAttribute($type) {
	    // transform to lower case
	    $type = strtolower($type);

	    // to make sure this returns value from the array
	    return array_get($this->types, $type, $type);

	    // which is always safe, because new 'class'
	    // will work just the same as new 'Class'
    }
}
