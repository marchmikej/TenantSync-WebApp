<?php 

namespace TenantSync\Billing;

use TenantSync\Billing\Util;
use TenantSync\Billing\RequestFieldFormatter;

abstract class UsaEpayObject {

	protected $userOptions;

	public $requestArray;

	public function __construct($userOptions)
	{
		$this->validateUserOptions($userOptions);

		$this->userOptions = $userOptions;

		$this->generateRequestArray();
	}


	public function validateRequestOptions($userOptions) 
	{
		if (is_array($userOptions)) {
			$this->validateRequiredInputfields($userOptions);
		}

		throw new Exception('The $userOptions parameter must be an array.');
	}


	public function validateRequiredInputfields($userOptions)
	{
		foreach($this->requiredInputFields as $field) {
			if(! isset($userOptions[$field])) {
				throw new Exception('The '. $field . ' field is required.');
			}
		}	
	}


	public function generateRequestArray()
	{
		$this->resolveRequiredFields();

		$this->fillRequestArray();
	}


	public function fillRequestArray()
	{
		foreach($this->userOptions as $key => $value) {

			//$this->requestArray[$key] = $value;
			$this->requestArray[$key] = RequestFieldFormatter::format($key);
		}
	}


	public function resolveRequiredFields()
	{
		foreach($this->requiredUsaEpayFields as $field) {
			if ($this->fieldNotInRequestOptions($field)) {
				$this->resolveUnsetField($field);
			}
		}
	}


	public function fieldNotInRequestOptions($field)
	{
		return ! isset($this->userOptions[$field]);
	}


	public function resolveUnsetField($field)
	{
		if($this->fieldIsEmptyStringable($field)) {
			$this->usaEpayRequestArray[$field] = '';
		}

		throw new Exception('The '. $field . ' field is required.');
	}


	public function fieldIsEmptyStringable($field)
	{
		return in_array($this->canBeEmptyString, $field);
	}
}