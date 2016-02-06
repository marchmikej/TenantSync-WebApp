<?php 

namespace TenantSync\Mutators;

abstract class ModelMutator {

	public function set($fields, $data)
	{
		$fields = is_array($fields) ? $fields : [$fields];

		$collection = $this->getCollection($data);

		$items = $collection->each(function($item) use ($fields) {
			foreach($fields as $field) {
				return $item->$field = $this->{camel_case($field)}($item);
			}
		});

		return $items;
	}

	public function getCollection($data)
	{
		if(is_a($data, 'Illuminate\\Database\\Eloquent\\Collection')) {
			return $data;
		} 
		// elseif(is_a($data, 'Illuminate\\Pagination\\AbstractPaginator')) {
		// 	return $data->getCollection();
		// }
		return collect($data);
	}
}