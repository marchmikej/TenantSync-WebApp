<?php 

namespace TenantSync\Mutators;

abstract class ModelMutator {
	

	public static function set($fields, $list)
	{
		$fields = is_array($fields) ? $fields : array($fields);

		$collection = self::getCollection($list);

		$list = $collection->each(function($model) use ($fields) {

			foreach($fields as $field) {

				$method = camel_case($field);

				$model->$field = (new static)->$method($model);

			}

			return $model;

		});

		return $list;
	}


	protected static function getCollection($list)
	{
		if(is_a($list, 'Illuminate\\Database\\Eloquent\\Collection')) {

			return $list;

		}

		return collect($list);
	}
}