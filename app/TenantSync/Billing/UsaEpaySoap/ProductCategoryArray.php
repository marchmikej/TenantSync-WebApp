<?php

namespace TenantSync\Billing\UsaEpaySoap;

class ProductCategoryArray
{

    /**
     * @var ProductCategory[] $ProductCategoryArray
     */
    protected $ProductCategoryArray = null;

    /**
     * @param ProductCategory[] $ProductCategoryArray
     */
    public function __construct(array $ProductCategoryArray)
    {
      $this->ProductCategoryArray = $ProductCategoryArray;
    }

    /**
     * @return ProductCategory[]
     */
    public function getProductCategoryArray()
    {
      return $this->ProductCategoryArray;
    }

    /**
     * @param ProductCategory[] $ProductCategoryArray
     * @return \TenantSync\Billing\UsaEpaySoap\ProductCategoryArray
     */
    public function setProductCategoryArray(array $ProductCategoryArray)
    {
      $this->ProductCategoryArray = $ProductCategoryArray;
      return $this;
    }

}
