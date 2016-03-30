<?php 

namespace TenantSync\Billing;

use Exception;
use TenantSync\Billing\Util;

class RequestObjectFormatter {
	
	protected $inputToObjectName;

	protected $requestObject;
	
	protected $usaEpayObject;

	public function format($usaEpayObject)
	{
		$this->usaEpayObject = $usaEpayObject;
		
		$this->inputToObjectName = $usaEpayObject->inputToObjectName;
		
		return $this;
	}


	public function with($inputOptions)
	{		
		$this->fillRequestObject($inputOptions);

		return $this->requestObject;
	}


	public function fillRequestObject($inputOptions)
	{
		foreach ($inputOptions as $key => $value) {
			if($this->inputFieldNotValid($key)) {
				// If is not in local key map or Mapper key map
				continue;
			}

			$usaEpayKey = $this->getUsaEpayKey($key); 

			if($this->fieldAlreadySet($usaEpayKey)) {
				continue;
			}

			$this->requestObject[$usaEpayKey] = $this->generateValueForInputField($key, $inputOptions);
		}
	}


	public function generateValueForInputField($key, $inputOptions)
	{
		$className = $this->inputToObjectName[$key];

		$fullClassPath = __NAMESPACE__ . '\\' . $className;

		if(! class_exists($fullClassPath)) {
			return $inputOptions[$key];
		}

		$options = Util::flatten($inputOptions);

		return $fullClassPath::createWith($options);

	}


	public function getUsaEpayKey($key)
	{	
		return $this->inputToObjectName[$key];
	}


	public function fieldAlreadySet($usaEpayKey)
	{
		return Util::arrayHas($this->requestObject, $usaEpayKey);
	}


	public function inputFieldNotValid($key)
	{
		return ! Util::arrayHas($this->inputToObjectName, $key);
	}
}