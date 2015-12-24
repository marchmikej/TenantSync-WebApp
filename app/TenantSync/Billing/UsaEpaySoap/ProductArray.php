<?php

namespace TenantSync\Billing\UsaEpaySoap;

class ProductArray
{

    /**
     * @var Product[] $ProductArray
     */
    protected $ProductArray = null;

    /**
     * @param Product[] $ProductArray
     */
    public function __construct(array $ProductArray)
    {
      $this->ProductArray = $ProductArray;
    }

    /**
     * @return Product[]
     */
    public function getProductArray()
    {
      return $this->ProductArray;
    }

    /**
     * @param Product[] $ProductArray
     * @return \TenantSync\Billing\UsaEpaySoap\ProductArray
     */
    public function setProductArray(array $ProductArray)
    {
      $this->ProductArray = $ProductArray;
      return $this;
    }

}
