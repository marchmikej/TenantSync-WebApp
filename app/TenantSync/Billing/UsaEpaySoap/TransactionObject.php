<?php

namespace TenantSync\Billing\UsaEpaySoap;

class TransactionObject
{

    /**
     * @var string $AccountHolder
     */
    protected $AccountHolder = null;

    /**
     * @var Address $BillingAddress
     */
    protected $BillingAddress = null;

    /**
     * @var CheckData $CheckData
     */
    protected $CheckData = null;

    /**
     * @var CheckTrace $CheckTrace
     */
    protected $CheckTrace = null;

    /**
     * @var string $ClientIP
     */
    protected $ClientIP = null;

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
     * @var string $DateTime
     */
    protected $DateTime = null;

    /**
     * @var TransactionDetail $Details
     */
    protected $Details = null;

    /**
     * @var LineItemArray $LineItems
     */
    protected $LineItems = null;

    /**
     * @var TransactionResponse $Response
     */
    protected $Response = null;

    /**
     * @var string $ServerIP
     */
    protected $ServerIP = null;

    /**
     * @var Address $ShippingAddress
     */
    protected $ShippingAddress = null;

    /**
     * @var string $Source
     */
    protected $Source = null;

    /**
     * @var string $Status
     */
    protected $Status = null;

    /**
     * @var string $TransactionType
     */
    protected $TransactionType = null;

    /**
     * @var string $User
     */
    protected $User = null;

    /**
     * @param string $AccountHolder
     * @param Address $BillingAddress
     * @param CheckData $CheckData
     * @param CheckTrace $CheckTrace
     * @param string $ClientIP
     * @param CreditCardData $CreditCardData
     * @param string $CustomerID
     * @param FieldValueArray $CustomFields
     * @param string $DateTime
     * @param TransactionDetail $Details
     * @param TransactionResponse $Response
     * @param string $ServerIP
     * @param Address $ShippingAddress
     * @param string $Source
     * @param string $Status
     * @param string $TransactionType
     * @param string $User
     */
    public function __construct($AccountHolder, $BillingAddress, $CheckData, $CheckTrace, $ClientIP, $CreditCardData, $CustomerID, $CustomFields, $DateTime, $Details, $Response, $ServerIP, $ShippingAddress, $Source, $Status, $TransactionType, $User)
    {
      $this->AccountHolder = $AccountHolder;
      $this->BillingAddress = $BillingAddress;
      $this->CheckData = $CheckData;
      $this->CheckTrace = $CheckTrace;
      $this->ClientIP = $ClientIP;
      $this->CreditCardData = $CreditCardData;
      $this->CustomerID = $CustomerID;
      $this->CustomFields = $CustomFields;
      $this->DateTime = $DateTime;
      $this->Details = $Details;
      $this->Response = $Response;
      $this->ServerIP = $ServerIP;
      $this->ShippingAddress = $ShippingAddress;
      $this->Source = $Source;
      $this->Status = $Status;
      $this->TransactionType = $TransactionType;
      $this->User = $User;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
     */
    public function setAccountHolder($AccountHolder)
    {
      $this->AccountHolder = $AccountHolder;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
     */
    public function setCheckData($CheckData)
    {
      $this->CheckData = $CheckData;
      return $this;
    }

    /**
     * @return CheckTrace
     */
    public function getCheckTrace()
    {
      return $this->CheckTrace;
    }

    /**
     * @param CheckTrace $CheckTrace
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
     */
    public function setCheckTrace($CheckTrace)
    {
      $this->CheckTrace = $CheckTrace;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
     */
    public function setClientIP($ClientIP)
    {
      $this->ClientIP = $ClientIP;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
     */
    public function setCustomFields($CustomFields)
    {
      $this->CustomFields = $CustomFields;
      return $this;
    }

    /**
     * @return string
     */
    public function getDateTime()
    {
      return $this->DateTime;
    }

    /**
     * @param string $DateTime
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
     */
    public function setDateTime($DateTime)
    {
      $this->DateTime = $DateTime;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
     */
    public function setDetails($Details)
    {
      $this->Details = $Details;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
     */
    public function setLineItems($LineItems)
    {
      $this->LineItems = $LineItems;
      return $this;
    }

    /**
     * @return TransactionResponse
     */
    public function getResponse()
    {
      return $this->Response;
    }

    /**
     * @param TransactionResponse $Response
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
     */
    public function setResponse($Response)
    {
      $this->Response = $Response;
      return $this;
    }

    /**
     * @return string
     */
    public function getServerIP()
    {
      return $this->ServerIP;
    }

    /**
     * @param string $ServerIP
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
     */
    public function setServerIP($ServerIP)
    {
      $this->ServerIP = $ServerIP;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
     */
    public function setShippingAddress($ShippingAddress)
    {
      $this->ShippingAddress = $ShippingAddress;
      return $this;
    }

    /**
     * @return string
     */
    public function getSource()
    {
      return $this->Source;
    }

    /**
     * @param string $Source
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
     */
    public function setSource($Source)
    {
      $this->Source = $Source;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
     */
    public function setStatus($Status)
    {
      $this->Status = $Status;
      return $this;
    }

    /**
     * @return string
     */
    public function getTransactionType()
    {
      return $this->TransactionType;
    }

    /**
     * @param string $TransactionType
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
     */
    public function setTransactionType($TransactionType)
    {
      $this->TransactionType = $TransactionType;
      return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
      return $this->User;
    }

    /**
     * @param string $User
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObject
     */
    public function setUser($User)
    {
      $this->User = $User;
      return $this;
    }

}
