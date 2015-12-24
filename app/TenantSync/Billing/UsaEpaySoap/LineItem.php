<?php

namespace TenantSync\Billing\UsaEpaySoap;

class LineItem
{

    /**
     * @var string $ProductRefNum
     */
    protected $ProductRefNum = null;

    /**
     * @var string $SKU
     */
    protected $SKU = null;

    /**
     * @var string $ProductName
     */
    protected $ProductName = null;

    /**
     * @var string $Description
     */
    protected $Description = null;

    /**
     * @var string $UnitPrice
     */
    protected $UnitPrice = null;

    /**
     * @var string $Qty
     */
    protected $Qty = null;

    /**
     * @var boolean $Taxable
     */
    protected $Taxable = null;

    /**
     * @param string $UnitPrice
     * @param string $Qty
     */
    public function __construct($UnitPrice, $Qty)
    {
      $this->UnitPrice = $UnitPrice;
      $this->Qty = $Qty;
    }

    /**
     * @return string
     */
    public function getProductRefNum()
    {
      return $this->ProductRefNum;
    }

    /**
     * @param string $ProductRefNum
     * @return \TenantSync\Billing\UsaEpaySoap\LineItem
     */
    public function setProductRefNum($ProductRefNum)
    {
      $this->ProductRefNum = $ProductRefNum;
      return $this;
    }

    /**
     * @return string
     */
    public function getSKU()
    {
      return $this->SKU;
    }

    /**
     * @param string $SKU
     * @return \TenantSync\Billing\UsaEpaySoap\LineItem
     */
    public function setSKU($SKU)
    {
      $this->SKU = $SKU;
      return $this;
    }

    /**
     * @return string
     */
    public function getProductName()
    {
      return $this->ProductName;
    }

    /**
     * @param string $ProductName
     * @return \TenantSync\Billing\UsaEpaySoap\LineItem
     */
    public function setProductName($ProductName)
    {
      $this->ProductName = $ProductName;
      return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
      return $this->Description;
    }

    /**
     * @param string $Description
     * @return \TenantSync\Billing\UsaEpaySoap\LineItem
     */
    public function setDescription($Description)
    {
      $this->Description = $Description;
      return $this;
    }

    /**
     * @return string
     */
    public function getUnitPrice()
    {
      return $this->UnitPrice;
    }

    /**
     * @param string $UnitPrice
     * @return \TenantSync\Billing\UsaEpaySoap\LineItem
     */
    public function setUnitPrice($UnitPrice)
    {
      $this->UnitPrice = $UnitPrice;
      return $this;
    }

    /**
     * @return string
     */
    public function getQty()
    {
      return $this->Qty;
    }

    /**
     * @param string $Qty
     * @return \TenantSync\Billing\UsaEpaySoap\LineItem
     */
    public function setQty($Qty)
    {
      $this->Qty = $Qty;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getTaxable()
    {
      return $this->Taxable;
    }

    /**
     * @param boolean $Taxable
     * @return \TenantSync\Billing\UsaEpaySoap\LineItem
     */
    public function setTaxable($Taxable)
    {
      $this->Taxable = $Taxable;
      return $this;
    }

}
