<?php

namespace TenantSync\Billing\UsaEpaySoap;

class ProductInventoryArray
{

    /**
     * @var ProductInventory[] $ProductInventoryArray
     */
    protected $ProductInventoryArray = null;

    /**
     * @param ProductInventory[] $ProductInventoryArray
     */
    public function __construct(array $ProductInventoryArray)
    {
      $this->ProductInventoryArray = $ProductInventoryArray;
    }

    /**
     * @return ProductInventory[]
     */
    public function getProductInventoryArray()
    {
      return $this->ProductInventoryArray;
    }

    /**
     * @param ProductInventory[] $ProductInventoryArray
     * @return \TenantSync\Billing\UsaEpaySoap\ProductInventoryArray
     */
    public function setProductInventoryArray(array $ProductInventoryArray)
    {
      $this->ProductInventoryArray = $ProductInventoryArray;
      return $this;
    }

}
