<?php 

namespace TenantSync\Mutators;

abstract class ModelMutator {
	
	/**
	 * Set the given fields on the target
	 * 
	 * @param array $fields
	 * @param mixed $target Can be Model or Collection
	 */	
	public static function set($fields, $target)
	{
		$fields = is_array($fields) ? $fields : array($fields);

		if(is_a($target, 'Illuminate\\Database\\Eloquent\\Collection')) {
			return self::setFieldsOnCollection($target, $fields);
		}

		return self::setFieldsOnModel($target, $fields);
	}


	/**
	 * Set the fields on the collection
	 * 
	 * @param Collection $collection 
	 * @param array $fields
	 */
	public static function setFieldsOnCollection($collection, $fields)
	{
		$collection->each(function($model) use ($fields) {
			return self::setFieldsOnModel($model, $fields);
		});

		return $collection;
	}


	/**
	 * Set the fields on the Model
	 * 
	 * @param Model $model  
	 * @param array $fields
	 */
	public static function setFieldsOnModel($model, $fields)
	{
		foreach($fields as $field) {
			$method = camel_case($field);

			$model->$field = (new static)->$method($model);
		}

		return $model;
	}
}