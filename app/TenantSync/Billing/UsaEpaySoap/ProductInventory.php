<?php

namespace TenantSync\Billing\UsaEpaySoap;

class ProductInventory
{

    /**
     * @var string $InventoryLocation
     */
    protected $InventoryLocation = null;

    /**
     * @var string $QtyOnHand
     */
    protected $QtyOnHand = null;

    /**
     * @var string $QtyOnOrder
     */
    protected $QtyOnOrder = null;

    /**
     * @var string $DateAvailable
     */
    protected $DateAvailable = null;

    /**
     * @param string $QtyOnHand
     */
    public function __construct($QtyOnHand)
    {
      $this->QtyOnHand = $QtyOnHand;
    }

    /**
     * @return string
     */
    public function getInventoryLocation()
    {
      return $this->InventoryLocation;
    }

    /**
     * @param string $InventoryLocation
     * @return \TenantSync\Billing\UsaEpaySoap\ProductInventory
     */
    public function setInventoryLocation($InventoryLocation)
    {
      $this->InventoryLocation = $InventoryLocation;
      return $this;
    }

    /**
     * @return string
     */
    public function getQtyOnHand()
    {
      return $this->QtyOnHand;
    }

    /**
     * @param string $QtyOnHand
     * @return \TenantSync\Billing\UsaEpaySoap\ProductInventory
     */
    public function setQtyOnHand($QtyOnHand)
    {
      $this->QtyOnHand = $QtyOnHand;
      return $this;
    }

    /**
     * @return string
     */
    public function getQtyOnOrder()
    {
      return $this->QtyOnOrder;
    }

    /**
     * @param string $QtyOnOrder
     * @return \TenantSync\Billing\UsaEpaySoap\ProductInventory
     */
    public function setQtyOnOrder($QtyOnOrder)
    {
      $this->QtyOnOrder = $QtyOnOrder;
      return $this;
    }

    /**
     * @return string
     */
    public function getDateAvailable()
    {
      return $this->DateAvailable;
    }

    /**
     * @param string $DateAvailable
     * @return \TenantSync\Billing\UsaEpaySoap\ProductInventory
     */
    public function setDateAvailable($DateAvailable)
    {
      $this->DateAvailable = $DateAvailable;
      return $this;
    }

}
