<?php 

namespace TenantSync\Billing;

use TenantSync\Billing\Util;

abstract class UsaEpayObject {

	// use Util;

	/* protected $billable; */
	protected $properties; 
	protected $fillable;
	protected $required;

	public function __construct()	
	{
		//
	}

	public function properties($options)
	{
		foreach($this->fillable as $key => $value)
		{
			if(isset($options[$key]))
			{
				if (method_exists($this, camel_case($key)))
				{
					$result = $this->{camel_case($key)}($value);
					if (is_array($result))
					{
						$this->properties[$result['key']] = $result['value'];
						continue;	
					}
					$this->properties[$value] = $result;
					continue;
				}
				$this->properties[$value] = $options[$key];
				continue;
			}

			if (in_array($key, $this->required) && method_exists($this, camel_case($key)))
			{
				$result = $this->{camel_case($key)}($value);
				if (is_array($value))
				{
					$this->properties[$result['key']] = $result['value'];
					continue;	
				}
				$this->properties[$value] = $result;
				continue;
			}
		}
		return $this->properties;
	}
}