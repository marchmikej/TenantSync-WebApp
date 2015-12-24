<?php

namespace TenantSync\Billing\UsaEpaySoap;

class PaymentMethod
{

    /**
     * @var string $MethodType
     */
    protected $MethodType = null;

    /**
     * @var int $MethodID
     */
    protected $MethodID = null;

    /**
     * @var string $MethodName
     */
    protected $MethodName = null;

    /**
     * @var int $SecondarySort
     */
    protected $SecondarySort = null;

    /**
     * @var \DateTime $Created
     */
    protected $Created = null;

    /**
     * @var \DateTime $Modified
     */
    protected $Modified = null;

    /**
     * @var string $Account
     */
    protected $Account = null;

    /**
     * @var string $AccountType
     */
    protected $AccountType = null;

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
     * @var string $AvsStreet
     */
    protected $AvsStreet = null;

    /**
     * @var string $AvsZip
     */
    protected $AvsZip = null;

    /**
     * @var string $CardCode
     */
    protected $CardCode = null;

    /**
     * @var string $CardExpiration
     */
    protected $CardExpiration = null;

    /**
     * @var string $CardNumber
     */
    protected $CardNumber = null;

    /**
     * @var string $CardType
     */
    protected $CardType = null;

    /**
     * @var float $Balance
     */
    protected $Balance = null;

    /**
     * @var float $MaxBalance
     */
    protected $MaxBalance = null;

    /**
     * @var string $AutoReload
     */
    protected $AutoReload = null;

    /**
     * @var string $ReloadSchedule
     */
    protected $ReloadSchedule = null;

    /**
     * @var string $ReloadThreshold
     */
    protected $ReloadThreshold = null;

    /**
     * @var string $ReloadAmount
     */
    protected $ReloadAmount = null;

    /**
     * @var int $ReloadMethodID
     */
    protected $ReloadMethodID = null;

    /**
     * @param string $MethodName
     * @param int $SecondarySort
     */
    public function __construct($MethodName, $SecondarySort)
    {
      $this->MethodName = $MethodName;
      $this->SecondarySort = $SecondarySort;
    }

    /**
     * @return string
     */
    public function getMethodType()
    {
      return $this->MethodType;
    }

    /**
     * @param string $MethodType
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setMethodType($MethodType)
    {
      $this->MethodType = $MethodType;
      return $this;
    }

    /**
     * @return int
     */
    public function getMethodID()
    {
      return $this->MethodID;
    }

    /**
     * @param int $MethodID
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setMethodID($MethodID)
    {
      $this->MethodID = $MethodID;
      return $this;
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
      return $this->MethodName;
    }

    /**
     * @param string $MethodName
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setMethodName($MethodName)
    {
      $this->MethodName = $MethodName;
      return $this;
    }

    /**
     * @return int
     */
    public function getSecondarySort()
    {
      return $this->SecondarySort;
    }

    /**
     * @param int $SecondarySort
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setSecondarySort($SecondarySort)
    {
      $this->SecondarySort = $SecondarySort;
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
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
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
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
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
     * @return string
     */
    public function getAccount()
    {
      return $this->Account;
    }

    /**
     * @param string $Account
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
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
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setAccountType($AccountType)
    {
      $this->AccountType = $AccountType;
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
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
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
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
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
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
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
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setRouting($Routing)
    {
      $this->Routing = $Routing;
      return $this;
    }

    /**
     * @return string
     */
    public function getAvsStreet()
    {
      return $this->AvsStreet;
    }

    /**
     * @param string $AvsStreet
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setAvsStreet($AvsStreet)
    {
      $this->AvsStreet = $AvsStreet;
      return $this;
    }

    /**
     * @return string
     */
    public function getAvsZip()
    {
      return $this->AvsZip;
    }

    /**
     * @param string $AvsZip
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setAvsZip($AvsZip)
    {
      $this->AvsZip = $AvsZip;
      return $this;
    }

    /**
     * @return string
     */
    public function getCardCode()
    {
      return $this->CardCode;
    }

    /**
     * @param string $CardCode
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setCardCode($CardCode)
    {
      $this->CardCode = $CardCode;
      return $this;
    }

    /**
     * @return string
     */
    public function getCardExpiration()
    {
      return $this->CardExpiration;
    }

    /**
     * @param string $CardExpiration
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setCardExpiration($CardExpiration)
    {
      $this->CardExpiration = $CardExpiration;
      return $this;
    }

    /**
     * @return string
     */
    public function getCardNumber()
    {
      return $this->CardNumber;
    }

    /**
     * @param string $CardNumber
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setCardNumber($CardNumber)
    {
      $this->CardNumber = $CardNumber;
      return $this;
    }

    /**
     * @return string
     */
    public function getCardType()
    {
      return $this->CardType;
    }

    /**
     * @param string $CardType
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setCardType($CardType)
    {
      $this->CardType = $CardType;
      return $this;
    }

    /**
     * @return float
     */
    public function getBalance()
    {
      return $this->Balance;
    }

    /**
     * @param float $Balance
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setBalance($Balance)
    {
      $this->Balance = $Balance;
      return $this;
    }

    /**
     * @return float
     */
    public function getMaxBalance()
    {
      return $this->MaxBalance;
    }

    /**
     * @param float $MaxBalance
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setMaxBalance($MaxBalance)
    {
      $this->MaxBalance = $MaxBalance;
      return $this;
    }

    /**
     * @return string
     */
    public function getAutoReload()
    {
      return $this->AutoReload;
    }

    /**
     * @param string $AutoReload
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setAutoReload($AutoReload)
    {
      $this->AutoReload = $AutoReload;
      return $this;
    }

    /**
     * @return string
     */
    public function getReloadSchedule()
    {
      return $this->ReloadSchedule;
    }

    /**
     * @param string $ReloadSchedule
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setReloadSchedule($ReloadSchedule)
    {
      $this->ReloadSchedule = $ReloadSchedule;
      return $this;
    }

    /**
     * @return string
     */
    public function getReloadThreshold()
    {
      return $this->ReloadThreshold;
    }

    /**
     * @param string $ReloadThreshold
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setReloadThreshold($ReloadThreshold)
    {
      $this->ReloadThreshold = $ReloadThreshold;
      return $this;
    }

    /**
     * @return string
     */
    public function getReloadAmount()
    {
      return $this->ReloadAmount;
    }

    /**
     * @param string $ReloadAmount
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setReloadAmount($ReloadAmount)
    {
      $this->ReloadAmount = $ReloadAmount;
      return $this;
    }

    /**
     * @return int
     */
    public function getReloadMethodID()
    {
      return $this->ReloadMethodID;
    }

    /**
     * @param int $ReloadMethodID
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethod
     */
    public function setReloadMethodID($ReloadMethodID)
    {
      $this->ReloadMethodID = $ReloadMethodID;
      return $this;
    }

}
