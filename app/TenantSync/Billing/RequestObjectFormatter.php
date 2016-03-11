<?php 

namespace TenantSync\Billing;

use Exception;
use TenantSync\Billing\Util;

class RequestObjectFormatter {
	
	protected $inputOptionToObjectName;

	protected $requestObject;
	
	protected $usaEpayObject;

	public function format($usaEpayObject)
	{
		$this->usaEpayObject = $usaEpayObject;
		
		$this->inputOptionToObjectName = $usaEpayObject->inputOptionToObjectName;
		
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
			if($this->isNotValidInputField($key)) {
				// If is not in local or Mapper key map
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
		$className = $this->inputOptionToObjectName[$key];

		$fullClassPath = __NAMESPACE__ . '\\' . $className;

		if(! class_exists($fullClassPath)) {
			return $inputOptions[$key];
		}

		$newObject = new $fullClassPath(Util::flatten($inputOptions));

		return $newObject->toArray();
	}


	public function getUsaEpayKey($key)
	{	
		return $this->inputOptionToObjectName[$key];
	}


	public function fieldAlreadySet($usaEpayKey)
	{
		return Util::arrayHas($this->requestObject, $usaEpayKey);
	}


	public function isNotValidInputField($key)
	{
		return ! Util::arrayHas($this->inputOptionToObjectName, $key);
	}
}