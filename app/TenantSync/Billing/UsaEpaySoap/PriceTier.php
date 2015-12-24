<?php

namespace TenantSync\Billing\UsaEpaySoap;

class PriceTier
{

    /**
     * @var string $Qty
     */
    protected $Qty = null;

    /**
     * @var string $Price
     */
    protected $Price = null;

    /**
     * @var string $CustomerTier
     */
    protected $CustomerTier = null;

    /**
     * @param string $Qty
     * @param string $Price
     */
    public function __construct($Qty, $Price)
    {
      $this->Qty = $Qty;
      $this->Price = $Price;
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
     * @return \TenantSync\Billing\UsaEpaySoap\PriceTier
     */
    public function setQty($Qty)
    {
      $this->Qty = $Qty;
      return $this;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
      return $this->Price;
    }

    /**
     * @param string $Price
     * @return \TenantSync\Billing\UsaEpaySoap\PriceTier
     */
    public function setPrice($Price)
    {
      $this->Price = $Price;
      return $this;
    }

    /**
     * @return string
     */
    public function getCustomerTier()
    {
      return $this->CustomerTier;
    }

    /**
     * @param string $CustomerTier
     * @return \TenantSync\Billing\UsaEpaySoap\PriceTier
     */
    public function setCustomerTier($CustomerTier)
    {
      $this->CustomerTier = $CustomerTier;
      return $this;
    }

}
