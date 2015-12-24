<?php

namespace TenantSync\Billing\UsaEpaySoap;

class CurrencyObject
{

    /**
     * @var string $Currency
     */
    protected $Currency = null;

    /**
     * @var int $DecimalPlaces
     */
    protected $DecimalPlaces = null;

    /**
     * @var int $NumericCode
     */
    protected $NumericCode = null;

    /**
     * @var float $Rate
     */
    protected $Rate = null;

    /**
     * @var string $TextCode
     */
    protected $TextCode = null;

    /**
     * @param string $Currency
     * @param int $DecimalPlaces
     * @param int $NumericCode
     * @param float $Rate
     * @param string $TextCode
     */
    public function __construct($Currency, $DecimalPlaces, $NumericCode, $Rate, $TextCode)
    {
      $this->Currency = $Currency;
      $this->DecimalPlaces = $DecimalPlaces;
      $this->NumericCode = $NumericCode;
      $this->Rate = $Rate;
      $this->TextCode = $TextCode;
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
     * @return \TenantSync\Billing\UsaEpaySoap\CurrencyObject
     */
    public function setCurrency($Currency)
    {
      $this->Currency = $Currency;
      return $this;
    }

    /**
     * @return int
     */
    public function getDecimalPlaces()
    {
      return $this->DecimalPlaces;
    }

    /**
     * @param int $DecimalPlaces
     * @return \TenantSync\Billing\UsaEpaySoap\CurrencyObject
     */
    public function setDecimalPlaces($DecimalPlaces)
    {
      $this->DecimalPlaces = $DecimalPlaces;
      return $this;
    }

    /**
     * @return int
     */
    public function getNumericCode()
    {
      return $this->NumericCode;
    }

    /**
     * @param int $NumericCode
     * @return \TenantSync\Billing\UsaEpaySoap\CurrencyObject
     */
    public function setNumericCode($NumericCode)
    {
      $this->NumericCode = $NumericCode;
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
     * @return \TenantSync\Billing\UsaEpaySoap\CurrencyObject
     */
    public function setRate($Rate)
    {
      $this->Rate = $Rate;
      return $this;
    }

    /**
     * @return string
     */
    public function getTextCode()
    {
      return $this->TextCode;
    }

    /**
     * @param string $TextCode
     * @return \TenantSync\Billing\UsaEpaySoap\CurrencyObject
     */
    public function setTextCode($TextCode)
    {
      $this->TextCode = $TextCode;
      return $this;
    }

}
