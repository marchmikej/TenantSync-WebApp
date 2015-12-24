<?php

namespace TenantSync\Billing\UsaEpaySoap;

class BankArray
{

    /**
     * @var Bank[] $BankArray
     */
    protected $BankArray = null;

    /**
     * @param Bank[] $BankArray
     */
    public function __construct(array $BankArray)
    {
      $this->BankArray = $BankArray;
    }

    /**
     * @return Bank[]
     */
    public function getBankArray()
    {
      return $this->BankArray;
    }

    /**
     * @param Bank[] $BankArray
     * @return \TenantSync\Billing\UsaEpaySoap\BankArray
     */
    public function setBankArray(array $BankArray)
    {
      $this->BankArray = $BankArray;
      return $this;
    }

}
