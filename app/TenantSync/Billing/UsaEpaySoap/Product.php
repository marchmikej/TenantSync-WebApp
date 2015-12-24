<?php

namespace TenantSync\Billing\UsaEpaySoap;

class Product
{

    /**
     * @var string $ProductRefNum
     */
    protected $ProductRefNum = null;

    /**
     * @var string $ProductID
     */
    protected $ProductID = null;

    /**
     * @var string $SKU
     */
    protected $SKU = null;

    /**
     * @var string $UPC
     */
    protected $UPC = null;

    /**
     * @var string $Category
     */
    protected $Category = null;

    /**
     * @var boolean $Enabled
     */
    protected $Enabled = null;

    /**
     * @var string $Name
     */
    protected $Name = null;

    /**
     * @var string $Description
     */
    protected $Description = null;

    /**
     * @var string $Model
     */
    protected $Model = null;

    /**
     * @var float $Weight
     */
    protected $Weight = null;

    /**
     * @var float $ShipWeight
     */
    protected $ShipWeight = null;

    /**
     * @var float $Price
     */
    protected $Price = null;

    /**
     * @var float $WholesalePrice
     */
    protected $WholesalePrice = null;

    /**
     * @var float $ListPrice
     */
    protected $ListPrice = null;

    /**
     * @var string $DateAvailable
     */
    protected $DateAvailable = null;

    /**
     * @var string $Manufacturer
     */
    protected $Manufacturer = null;

    /**
     * @var boolean $PhysicalGood
     */
    protected $PhysicalGood = null;

    /**
     * @var string $TaxClass
     */
    protected $TaxClass = null;

    /**
     * @var int $MinQuantity
     */
    protected $MinQuantity = null;

    /**
     * @var string $ImageURL
     */
    protected $ImageURL = null;

    /**
     * @var string $URL
     */
    protected $URL = null;

    /**
     * @var \DateTime $Created
     */
    protected $Created = null;

    /**
     * @var \DateTime $Modified
     */
    protected $Modified = null;

    /**
     * @var ProductInventoryArray $Inventory
     */
    protected $Inventory = null;

    /**
     * @var PriceTierArray $PriceTiers
     */
    protected $PriceTiers = null;

    /**
     * @param string $ProductID
     * @param string $Category
     * @param string $Name
     * @param float $Price
     */
    public function __construct($ProductID, $Category, $Name, $Price)
    {
      $this->ProductID = $ProductID;
      $this->Category = $Category;
      $this->Name = $Name;
      $this->Price = $Price;
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
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setProductRefNum($ProductRefNum)
    {
      $this->ProductRefNum = $ProductRefNum;
      return $this;
    }

    /**
     * @return string
     */
    public function getProductID()
    {
      return $this->ProductID;
    }

    /**
     * @param string $ProductID
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setProductID($ProductID)
    {
      $this->ProductID = $ProductID;
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
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setSKU($SKU)
    {
      $this->SKU = $SKU;
      return $this;
    }

    /**
     * @return string
     */
    public function getUPC()
    {
      return $this->UPC;
    }

    /**
     * @param string $UPC
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setUPC($UPC)
    {
      $this->UPC = $UPC;
      return $this;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
      return $this->Category;
    }

    /**
     * @param string $Category
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setCategory($Category)
    {
      $this->Category = $Category;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getEnabled()
    {
      return $this->Enabled;
    }

    /**
     * @param boolean $Enabled
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setEnabled($Enabled)
    {
      $this->Enabled = $Enabled;
      return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
      return $this->Name;
    }

    /**
     * @param string $Name
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setName($Name)
    {
      $this->Name = $Name;
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
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setDescription($Description)
    {
      $this->Description = $Description;
      return $this;
    }

    /**
     * @return string
     */
    public function getModel()
    {
      return $this->Model;
    }

    /**
     * @param string $Model
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setModel($Model)
    {
      $this->Model = $Model;
      return $this;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
      return $this->Weight;
    }

    /**
     * @param float $Weight
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setWeight($Weight)
    {
      $this->Weight = $Weight;
      return $this;
    }

    /**
     * @return float
     */
    public function getShipWeight()
    {
      return $this->ShipWeight;
    }

    /**
     * @param float $ShipWeight
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setShipWeight($ShipWeight)
    {
      $this->ShipWeight = $ShipWeight;
      return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
      return $this->Price;
    }

    /**
     * @param float $Price
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setPrice($Price)
    {
      $this->Price = $Price;
      return $this;
    }

    /**
     * @return float
     */
    public function getWholesalePrice()
    {
      return $this->WholesalePrice;
    }

    /**
     * @param float $WholesalePrice
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setWholesalePrice($WholesalePrice)
    {
      $this->WholesalePrice = $WholesalePrice;
      return $this;
    }

    /**
     * @return float
     */
    public function getListPrice()
    {
      return $this->ListPrice;
    }

    /**
     * @param float $ListPrice
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setListPrice($ListPrice)
    {
      $this->ListPrice = $ListPrice;
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
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setDateAvailable($DateAvailable)
    {
      $this->DateAvailable = $DateAvailable;
      return $this;
    }

    /**
     * @return string
     */
    public function getManufacturer()
    {
      return $this->Manufacturer;
    }

    /**
     * @param string $Manufacturer
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setManufacturer($Manufacturer)
    {
      $this->Manufacturer = $Manufacturer;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getPhysicalGood()
    {
      return $this->PhysicalGood;
    }

    /**
     * @param boolean $PhysicalGood
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setPhysicalGood($PhysicalGood)
    {
      $this->PhysicalGood = $PhysicalGood;
      return $this;
    }

    /**
     * @return string
     */
    public function getTaxClass()
    {
      return $this->TaxClass;
    }

    /**
     * @param string $TaxClass
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setTaxClass($TaxClass)
    {
      $this->TaxClass = $TaxClass;
      return $this;
    }

    /**
     * @return int
     */
    public function getMinQuantity()
    {
      return $this->MinQuantity;
    }

    /**
     * @param int $MinQuantity
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setMinQuantity($MinQuantity)
    {
      $this->MinQuantity = $MinQuantity;
      return $this;
    }

    /**
     * @return string
     */
    public function getImageURL()
    {
      return $this->ImageURL;
    }

    /**
     * @param string $ImageURL
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setImageURL($ImageURL)
    {
      $this->ImageURL = $ImageURL;
      return $this;
    }

    /**
     * @return string
     */
    public function getURL()
    {
      return $this->URL;
    }

    /**
     * @param string $URL
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setURL($URL)
    {
      $this->URL = $URL;
      return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
      if ($this->Created == null) {
        return null;
      } else {
        try {
          return new \DateTime($this->Created);
        } catch (\Exception $e) {
          return false;
        }
      }
    }

    /**
     * @param \DateTime $Created
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setCreated(\DateTime $Created = null)
    {
      if ($Created == null) {
       $this->Created = null;
      } else {
        $this->Created = $Created->format(\DateTime::ATOM);
      }
      return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModified()
    {
      if ($this->Modified == null) {
        return null;
      } else {
        try {
          return new \DateTime($this->Modified);
        } catch (\Exception $e) {
          return false;
        }
      }
    }

    /**
     * @param \DateTime $Modified
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setModified(\DateTime $Modified = null)
    {
      if ($Modified == null) {
       $this->Modified = null;
      } else {
        $this->Modified = $Modified->format(\DateTime::ATOM);
      }
      return $this;
    }

    /**
     * @return ProductInventoryArray
     */
    public function getInventory()
    {
      return $this->Inventory;
    }

    /**
     * @param ProductInventoryArray $Inventory
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setInventory($Inventory)
    {
      $this->Inventory = $Inventory;
      return $this;
    }

    /**
     * @return PriceTierArray
     */
    public function getPriceTiers()
    {
      return $this->PriceTiers;
    }

    /**
     * @param PriceTierArray $PriceTiers
     * @return \TenantSync\Billing\UsaEpaySoap\Product
     */
    public function setPriceTiers($PriceTiers)
    {
      $this->PriceTiers = $PriceTiers;
      return $this;
    }

}
