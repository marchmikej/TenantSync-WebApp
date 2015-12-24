<?php

namespace TenantSync\Billing\UsaEpaySoap;

class AccountDetails
{

    /**
     * @var string $CardholderAuthentication
     */
    protected $CardholderAuthentication = null;

    /**
     * @var string $CheckPlatform
     */
    protected $CheckPlatform = null;

    /**
     * @var string $CreditCardPlatform
     */
    protected $CreditCardPlatform = null;

    /**
     * @var boolean $DebitCardSupport
     */
    protected $DebitCardSupport = null;

    /**
     * @var string $DirectPayPlatform
     */
    protected $DirectPayPlatform = null;

    /**
     * @var string $Industry
     */
    protected $Industry = null;

    /**
     * @var CurrencyObjectArray $SupportedCurrencies
     */
    protected $SupportedCurrencies = null;

    /**
     * @param string $CardholderAuthentication
     * @param string $CheckPlatform
     * @param string $CreditCardPlatform
     * @param boolean $DebitCardSupport
     * @param string $DirectPayPlatform
     * @param string $Industry
     * @param CurrencyObjectArray $SupportedCurrencies
     */
    public function __construct($CardholderAuthentication, $CheckPlatform, $CreditCardPlatform, $DebitCardSupport, $DirectPayPlatform, $Industry, $SupportedCurrencies)
    {
      $this->CardholderAuthentication = $CardholderAuthentication;
      $this->CheckPlatform = $CheckPlatform;
      $this->CreditCardPlatform = $CreditCardPlatform;
      $this->DebitCardSupport = $DebitCardSupport;
      $this->DirectPayPlatform = $DirectPayPlatform;
      $this->Industry = $Industry;
      $this->SupportedCurrencies = $SupportedCurrencies;
    }

    /**
     * @return string
     */
    public function getCardholderAuthentication()
    {
      return $this->CardholderAuthentication;
    }

    /**
     * @param string $CardholderAuthentication
     * @return \TenantSync\Billing\UsaEpaySoap\AccountDetails
     */
    public function setCardholderAuthentication($CardholderAuthentication)
    {
      $this->CardholderAuthentication = $CardholderAuthentication;
      return $this;
    }

    /**
     * @return string
     */
    public function getCheckPlatform()
    {
      return $this->CheckPlatform;
    }

    /**
     * @param string $CheckPlatform
     * @return \TenantSync\Billing\UsaEpaySoap\AccountDetails
     */
    public function setCheckPlatform($CheckPlatform)
    {
      $this->CheckPlatform = $CheckPlatform;
      return $this;
    }

    /**
     * @return string
     */
    public function getCreditCardPlatform()
    {
      return $this->CreditCardPlatform;
    }

    /**
     * @param string $CreditCardPlatform
     * @return \TenantSync\Billing\UsaEpaySoap\AccountDetails
     */
    public function setCreditCardPlatform($CreditCardPlatform)
    {
      $this->CreditCardPlatform = $CreditCardPlatform;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getDebitCardSupport()
    {
      return $this->DebitCardSupport;
    }

    /**
     * @param boolean $DebitCardSupport
     * @return \TenantSync\Billing\UsaEpaySoap\AccountDetails
     */
    public function setDebitCardSupport($DebitCardSupport)
    {
      $this->DebitCardSupport = $DebitCardSupport;
      return $this;
    }

    /**
     * @return string
     */
    public function getDirectPayPlatform()
    {
      return $this->DirectPayPlatform;
    }

    /**
     * @param string $DirectPayPlatform
     * @return \TenantSync\Billing\UsaEpaySoap\AccountDetails
     */
    public function setDirectPayPlatform($DirectPayPlatform)
    {
      $this->DirectPayPlatform = $DirectPayPlatform;
      return $this;
    }

    /**
     * @return string
     */
    public function getIndustry()
    {
      return $this->Industry;
    }

    /**
     * @param string $Industry
     * @return \TenantSync\Billing\UsaEpaySoap\AccountDetails
     */
    public function setIndustry($Industry)
    {
      $this->Industry = $Industry;
      return $this;
    }

    /**
     * @return CurrencyObjectArray
     */
    public function getSupportedCurrencies()
    {
      return $this->SupportedCurrencies;
    }

    /**
     * @param CurrencyObjectArray $SupportedCurrencies
     * @return \TenantSync\Billing\UsaEpaySoap\AccountDetails
     */
    public function setSupportedCurrencies($SupportedCurrencies)
    {
      $this->SupportedCurrencies = $SupportedCurrencies;
      return $this;
    }

}
