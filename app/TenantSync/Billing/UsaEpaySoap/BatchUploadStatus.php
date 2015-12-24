<?php

namespace TenantSync\Billing\UsaEpaySoap;

class BatchUploadStatus
{

    /**
     * @var int $Approved
     */
    protected $Approved = null;

    /**
     * @var int $UploadRefNum
     */
    protected $UploadRefNum = null;

    /**
     * @var int $Declined
     */
    protected $Declined = null;

    /**
     * @var int $Errors
     */
    protected $Errors = null;

    /**
     * @var string $Finished
     */
    protected $Finished = null;

    /**
     * @var int $Remaining
     */
    protected $Remaining = null;

    /**
     * @var string $Started
     */
    protected $Started = null;

    /**
     * @var string $Status
     */
    protected $Status = null;

    /**
     * @var int $Transactions
     */
    protected $Transactions = null;

    /**
     * @param int $Approved
     * @param int $UploadRefNum
     * @param int $Declined
     * @param int $Errors
     * @param string $Finished
     * @param int $Remaining
     * @param string $Started
     * @param string $Status
     * @param int $Transactions
     */
    public function __construct($Approved, $UploadRefNum, $Declined, $Errors, $Finished, $Remaining, $Started, $Status, $Transactions)
    {
      $this->Approved = $Approved;
      $this->UploadRefNum = $UploadRefNum;
      $this->Declined = $Declined;
      $this->Errors = $Errors;
      $this->Finished = $Finished;
      $this->Remaining = $Remaining;
      $this->Started = $Started;
      $this->Status = $Status;
      $this->Transactions = $Transactions;
    }

    /**
     * @return int
     */
    public function getApproved()
    {
      return $this->Approved;
    }

    /**
     * @param int $Approved
     * @return \TenantSync\Billing\UsaEpaySoap\BatchUploadStatus
     */
    public function setApproved($Approved)
    {
      $this->Approved = $Approved;
      return $this;
    }

    /**
     * @return int
     */
    public function getUploadRefNum()
    {
      return $this->UploadRefNum;
    }

    /**
     * @param int $UploadRefNum
     * @return \TenantSync\Billing\UsaEpaySoap\BatchUploadStatus
     */
    public function setUploadRefNum($UploadRefNum)
    {
      $this->UploadRefNum = $UploadRefNum;
      return $this;
    }

    /**
     * @return int
     */
    public function getDeclined()
    {
      return $this->Declined;
    }

    /**
     * @param int $Declined
     * @return \TenantSync\Billing\UsaEpaySoap\BatchUploadStatus
     */
    public function setDeclined($Declined)
    {
      $this->Declined = $Declined;
      return $this;
    }

    /**
     * @return int
     */
    public function getErrors()
    {
      return $this->Errors;
    }

    /**
     * @param int $Errors
     * @return \TenantSync\Billing\UsaEpaySoap\BatchUploadStatus
     */
    public function setErrors($Errors)
    {
      $this->Errors = $Errors;
      return $this;
    }

    /**
     * @return string
     */
    public function getFinished()
    {
      return $this->Finished;
    }

    /**
     * @param string $Finished
     * @return \TenantSync\Billing\UsaEpaySoap\BatchUploadStatus
     */
    public function setFinished($Finished)
    {
      $this->Finished = $Finished;
      return $this;
    }

    /**
     * @return int
     */
    public function getRemaining()
    {
      return $this->Remaining;
    }

    /**
     * @param int $Remaining
     * @return \TenantSync\Billing\UsaEpaySoap\BatchUploadStatus
     */
    public function setRemaining($Remaining)
    {
      $this->Remaining = $Remaining;
      return $this;
    }

    /**
     * @return string
     */
    public function getStarted()
    {
      return $this->Started;
    }

    /**
     * @param string $Started
     * @return \TenantSync\Billing\UsaEpaySoap\BatchUploadStatus
     */
    public function setStarted($Started)
    {
      $this->Started = $Started;
      return $this;
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
     * @return \TenantSync\Billing\UsaEpaySoap\BatchUploadStatus
     */
    public function setStatus($Status)
    {
      $this->Status = $Status;
      return $this;
    }

    /**
     * @return int
     */
    public function getTransactions()
    {
      return $this->Transactions;
    }

    /**
     * @param int $Transactions
     * @return \TenantSync\Billing\UsaEpaySoap\BatchUploadStatus
     */
    public function setTransactions($Transactions)
    {
      $this->Transactions = $Transactions;
      return $this;
    }

}
