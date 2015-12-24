<?php

namespace TenantSync\Billing\UsaEpaySoap;

class PriceTierArray
{

    /**
     * @var PriceTier[] $PriceTierArray
     */
    protected $PriceTierArray = null;

    /**
     * @param PriceTier[] $PriceTierArray
     */
    public function __construct(array $PriceTierArray)
    {
      $this->PriceTierArray = $PriceTierArray;
    }

    /**
     * @return PriceTier[]
     */
    public function getPriceTierArray()
    {
      return $this->PriceTierArray;
    }

    /**
     * @param PriceTier[] $PriceTierArray
     * @return \TenantSync\Billing\UsaEpaySoap\PriceTierArray
     */
    public function setPriceTierArray(array $PriceTierArray)
    {
      $this->PriceTierArray = $PriceTierArray;
      return $this;
    }

}
