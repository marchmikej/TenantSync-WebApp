<?php 

namespace TenantSync\Billing;

trait Util {

	public function set($options)
	{
		foreach($options as $key => $value)
		{
			if(isset($this->fillable[$key]) && is_string($value))
			{	
				$property = $this->fillable[$key];
				$this->$property = $value;
			}
			if(is_array($value))
			{
				$this->set($value);
			}
			continue;
		}
	}
}