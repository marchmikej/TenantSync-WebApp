<?php

namespace TenantSync\Billing\UsaEpaySoap;

class ProductSearchResult
{

    /**
     * @var ProductArray $Products
     */
    protected $Products = null;

    /**
     * @var int $ProductsMatched
     */
    protected $ProductsMatched = null;

    /**
     * @var int $ProductsReturned
     */
    protected $ProductsReturned = null;

    /**
     * @var int $Limit
     */
    protected $Limit = null;

    /**
     * @var int $StartIndex
     */
    protected $StartIndex = null;

    /**
     * @param ProductArray $Products
     * @param int $ProductsMatched
     * @param int $ProductsReturned
     * @param int $Limit
     * @param int $StartIndex
     */
    public function __construct($Products, $ProductsMatched, $ProductsReturned, $Limit, $StartIndex)
    {
      $this->Products = $Products;
      $this->ProductsMatched = $ProductsMatched;
      $this->ProductsReturned = $ProductsReturned;
      $this->Limit = $Limit;
      $this->StartIndex = $StartIndex;
    }

    /**
     * @return ProductArray
     */
    public function getProducts()
    {
      return $this->Products;
    }

    /**
     * @param ProductArray $Products
     * @return \TenantSync\Billing\UsaEpaySoap\ProductSearchResult
     */
    public function setProducts($Products)
    {
      $this->Products = $Products;
      return $this;
    }

    /**
     * @return int
     */
    public function getProductsMatched()
    {
      return $this->ProductsMatched;
    }

    /**
     * @param int $ProductsMatched
     * @return \TenantSync\Billing\UsaEpaySoap\ProductSearchResult
     */
    public function setProductsMatched($ProductsMatched)
    {
      $this->ProductsMatched = $ProductsMatched;
      return $this;
    }

    /**
     * @return int
     */
    public function getProductsReturned()
    {
      return $this->ProductsReturned;
    }

    /**
     * @param int $ProductsReturned
     * @return \TenantSync\Billing\UsaEpaySoap\ProductSearchResult
     */
    public function setProductsReturned($ProductsReturned)
    {
      $this->ProductsReturned = $ProductsReturned;
      return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
      return $this->Limit;
    }

    /**
     * @param int $Limit
     * @return \TenantSync\Billing\UsaEpaySoap\ProductSearchResult
     */
    public function setLimit($Limit)
    {
      $this->Limit = $Limit;
      return $this;
    }

    /**
     * @return int
     */
    public function getStartIndex()
    {
      return $this->StartIndex;
    }

    /**
     * @param int $StartIndex
     * @return \TenantSync\Billing\UsaEpaySoap\ProductSearchResult
     */
    public function setStartIndex($StartIndex)
    {
      $this->StartIndex = $StartIndex;
      return $this;
    }

}
