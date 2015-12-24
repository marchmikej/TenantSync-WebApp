<?php

namespace TenantSync\Billing\UsaEpaySoap;

class CurrencyConversion
{

    /**
     * @var float $Amount
     */
    protected $Amount = null;

    /**
     * @var string $Currency
     */
    protected $Currency = null;

    /**
     * @var float $FromAmount
     */
    protected $FromAmount = null;

    /**
     * @var string $FromCurrency
     */
    protected $FromCurrency = null;

    /**
     * @var float $Rate
     */
    protected $Rate = null;

    /**
     * @param float $Amount
     * @param string $Currency
     * @param float $FromAmount
     * @param string $FromCurrency
     * @param float $Rate
     */
    public function __construct($Amount, $Currency, $FromAmount, $FromCurrency, $Rate)
    {
      $this->Amount = $Amount;
      $this->Currency = $Currency;
      $this->FromAmount = $FromAmount;
      $this->FromCurrency = $FromCurrency;
      $this->Rate = $Rate;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
      return $this->Amount;
    }

    /**
     * @param float $Amount
     * @return \TenantSync\Billing\UsaEpaySoap\CurrencyConversion
     */
    public function setAmount($Amount)
    {
      $this->Amount = $Amount;
      return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
      return $this->Currency;
    }

    /**
     * @param string $Currency
     * @return \TenantSync\Billing\UsaEpaySoap\CurrencyConversion
     */
    public function setCurrency($Currency)
    {
      $this->Currency = $Currency;
      return $this;
    }

    /**
     * @return float
     */
    public function getFromAmount()
    {
      return $this->FromAmount;
    }

    /**
     * @param float $FromAmount
     * @return \TenantSync\Billing\UsaEpaySoap\CurrencyConversion
     */
    public function setFromAmount($FromAmount)
    {
      $this->FromAmount = $FromAmount;
      return $this;
    }

    /**
     * @return string
     */
    public function getFromCurrency()
    {
      return $this->FromCurrency;
    }

    /**
     * @param string $FromCurrency
     * @return \TenantSync\Billing\UsaEpaySoap\CurrencyConversion
     */
    public function setFromCurrency($FromCurrency)
    {
      $this->FromCurrency = $FromCurrency;
      return $this;
    }

    /**
     * @return float
     */
    public function getRate()
    {
      return $this->Rate;
    }

    /**
     * @param float $Rate
     * @return \TenantSync\Billing\UsaEpaySoap\CurrencyConversion
     */
    public function setRate($Rate)
    {
      $this->Rate = $Rate;
      return $this;
    }

}
