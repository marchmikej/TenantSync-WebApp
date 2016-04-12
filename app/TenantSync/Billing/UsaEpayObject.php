<?php 

namespace TenantSync\Billing;

use Exception;
use TenantSync\Billing\Util;
use TenantSync\Billing\RequestObjectFormatter;

abstract class UsaEpayObject {

	public $userOptions;

	public $requestObject;

	public $emptyableRequiredFields = [];

	private function __construct($userOptions, $validate)
	{
		$this->userOptions = $userOptions;

		if($validate) {
			$this->validateUserOptions();
		}

		$this->formatter = new RequestObjectFormatter; // Should be injected but is here for now
	}

	public function validateUserOptions() 
	{
		if (! is_array($this->userOptions)) {
			throw new Exception('The $userOptions parameter must be an array.');
		}

		$this->validateRequiredInputfields();		
	}


	public function validateRequiredInputfields()
	{
		$requiredFields = [];

		foreach($this->requiredInputFields as $field) {
			if($this->fieldNotInUserOptions($field)) {
				$requiredFields[] = $field;
			}
		}	

		if(count($requiredFields)) {
			throw new Exception('The following field(s) are required in ' . static::class . ' : '. implode(', ', $requiredFields));
		}
	}

	public function fieldNotInUserOptions($field)
	{
		return ! Util::arrayHas($this->userOptions, $field);
	}

	public static function createWith($options, $validate = true, $fillEmptyable = true)
	{    
        return (new static($options, $validate))->generateRequestObject($fillEmptyable);
	}

	public function generateRequestObject($fillEmptyable)
	{
		$this->requestObject = $this->formatter->format($this)->with($this->userOptions, $fillEmptyable);

		return $this->requestObject;
	}
}