<?php

namespace TenantSync\Mutators;

use TenantSync\Models\Property;

class PropertyMutator {

	public static function set($field, $data)
	{
		if(count($data) < 2) {
			$data->{$field}();
			return $data; 
		}	

		if(! is_a($data, 'Illuminate\\Database\\Eloquent\\Collection')) {
			$data = $data->getCollection();
		}

		$properties = $data->each(function($property) use ($field) {
			return $property->{$field} = $property->{$field}();
		});
		return $properties;
	}
}