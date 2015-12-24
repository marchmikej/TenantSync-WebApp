<?php

namespace TenantSync\Billing\UsaEpaySoap;

class CustomerTransactionRequest
{

    /**
     * @var string $Command
     */
    protected $Command = null;

    /**
     * @var string $CardCode
     */
    protected $CardCode = null;

    /**
     * @var string $ClientIP
     */
    protected $ClientIP = null;

    /**
     * @var FieldValueArray $CustomFields
     */
    protected $CustomFields = null;

    /**
     * @var boolean $CustReceipt
     */
    protected $CustReceipt = null;

    /**
     * @var string $CustReceiptEmail
     */
    protected $CustReceiptEmail = null;

    /**
     * @var string $CustReceiptName
     */
    protected $CustReceiptName = null;

    /**
     * @var boolean $MerchReceipt
     */
    protected $MerchReceipt = null;

    /**
     * @var string $MerchReceiptEmail
     */
    protected $MerchReceiptEmail = null;

    /**
     * @var string $MerchReceiptName
     */
    protected $MerchReceiptName = null;

    /**
     * @var TransactionDetail $Details
     */
    protected $Details = null;

    /**
     * @var boolean $IgnoreDuplicate
     */
    protected $IgnoreDuplicate = null;

    /**
     * @var boolean $isRecurring
     */
    protected $isRecurring = null;

    /**
     * @var LineItemArray $LineItems
     */
    protected $LineItems = null;

    /**
     * @var string $Software
     */
    protected $Software = null;

    /**
     * @param string $Command
     * @param TransactionDetail $Details
     */
    public function __construct($Command, $Details)
    {
      $this->Command = $Command;
      $this->Details = $Details;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
      return $this->Command;
    }

    /**
     * @param string $Command
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest
     */
    public function setCommand($Command)
    {
      $this->Command = $Command;
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
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest
     */
    public function setCardCode($CardCode)
    {
      $this->CardCode = $CardCode;
      return $this;
    }

    /**
     * @return string
     */
    public function getClientIP()
    {
      return $this->ClientIP;
    }

    /**
     * @param string $ClientIP
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest
     */
    public function setClientIP($ClientIP)
    {
      $this->ClientIP = $ClientIP;
      return $this;
    }

    /**
     * @return FieldValueArray
     */
    public function getCustomFields()
    {
      return $this->CustomFields;
    }

    /**
     * @param FieldValueArray $CustomFields
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest
     */
    public function setCustomFields($CustomFields)
    {
      $this->CustomFields = $CustomFields;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getCustReceipt()
    {
      return $this->CustReceipt;
    }

    /**
     * @param boolean $CustReceipt
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest
     */
    public function setCustReceipt($CustReceipt)
    {
      $this->CustReceipt = $CustReceipt;
      return $this;
    }

    /**
     * @return string
     */
    public function getCustReceiptEmail()
    {
      return $this->CustReceiptEmail;
    }

    /**
     * @param string $CustReceiptEmail
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest
     */
    public function setCustReceiptEmail($CustReceiptEmail)
    {
      $this->CustReceiptEmail = $CustReceiptEmail;
      return $this;
    }

    /**
     * @return string
     */
    public function getCustReceiptName()
    {
      return $this->CustReceiptName;
    }

    /**
     * @param string $CustReceiptName
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest
     */
    public function setCustReceiptName($CustReceiptName)
    {
      $this->CustReceiptName = $CustReceiptName;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getMerchReceipt()
    {
      return $this->MerchReceipt;
    }

    /**
     * @param boolean $MerchReceipt
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest
     */
    public function setMerchReceipt($MerchReceipt)
    {
      $this->MerchReceipt = $MerchReceipt;
      return $this;
    }

    /**
     * @return string
     */
    public function getMerchReceiptEmail()
    {
      return $this->MerchReceiptEmail;
    }

    /**
     * @param string $MerchReceiptEmail
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest
     */
    public function setMerchReceiptEmail($MerchReceiptEmail)
    {
      $this->MerchReceiptEmail = $MerchReceiptEmail;
      return $this;
    }

    /**
     * @return string
     */
    public function getMerchReceiptName()
    {
      return $this->MerchReceiptName;
    }

    /**
     * @param string $MerchReceiptName
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest
     */
    public function setMerchReceiptName($MerchReceiptName)
    {
      $this->MerchReceiptName = $MerchReceiptName;
      return $this;
    }

    /**
     * @return TransactionDetail
     */
    public function getDetails()
    {
      return $this->Details;
    }

    /**
     * @param TransactionDetail $Details
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest
     */
    public function setDetails($Details)
    {
      $this->Details = $Details;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getIgnoreDuplicate()
    {
      return $this->IgnoreDuplicate;
    }

    /**
     * @param boolean $IgnoreDuplicate
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest
     */
    public function setIgnoreDuplicate($IgnoreDuplicate)
    {
      $this->IgnoreDuplicate = $IgnoreDuplicate;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getIsRecurring()
    {
      return $this->isRecurring;
    }

    /**
     * @param boolean $isRecurring
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest
     */
    public function setIsRecurring($isRecurring)
    {
      $this->isRecurring = $isRecurring;
      return $this;
    }

    /**
     * @return LineItemArray
     */
    public function getLineItems()
    {
      return $this->LineItems;
    }

    /**
     * @param LineItemArray $LineItems
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest
     */
    public function setLineItems($LineItems)
    {
      $this->LineItems = $LineItems;
      return $this;
    }

    /**
     * @return string
     */
    public function getSoftware()
    {
      return $this->Software;
    }

    /**
     * @param string $Software
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest
     */
    public function setSoftware($Software)
    {
      $this->Software = $Software;
      return $this;
    }

}
