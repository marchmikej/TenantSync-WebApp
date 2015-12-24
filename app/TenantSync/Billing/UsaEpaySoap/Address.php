<?php

namespace TenantSync\Billing\UsaEpaySoap;

class Address
{

    /**
     * @var string $City
     */
    protected $City = null;

    /**
     * @var string $Company
     */
    protected $Company = null;

    /**
     * @var string $Country
     */
    protected $Country = null;

    /**
     * @var string $Email
     */
    protected $Email = null;

    /**
     * @var string $Fax
     */
    protected $Fax = null;

    /**
     * @var string $FirstName
     */
    protected $FirstName = null;

    /**
     * @var string $LastName
     */
    protected $LastName = null;

    /**
     * @var string $Phone
     */
    protected $Phone = null;

    /**
     * @var string $State
     */
    protected $State = null;

    /**
     * @var string $Street
     */
    protected $Street = null;

    /**
     * @var string $Street2
     */
    protected $Street2 = null;

    /**
     * @var string $Zip
     */
    protected $Zip = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return string
     */
    public function getCity()
    {
      return $this->City;
    }

    /**
     * @param string $City
     * @return \TenantSync\Billing\UsaEpaySoap\Address
     */
    public function setCity($City)
    {
      $this->City = $City;
      return $this;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
      return $this->Company;
    }

    /**
     * @param string $Company
     * @return \TenantSync\Billing\UsaEpaySoap\Address
     */
    public function setCompany($Company)
    {
      $this->Company = $Company;
      return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
      return $this->Country;
    }

    /**
     * @param string $Country
     * @return \TenantSync\Billing\UsaEpaySoap\Address
     */
    public function setCountry($Country)
    {
      $this->Country = $Country;
      return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
      return $this->Email;
    }

    /**
     * @param string $Email
     * @return \TenantSync\Billing\UsaEpaySoap\Address
     */
    public function setEmail($Email)
    {
      $this->Email = $Email;
      return $this;
    }

    /**
     * @return string
     */
    public function getFax()
    {
      return $this->Fax;
    }

    /**
     * @param string $Fax
     * @return \TenantSync\Billing\UsaEpaySoap\Address
     */
    public function setFax($Fax)
    {
      $this->Fax = $Fax;
      return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
      return $this->FirstName;
    }

    /**
     * @param string $FirstName
     * @return \TenantSync\Billing\UsaEpaySoap\Address
     */
    public function setFirstName($FirstName)
    {
      $this->FirstName = $FirstName;
      return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
      return $this->LastName;
    }

    /**
     * @param string $LastName
     * @return \TenantSync\Billing\UsaEpaySoap\Address
     */
    public function setLastName($LastName)
    {
      $this->LastName = $LastName;
      return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
      return $this->Phone;
    }

    /**
     * @param string $Phone
     * @return \TenantSync\Billing\UsaEpaySoap\Address
     */
    public function setPhone($Phone)
    {
      $this->Phone = $Phone;
      return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
      return $this->State;
    }

    /**
     * @param string $State
     * @return \TenantSync\Billing\UsaEpaySoap\Address
     */
    public function setState($State)
    {
      $this->State = $State;
      return $this;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
      return $this->Street;
    }

    /**
     * @param string $Street
     * @return \TenantSync\Billing\UsaEpaySoap\Address
     */
    public function setStreet($Street)
    {
      $this->Street = $Street;
      return $this;
    }

    /**
     * @return string
     */
    public function getStreet2()
    {
      return $this->Street2;
    }

    /**
     * @param string $Street2
     * @return \TenantSync\Billing\UsaEpaySoap\Address
     */
    public function setStreet2($Street2)
    {
      $this->Street2 = $Street2;
      return $this;
    }

    /**
     * @return string
     */
    public function getZip()
    {
      return $this->Zip;
    }

    /**
     * @param string $Zip
     * @return \TenantSync\Billing\UsaEpaySoap\Address
     */
    public function setZip($Zip)
    {
      $this->Zip = $Zip;
      return $this;
    }

}
