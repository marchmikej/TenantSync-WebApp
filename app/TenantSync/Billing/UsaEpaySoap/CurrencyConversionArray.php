<?php

namespace TenantSync\Billing\UsaEpaySoap;

class CurrencyConversionArray
{

    /**
     * @var CurrencyConversion[] $CurrencyConversionArray
     */
    protected $CurrencyConversionArray = null;

    /**
     * @param CurrencyConversion[] $CurrencyConversionArray
     */
    public function __construct(array $CurrencyConversionArray)
    {
      $this->CurrencyConversionArray = $CurrencyConversionArray;
    }

    /**
     * @return CurrencyConversion[]
     */
    public function getCurrencyConversionArray()
    {
      return $this->CurrencyConversionArray;
    }

    /**
     * @param CurrencyConversion[] $CurrencyConversionArray
     * @return \TenantSync\Billing\UsaEpaySoap\CurrencyConversionArray
     */
    public function setCurrencyConversionArray(array $CurrencyConversionArray)
    {
      $this->CurrencyConversionArray = $CurrencyConversionArray;
      return $this;
    }

}
