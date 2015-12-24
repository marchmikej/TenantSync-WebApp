<?php

namespace TenantSync\Billing\UsaEpaySoap;

class CheckData
{

    /**
     * @var string $Account
     */
    protected $Account = null;

    /**
     * @var string $AccountType
     */
    protected $AccountType = null;

    /**
     * @var int $CheckNumber
     */
    protected $CheckNumber = null;

    /**
     * @var string $DriversLicense
     */
    protected $DriversLicense = null;

    /**
     * @var string $DriversLicenseState
     */
    protected $DriversLicenseState = null;

    /**
     * @var string $RecordType
     */
    protected $RecordType = null;

    /**
     * @var string $Routing
     */
    protected $Routing = null;

    /**
     * @var string $AuxOnUS
     */
    protected $AuxOnUS = null;

    /**
     * @var string $EpcCode
     */
    protected $EpcCode = null;

    /**
     * @var string $FrontImage
     */
    protected $FrontImage = null;

    /**
     * @var string $BackImage
     */
    protected $BackImage = null;

    /**
     * @param string $Account
     * @param string $Routing
     */
    public function __construct($Account, $Routing)
    {
      $this->Account = $Account;
      $this->Routing = $Routing;
    }

    /**
     * @return string
     */
    public function getAccount()
    {
      return $this->Account;
    }

    /**
     * @param string $Account
     * @return \TenantSync\Billing\UsaEpaySoap\CheckData
     */
    public function setAccount($Account)
    {
      $this->Account = $Account;
      return $this;
    }

    /**
     * @return string
     */
    public function getAccountType()
    {
      return $this->AccountType;
    }

    /**
     * @param string $AccountType
     * @return \TenantSync\Billing\UsaEpaySoap\CheckData
     */
    public function setAccountType($AccountType)
    {
      $this->AccountType = $AccountType;
      return $this;
    }

    /**
     * @return int
     */
    public function getCheckNumber()
    {
      return $this->CheckNumber;
    }

    /**
     * @param int $CheckNumber
     * @return \TenantSync\Billing\UsaEpaySoap\CheckData
     */
    public function setCheckNumber($CheckNumber)
    {
      $this->CheckNumber = $CheckNumber;
      return $this;
    }

    /**
     * @return string
     */
    public function getDriversLicense()
    {
      return $this->DriversLicense;
    }

    /**
     * @param string $DriversLicense
     * @return \TenantSync\Billing\UsaEpaySoap\CheckData
     */
    public function setDriversLicense($DriversLicense)
    {
      $this->DriversLicense = $DriversLicense;
      return $this;
    }

    /**
     * @return string
     */
    public function getDriversLicenseState()
    {
      return $this->DriversLicenseState;
    }

    /**
     * @param string $DriversLicenseState
     * @return \TenantSync\Billing\UsaEpaySoap\CheckData
     */
    public function setDriversLicenseState($DriversLicenseState)
    {
      $this->DriversLicenseState = $DriversLicenseState;
      return $this;
    }

    /**
     * @return string
     */
    public function getRecordType()
    {
      return $this->RecordType;
    }

    /**
     * @param string $RecordType
     * @return \TenantSync\Billing\UsaEpaySoap\CheckData
     */
    public function setRecordType($RecordType)
    {
      $this->RecordType = $RecordType;
      return $this;
    }

    /**
     * @return string
     */
    public function getRouting()
    {
      return $this->Routing;
    }

    /**
     * @param string $Routing
     * @return \TenantSync\Billing\UsaEpaySoap\CheckData
     */
    public function setRouting($Routing)
    {
      $this->Routing = $Routing;
      return $this;
    }

    /**
     * @return string
     */
    public function getAuxOnUS()
    {
      return $this->AuxOnUS;
    }

    /**
     * @param string $AuxOnUS
     * @return \TenantSync\Billing\UsaEpaySoap\CheckData
     */
    public function setAuxOnUS($AuxOnUS)
    {
      $this->AuxOnUS = $AuxOnUS;
      return $this;
    }

    /**
     * @return string
     */
    public function getEpcCode()
    {
      return $this->EpcCode;
    }

    /**
     * @param string $EpcCode
     * @return \TenantSync\Billing\UsaEpaySoap\CheckData
     */
    public function setEpcCode($EpcCode)
    {
      $this->EpcCode = $EpcCode;
      return $this;
    }

    /**
     * @return string
     */
    public function getFrontImage()
    {
      return $this->FrontImage;
    }

    /**
     * @param string $FrontImage
     * @return \TenantSync\Billing\UsaEpaySoap\CheckData
     */
    public function setFrontImage($FrontImage)
    {
      $this->FrontImage = $FrontImage;
      return $this;
    }

    /**
     * @return string
     */
    public function getBackImage()
    {
      return $this->BackImage;
    }

    /**
     * @param string $BackImage
     * @return \TenantSync\Billing\UsaEpaySoap\CheckData
     */
    public function setBackImage($BackImage)
    {
      $this->BackImage = $BackImage;
      return $this;
    }

}
