<?php 

namespace TenantSync\Billing;

use Exception;
use TenantSync\Billing\Util;

class RequestObjectFormatter {
	
	protected $inputToObjectName;

	protected $requestObject;
	
	protected $object;

	public function format($usaEpayObject)
	{
		$this->object = $usaEpayObject;
		
		return $this;
	}


	public function with($inputOptions, $fillEmptyable = true)
	{		
		$requestObject = $this->fillRequestObject($inputOptions);
		if ($fillEmptyable) {
			$requestObject = $this->resolveEmptyableRequiredFields($requestObject);
		}

		return $requestObject;
	}

	public function fillRequestObject($inputOptions)
	{
		$requestObject = [];

		foreach ($inputOptions as $key => $value) {
			if($this->inputFieldNotValid($key)) {
				continue;
			}

			$usaEpayKey = $this->getUsaEpayKey($key); 

			if($this->fieldAlreadySet($requestObject, $usaEpayKey)) {
				continue;
			}

			$requestObject[$usaEpayKey] = $this->generateValueForInputField($key, $inputOptions);
		}
		
		return $requestObject;
	}


	public function generateValueForInputField($key, $inputOptions)
	{
		$className = $this->object->inputToObjectName[$key];

		$fullClassPath = __NAMESPACE__ . '\\' . $className;

		if(! class_exists($fullClassPath)) {
			return $inputOptions[$key];
		}

		$options = Util::flatten($inputOptions);

		return $fullClassPath::createWith($options);

	}

	public function resolveEmptyableRequiredFields($requestObject)
	{
		foreach($this->object->emptyableRequiredFields as $field) {
			$usaEpayField = $this->getUsaEpayKey($field);

			if ($this->notSetInRequestObject($requestObject, $usaEpayField)) {
				$requestObject[$usaEpayField] = '';
			}
		}
		return $requestObject;
	}

	public function getUsaEpayKey($key)
	{	
		return $this->object->inputToObjectName[$key];
	}

	public function fieldAlreadySet($requestObject, $usaEpayKey)
	{
		return Util::arrayHas($requestObject, $usaEpayKey);
	}

	public function notSetInRequestObject($requestObject, $field)
	{
		return ! Util::arrayHas($requestObject, $field);
	}

	public function inputFieldNotValid($key)
	{
		return ! Util::arrayHas($this->object->inputToObjectName, $key);
	}
}