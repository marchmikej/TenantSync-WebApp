<?php

namespace TenantSync\Billing\UsaEpaySoap;

class ProductCategory
{

    /**
     * @var string $ProductCategoryRefNum
     */
    protected $ProductCategoryRefNum = null;

    /**
     * @var string $Name
     */
    protected $Name = null;

    /**
     * @var \DateTime $Created
     */
    protected $Created = null;

    /**
     * @var \DateTime $Modified
     */
    protected $Modified = null;

    /**
     * @param string $Name
     */
    public function __construct($Name)
    {
      $this->Name = $Name;
    }

    /**
     * @return string
     */
    public function getProductCategoryRefNum()
    {
      return $this->ProductCategoryRefNum;
    }

    /**
     * @param string $ProductCategoryRefNum
     * @return \TenantSync\Billing\UsaEpaySoap\ProductCategory
     */
    public function setProductCategoryRefNum($ProductCategoryRefNum)
    {
      $this->ProductCategoryRefNum = $ProductCategoryRefNum;
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
     * @return \TenantSync\Billing\UsaEpaySoap\ProductCategory
     */
    public function setName($Name)
    {
      $this->Name = $Name;
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
     * @return \TenantSync\Billing\UsaEpaySoap\ProductCategory
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
     * @return \TenantSync\Billing\UsaEpaySoap\ProductCategory
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

}
