<?php

namespace TenantSync\Billing\UsaEpaySoap;

class BatchStatus
{

    /**
     * @var int $BatchRefNum
     */
    protected $BatchRefNum = null;

    /**
     * @var string $Closed
     */
    protected $Closed = null;

    /**
     * @var float $CreditsAmount
     */
    protected $CreditsAmount = null;

    /**
     * @var int $CreditsCount
     */
    protected $CreditsCount = null;

    /**
     * @var float $NetAmount
     */
    protected $NetAmount = null;

    /**
     * @var string $Opened
     */
    protected $Opened = null;

    /**
     * @var float $SalesAmount
     */
    protected $SalesAmount = null;

    /**
     * @var int $SalesCount
     */
    protected $SalesCount = null;

    /**
     * @var string $Scheduled
     */
    protected $Scheduled = null;

    /**
     * @var int $Sequence
     */
    protected $Sequence = null;

    /**
     * @var string $Status
     */
    protected $Status = null;

    /**
     * @var int $TransactionCount
     */
    protected $TransactionCount = null;

    /**
     * @var float $VoidsAmount
     */
    protected $VoidsAmount = null;

    /**
     * @var int $VoidsCount
     */
    protected $VoidsCount = null;

    /**
     * @param int $BatchRefNum
     * @param string $Closed
     * @param float $CreditsAmount
     * @param int $CreditsCount
     * @param float $NetAmount
     * @param string $Opened
     * @param float $SalesAmount
     * @param int $SalesCount
     * @param string $Scheduled
     * @param int $Sequence
     * @param string $Status
     * @param int $TransactionCount
     * @param float $VoidsAmount
     * @param int $VoidsCount
     */
    public function __construct($BatchRefNum, $Closed, $CreditsAmount, $CreditsCount, $NetAmount, $Opened, $SalesAmount, $SalesCount, $Scheduled, $Sequence, $Status, $TransactionCount, $VoidsAmount, $VoidsCount)
    {
      $this->BatchRefNum = $BatchRefNum;
      $this->Closed = $Closed;
      $this->CreditsAmount = $CreditsAmount;
      $this->CreditsCount = $CreditsCount;
      $this->NetAmount = $NetAmount;
      $this->Opened = $Opened;
      $this->SalesAmount = $SalesAmount;
      $this->SalesCount = $SalesCount;
      $this->Scheduled = $Scheduled;
      $this->Sequence = $Sequence;
      $this->Status = $Status;
      $this->TransactionCount = $TransactionCount;
      $this->VoidsAmount = $VoidsAmount;
      $this->VoidsCount = $VoidsCount;
    }

    /**
     * @return int
     */
    public function getBatchRefNum()
    {
      return $this->BatchRefNum;
    }

    /**
     * @param int $BatchRefNum
     * @return \TenantSync\Billing\UsaEpaySoap\BatchStatus
     */
    public function setBatchRefNum($BatchRefNum)
    {
      $this->BatchRefNum = $BatchRefNum;
      return $this;
    }

    /**
     * @return string
     */
    public function getClosed()
    {
      return $this->Closed;
    }

    /**
     * @param string $Closed
     * @return \TenantSync\Billing\UsaEpaySoap\BatchStatus
     */
    public function setClosed($Closed)
    {
      $this->Closed = $Closed;
      return $this;
    }

    /**
     * @return float
     */
    public function getCreditsAmount()
    {
      return $this->CreditsAmount;
    }

    /**
     * @param float $CreditsAmount
     * @return \TenantSync\Billing\UsaEpaySoap\BatchStatus
     */
    public function setCreditsAmount($CreditsAmount)
    {
      $this->CreditsAmount = $CreditsAmount;
      return $this;
    }

    /**
     * @return int
     */
    public function getCreditsCount()
    {
      return $this->CreditsCount;
    }

    /**
     * @param int $CreditsCount
     * @return \TenantSync\Billing\UsaEpaySoap\BatchStatus
     */
    public function setCreditsCount($CreditsCount)
    {
      $this->CreditsCount = $CreditsCount;
      return $this;
    }

    /**
     * @return float
     */
    public function getNetAmount()
    {
      return $this->NetAmount;
    }

    /**
     * @param float $NetAmount
     * @return \TenantSync\Billing\UsaEpaySoap\BatchStatus
     */
    public function setNetAmount($NetAmount)
    {
      $this->NetAmount = $NetAmount;
      return $this;
    }

    /**
     * @return string
     */
    public function getOpened()
    {
      return $this->Opened;
    }

    /**
     * @param string $Opened
     * @return \TenantSync\Billing\UsaEpaySoap\BatchStatus
     */
    public function setOpened($Opened)
    {
      $this->Opened = $Opened;
      return $this;
    }

    /**
     * @return float
     */
    public function getSalesAmount()
    {
      return $this->SalesAmount;
    }

    /**
     * @param float $SalesAmount
     * @return \TenantSync\Billing\UsaEpaySoap\BatchStatus
     */
    public function setSalesAmount($SalesAmount)
    {
      $this->SalesAmount = $SalesAmount;
      return $this;
    }

    /**
     * @return int
     */
    public function getSalesCount()
    {
      return $this->SalesCount;
    }

    /**
     * @param int $SalesCount
     * @return \TenantSync\Billing\UsaEpaySoap\BatchStatus
     */
    public function setSalesCount($SalesCount)
    {
      $this->SalesCount = $SalesCount;
      return $this;
    }

    /**
     * @return string
     */
    public function getScheduled()
    {
      return $this->Scheduled;
    }

    /**
     * @param string $Scheduled
     * @return \TenantSync\Billing\UsaEpaySoap\BatchStatus
     */
    public function setScheduled($Scheduled)
    {
      $this->Scheduled = $Scheduled;
      return $this;
    }

    /**
     * @return int
     */
    public function getSequence()
    {
      return $this->Sequence;
    }

    /**
     * @param int $Sequence
     * @return \TenantSync\Billing\UsaEpaySoap\BatchStatus
     */
    public function setSequence($Sequence)
    {
      $this->Sequence = $Sequence;
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
     * @return \TenantSync\Billing\UsaEpaySoap\BatchStatus
     */
    public function setStatus($Status)
    {
      $this->Status = $Status;
      return $this;
    }

    /**
     * @return int
     */
    public function getTransactionCount()
    {
      return $this->TransactionCount;
    }

    /**
     * @param int $TransactionCount
     * @return \TenantSync\Billing\UsaEpaySoap\BatchStatus
     */
    public function setTransactionCount($TransactionCount)
    {
      $this->TransactionCount = $TransactionCount;
      return $this;
    }

    /**
     * @return float
     */
    public function getVoidsAmount()
    {
      return $this->VoidsAmount;
    }

    /**
     * @param float $VoidsAmount
     * @return \TenantSync\Billing\UsaEpaySoap\BatchStatus
     */
    public function setVoidsAmount($VoidsAmount)
    {
      $this->VoidsAmount = $VoidsAmount;
      return $this;
    }

    /**
     * @return int
     */
    public function getVoidsCount()
    {
      return $this->VoidsCount;
    }

    /**
     * @param int $VoidsCount
     * @return \TenantSync\Billing\UsaEpaySoap\BatchStatus
     */
    public function setVoidsCount($VoidsCount)
    {
      $this->VoidsCount = $VoidsCount;
      return $this;
    }

}
