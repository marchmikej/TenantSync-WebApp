<?php 

namespace TenantSync\Billing;

use Exception;
use TenantSync\Billing\Util;
use TenantSync\Billing\RequestObjectFormatter;

abstract class UsaEpayObject {

	public $userOptions;

	public $requestObject;

	protected $emptyableRequiredFields = [];

	private function __construct($userOptions)
	{
		$this->validateUserOptions($userOptions);

		$this->userOptions = $userOptions;

		$this->formatter = new RequestObjectFormatter; // Should be injected but is here for now
	}

	public function validateUserOptions($userOptions) 
	{
		if (! is_array($userOptions)) {
			throw new Exception('The $userOptions parameter must be an array.');
		}

		$this->validateRequiredInputfields($userOptions);
	}


	public function validateRequiredInputfields($userOptions)
	{
		$requiredFields = [];

		foreach($this->requiredInputFields as $field) {
			if(! Util::arrayHas($userOptions, $field)) {
				$requiredFields[] = $field;
			}
		}	

		if(count($requiredFields)) {
			throw new Exception('The following field(s) are required: '. implode(', ', $requiredFields));
		}
	}

	public static function createWith($options)
	{    
        return (new static($options))->generateRequestObject();
	}


	public function generateRequestObject()
	{
		$this->requestObject = $this->formatter->format($this)->with($this->userOptions);

		$this->resolveEmptyableRequiredFields();

		return $this->requestObject;
	}


	public function resolveEmptyableRequiredFields()
	{
		foreach($this->emptyableRequiredFields as $field) {
			if ($this->notSetInRequestObject($field)) {
				$this->requestObject[$field] = '';
			}
		}
	}


	public function notSetInRequestObject($field)
	{
		return ! Util::arrayHas($this->requestObject, $field);
	}
}