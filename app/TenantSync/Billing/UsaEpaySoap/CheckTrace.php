<?php

namespace TenantSync\Billing\UsaEpaySoap;

class CheckTrace
{

    /**
     * @var string $Status
     */
    protected $Status = null;

    /**
     * @var string $StatusCode
     */
    protected $StatusCode = null;

    /**
     * @var string $BankNote
     */
    protected $BankNote = null;

    /**
     * @var string $Effective
     */
    protected $Effective = null;

    /**
     * @var string $Processed
     */
    protected $Processed = null;

    /**
     * @var string $Returned
     */
    protected $Returned = null;

    /**
     * @var string $ReturnCode
     */
    protected $ReturnCode = null;

    /**
     * @var string $Reason
     */
    protected $Reason = null;

    /**
     * @var string $Settled
     */
    protected $Settled = null;

    /**
     * @var string $TrackingNum
     */
    protected $TrackingNum = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return string
     */
    public function getStatus()
    {
      return $this->Status;
    }

    /**
     * @param string $Status
     * @return \TenantSync\Billing\UsaEpaySoap\CheckTrace
     */
    public function setStatus($Status)
    {
      $this->Status = $Status;
      return $this;
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
      return $this->StatusCode;
    }

    /**
     * @param string $StatusCode
     * @return \TenantSync\Billing\UsaEpaySoap\CheckTrace
     */
    public function setStatusCode($StatusCode)
    {
      $this->StatusCode = $StatusCode;
      return $this;
    }

    /**
     * @return string
     */
    public function getBankNote()
    {
      return $this->BankNote;
    }

    /**
     * @param string $BankNote
     * @return \TenantSync\Billing\UsaEpaySoap\CheckTrace
     */
    public function setBankNote($BankNote)
    {
      $this->BankNote = $BankNote;
      return $this;
    }

    /**
     * @return string
     */
    public function getEffective()
    {
      return $this->Effective;
    }

    /**
     * @param string $Effective
     * @return \TenantSync\Billing\UsaEpaySoap\CheckTrace
     */
    public function setEffective($Effective)
    {
      $this->Effective = $Effective;
      return $this;
    }

    /**
     * @return string
     */
    public function getProcessed()
    {
      return $this->Processed;
    }

    /**
     * @param string $Processed
     * @return \TenantSync\Billing\UsaEpaySoap\CheckTrace
     */
    public function setProcessed($Processed)
    {
      $this->Processed = $Processed;
      return $this;
    }

    /**
     * @return string
     */
    public function getReturned()
    {
      return $this->Returned;
    }

    /**
     * @param string $Returned
     * @return \TenantSync\Billing\UsaEpaySoap\CheckTrace
     */
    public function setReturned($Returned)
    {
      $this->Returned = $Returned;
      return $this;
    }

    /**
     * @return string
     */
    public function getReturnCode()
    {
      return $this->ReturnCode;
    }

    /**
     * @param string $ReturnCode
     * @return \TenantSync\Billing\UsaEpaySoap\CheckTrace
     */
    public function setReturnCode($ReturnCode)
    {
      $this->ReturnCode = $ReturnCode;
      return $this;
    }

    /**
     * @return string
     */
    public function getReason()
    {
      return $this->Reason;
    }

    /**
     * @param string $Reason
     * @return \TenantSync\Billing\UsaEpaySoap\CheckTrace
     */
    public function setReason($Reason)
    {
      $this->Reason = $Reason;
      return $this;
    }

    /**
     * @return string
     */
    public function getSettled()
    {
      return $this->Settled;
    }

    /**
     * @param string $Settled
     * @return \TenantSync\Billing\UsaEpaySoap\CheckTrace
     */
    public function setSettled($Settled)
    {
      $this->Settled = $Settled;
      return $this;
    }

    /**
     * @return string
     */
    public function getTrackingNum()
    {
      return $this->TrackingNum;
    }

    /**
     * @param string $TrackingNum
     * @return \TenantSync\Billing\UsaEpaySoap\CheckTrace
     */
    public function setTrackingNum($TrackingNum)
    {
      $this->TrackingNum = $TrackingNum;
      return $this;
    }

}
