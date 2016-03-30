<?php

namespace TenantSync\Billing;

class UsaEpay {

	private $soapUrl;

	public $gateway;

	private $usaEpayPath;

	private $usaEpayPackage;

	public function __construct()
	{
		$this->soapUrl = config('usaEpay.soapUrl');

		$this->gateway = new \SoapClient($this->soapUrl);

		$this->usaEpayPath = config('usaEpay.usaEpayPath');

		$this->usaEpayPackage = require_once $this->usaEpayPath;
	}

	public function  __call($method, $parameters)
	 {
	   if(method_exists($this->usaEpayPackage, $method)) {
	     return call_user_func_array(array($this->usaEpayPackage, $method), $parameters);
	   }

	   throw new Exception('Method ' . $method . ' doesn\'t exists.');
	 }

}