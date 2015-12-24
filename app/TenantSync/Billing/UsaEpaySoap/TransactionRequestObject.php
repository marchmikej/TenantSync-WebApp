<?php

namespace TenantSync\Billing\UsaEpaySoap;

class TransactionRequestObject
{

    /**
     * @var string $AccountHolder
     */
    protected $AccountHolder = null;

    /**
     * @var string $AuthCode
     */
    protected $AuthCode = null;

    /**
     * @var Address $BillingAddress
     */
    protected $BillingAddress = null;

    /**
     * @var CheckData $CheckData
     */
    protected $CheckData = null;

    /**
     * @var string $ClientIP
     */
    protected $ClientIP = null;

    /**
     * @var string $Command
     */
    protected $Command = null;

    /**
     * @var CreditCardData $CreditCardData
     */
    protected $CreditCardData = null;

    /**
     * @var string $CustomerID
     */
    protected $CustomerID = null;

    /**
     * @var FieldValueArray $CustomFields
     */
    protected $CustomFields = null;

    /**
     * @var boolean $CustReceipt
     */
    protected $CustReceipt = null;

    /**
     * @var string $CustReceiptName
     */
    protected $CustReceiptName = null;

    /**
     * @var TransactionDetail $Details
     */
    protected $Details = null;

    /**
     * @var boolean $IgnoreDuplicate
     */
    protected $IgnoreDuplicate = null;

    /**
     * @var LineItemArray $LineItems
     */
    protected $LineItems = null;

    /**
     * @var RecurringBilling $RecurringBilling
     */
    protected $RecurringBilling = null;

    /**
     * @var string $RefNum
     */
    protected $RefNum = null;

    /**
     * @var Address $ShippingAddress
     */
    protected $ShippingAddress = null;

    /**
     * @var string $Software
     */
    protected $Software = null;

    /**
     * @param TransactionDetail $Details
     */
    public function __construct($Details)
    {
      $this->Details = $Details;
    }

    /**
     * @return string
     */
    public function getAccountHolder()
    {
      return $this->AccountHolder;
    }

    /**
     * @param string $AccountHolder
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setAccountHolder($AccountHolder)
    {
      $this->AccountHolder = $AccountHolder;
      return $this;
    }

    /**
     * @return string
     */
    public function getAuthCode()
    {
      return $this->AuthCode;
    }

    /**
     * @param string $AuthCode
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setAuthCode($AuthCode)
    {
      $this->AuthCode = $AuthCode;
      return $this;
    }

    /**
     * @return Address
     */
    public function getBillingAddress()
    {
      return $this->BillingAddress;
    }

    /**
     * @param Address $BillingAddress
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setBillingAddress($BillingAddress)
    {
      $this->BillingAddress = $BillingAddress;
      return $this;
    }

    /**
     * @return CheckData
     */
    public function getCheckData()
    {
      return $this->CheckData;
    }

    /**
     * @param CheckData $CheckData
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setCheckData($CheckData)
    {
      $this->CheckData = $CheckData;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setClientIP($ClientIP)
    {
      $this->ClientIP = $ClientIP;
      return $this;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setCommand($Command)
    {
      $this->Command = $Command;
      return $this;
    }

    /**
     * @return CreditCardData
     */
    public function getCreditCardData()
    {
      return $this->CreditCardData;
    }

    /**
     * @param CreditCardData $CreditCardData
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setCreditCardData($CreditCardData)
    {
      $this->CreditCardData = $CreditCardData;
      return $this;
    }

    /**
     * @return string
     */
    public function getCustomerID()
    {
      return $this->CustomerID;
    }

    /**
     * @param string $CustomerID
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setCustomerID($CustomerID)
    {
      $this->CustomerID = $CustomerID;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setCustReceipt($CustReceipt)
    {
      $this->CustReceipt = $CustReceipt;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setCustReceiptName($CustReceiptName)
    {
      $this->CustReceiptName = $CustReceiptName;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setIgnoreDuplicate($IgnoreDuplicate)
    {
      $this->IgnoreDuplicate = $IgnoreDuplicate;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setLineItems($LineItems)
    {
      $this->LineItems = $LineItems;
      return $this;
    }

    /**
     * @return RecurringBilling
     */
    public function getRecurringBilling()
    {
      return $this->RecurringBilling;
    }

    /**
     * @param RecurringBilling $RecurringBilling
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setRecurringBilling($RecurringBilling)
    {
      $this->RecurringBilling = $RecurringBilling;
      return $this;
    }

    /**
     * @return string
     */
    public function getRefNum()
    {
      return $this->RefNum;
    }

    /**
     * @param string $RefNum
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setRefNum($RefNum)
    {
      $this->RefNum = $RefNum;
      return $this;
    }

    /**
     * @return Address
     */
    public function getShippingAddress()
    {
      return $this->ShippingAddress;
    }

    /**
     * @param Address $ShippingAddress
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setShippingAddress($ShippingAddress)
    {
      $this->ShippingAddress = $ShippingAddress;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionRequestObject
     */
    public function setSoftware($Software)
    {
      $this->Software = $Software;
      return $this;
    }

}
