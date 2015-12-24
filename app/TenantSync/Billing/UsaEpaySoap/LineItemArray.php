<?php

namespace TenantSync\Billing\UsaEpaySoap;

class LineItemArray
{

    /**
     * @var LineItem[] $LineItemArray
     */
    protected $LineItemArray = null;

    /**
     * @param LineItem[] $LineItemArray
     */
    public function __construct(array $LineItemArray)
    {
      $this->LineItemArray = $LineItemArray;
    }

    /**
     * @return LineItem[]
     */
    public function getLineItemArray()
    {
      return $this->LineItemArray;
    }

    /**
     * @param LineItem[] $LineItemArray
     * @return \TenantSync\Billing\UsaEpaySoap\LineItemArray
     */
    public function setLineItemArray(array $LineItemArray)
    {
      $this->LineItemArray = $LineItemArray;
      return $this;
    }

}
