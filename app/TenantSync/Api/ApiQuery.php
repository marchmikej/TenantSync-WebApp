<?php

namespace TenantSync\Api;

class ApiQueryBuilder {

	protected $query;
	protected $model;
	
	public function __construct($model, $method, $conditions)
	{	
		$this->model = new $model;
		$this->query = $model->{$method}(array_values($conditions));
	}
}