<?php

namespace TenantSync\Billing\UsaEpaySoap;

class RecurringBilling
{

    /**
     * @var float $Amount
     */
    protected $Amount = null;

    /**
     * @var boolean $Enabled
     */
    protected $Enabled = null;

    /**
     * @var string $Expire
     */
    protected $Expire = null;

    /**
     * @var string $Next
     */
    protected $Next = null;

    /**
     * @var int $NumLeft
     */
    protected $NumLeft = null;

    /**
     * @var string $Schedule
     */
    protected $Schedule = null;

    /**
     * @param float $Amount
     * @param boolean $Enabled
     * @param string $Next
     * @param int $NumLeft
     * @param string $Schedule
     */
    public function __construct($Amount, $Enabled, $Next, $NumLeft, $Schedule)
    {
      $this->Amount = $Amount;
      $this->Enabled = $Enabled;
      $this->Next = $Next;
      $this->NumLeft = $NumLeft;
      $this->Schedule = $Schedule;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
      return $this->Amount;
    }

    /**
     * @param float $Amount
     * @return \TenantSync\Billing\UsaEpaySoap\RecurringBilling
     */
    public function setAmount($Amount)
    {
      $this->Amount = $Amount;
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
     * @return \TenantSync\Billing\UsaEpaySoap\RecurringBilling
     */
    public function setEnabled($Enabled)
    {
      $this->Enabled = $Enabled;
      return $this;
    }

    /**
     * @return string
     */
    public function getExpire()
    {
      return $this->Expire;
    }

    /**
     * @param string $Expire
     * @return \TenantSync\Billing\UsaEpaySoap\RecurringBilling
     */
    public function setExpire($Expire)
    {
      $this->Expire = $Expire;
      return $this;
    }

    /**
     * @return string
     */
    public function getNext()
    {
      return $this->Next;
    }

    /**
     * @param string $Next
     * @return \TenantSync\Billing\UsaEpaySoap\RecurringBilling
     */
    public function setNext($Next)
    {
      $this->Next = $Next;
      return $this;
    }

    /**
     * @return int
     */
    public function getNumLeft()
    {
      return $this->NumLeft;
    }

    /**
     * @param int $NumLeft
     * @return \TenantSync\Billing\UsaEpaySoap\RecurringBilling
     */
    public function setNumLeft($NumLeft)
    {
      $this->NumLeft = $NumLeft;
      return $this;
    }

    /**
     * @return string
     */
    public function getSchedule()
    {
      return $this->Schedule;
    }

    /**
     * @param string $Schedule
     * @return \TenantSync\Billing\UsaEpaySoap\RecurringBilling
     */
    public function setSchedule($Schedule)
    {
      $this->Schedule = $Schedule;
      return $this;
    }

}
