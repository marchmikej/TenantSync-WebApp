<?php

namespace TenantSync\Billing\UsaEpaySoap;

class CurrencyObjectArray
{

    /**
     * @var CurrencyObject[] $CurrencyObjectArray
     */
    protected $CurrencyObjectArray = null;

    /**
     * @param CurrencyObject[] $CurrencyObjectArray
     */
    public function __construct(array $CurrencyObjectArray)
    {
      $this->CurrencyObjectArray = $CurrencyObjectArray;
    }

    /**
     * @return CurrencyObject[]
     */
    public function getCurrencyObjectArray()
    {
      return $this->CurrencyObjectArray;
    }

    /**
     * @param CurrencyObject[] $CurrencyObjectArray
     * @return \TenantSync\Billing\UsaEpaySoap\CurrencyObjectArray
     */
    public function setCurrencyObjectArray(array $CurrencyObjectArray)
    {
      $this->CurrencyObjectArray = $CurrencyObjectArray;
      return $this;
    }

}
