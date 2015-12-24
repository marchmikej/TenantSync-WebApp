<?php

namespace TenantSync\Billing\UsaEpaySoap;

class CustomerObject
{

    /**
     * @var float $Amount
     */
    protected $Amount = null;

    /**
     * @var Address $BillingAddress
     */
    protected $BillingAddress = null;

    /**
     * @var \DateTime $Created
     */
    protected $Created = null;

    /**
     * @var string $Currency
     */
    protected $Currency = null;

    /**
     * @var string $CustNum
     */
    protected $CustNum = null;

    /**
     * @var string $CustomData
     */
    protected $CustomData = null;

    /**
     * @var FieldValueArray $CustomFields
     */
    protected $CustomFields = null;

    /**
     * @var string $CustomerID
     */
    protected $CustomerID = null;

    /**
     * @var string $Description
     */
    protected $Description = null;

    /**
     * @var boolean $Enabled
     */
    protected $Enabled = null;

    /**
     * @var int $Failures
     */
    protected $Failures = null;

    /**
     * @var string $LookupCode
     */
    protected $LookupCode = null;

    /**
     * @var \DateTime $Modified
     */
    protected $Modified = null;

    /**
     * @var string $Next
     */
    protected $Next = null;

    /**
     * @var string $Notes
     */
    protected $Notes = null;

    /**
     * @var int $NumLeft
     */
    protected $NumLeft = null;

    /**
     * @var string $OrderID
     */
    protected $OrderID = null;

    /**
     * @var PaymentMethodArray $PaymentMethods
     */
    protected $PaymentMethods = null;

    /**
     * @var string $PriceTier
     */
    protected $PriceTier = null;

    /**
     * @var string $ReceiptNote
     */
    protected $ReceiptNote = null;

    /**
     * @var string $Schedule
     */
    protected $Schedule = null;

    /**
     * @var boolean $SendReceipt
     */
    protected $SendReceipt = null;

    /**
     * @var string $Source
     */
    protected $Source = null;

    /**
     * @var float $Tax
     */
    protected $Tax = null;

    /**
     * @var string $TaxClass
     */
    protected $TaxClass = null;

    /**
     * @var string $User
     */
    protected $User = null;

    /**
     * @var string $URL
     */
    protected $URL = null;

    /**
     * @param float $Amount
     * @param Address $BillingAddress
     * @param string $CustomerID
     * @param string $Description
     * @param boolean $Enabled
     * @param string $Next
     * @param int $NumLeft
     * @param string $OrderID
     * @param string $ReceiptNote
     * @param string $Schedule
     * @param boolean $SendReceipt
     */
    public function __construct($Amount, $BillingAddress, $CustomerID, $Description, $Enabled, $Next, $NumLeft, $OrderID, $ReceiptNote, $Schedule, $SendReceipt)
    {
      $this->Amount = $Amount;
      $this->BillingAddress = $BillingAddress;
      $this->CustomerID = $CustomerID;
      $this->Description = $Description;
      $this->Enabled = $Enabled;
      $this->Next = $Next;
      $this->NumLeft = $NumLeft;
      $this->OrderID = $OrderID;
      $this->ReceiptNote = $ReceiptNote;
      $this->Schedule = $Schedule;
      $this->SendReceipt = $SendReceipt;
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
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setAmount($Amount)
    {
      $this->Amount = $Amount;
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
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setBillingAddress($BillingAddress)
    {
      $this->BillingAddress = $BillingAddress;
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
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
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
     * @return string
     */
    public function getCurrency()
    {
      return $this->Currency;
    }

    /**
     * @param string $Currency
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setCurrency($Currency)
    {
      $this->Currency = $Currency;
      return $this;
    }

    /**
     * @return string
     */
    public function getCustNum()
    {
      return $this->CustNum;
    }

    /**
     * @param string $CustNum
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setCustNum($CustNum)
    {
      $this->CustNum = $CustNum;
      return $this;
    }

    /**
     * @return string
     */
    public function getCustomData()
    {
      return $this->CustomData;
    }

    /**
     * @param string $CustomData
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setCustomData($CustomData)
    {
      $this->CustomData = $CustomData;
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
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setCustomFields($CustomFields)
    {
      $this->CustomFields = $CustomFields;
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
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setCustomerID($CustomerID)
    {
      $this->CustomerID = $CustomerID;
      return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
      return $this->Description;
    }

    /**
     * @param string $Description
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setDescription($Description)
    {
      $this->Description = $Description;
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
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setEnabled($Enabled)
    {
      $this->Enabled = $Enabled;
      return $this;
    }

    /**
     * @return int
     */
    public function getFailures()
    {
      return $this->Failures;
    }

    /**
     * @param int $Failures
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setFailures($Failures)
    {
      $this->Failures = $Failures;
      return $this;
    }

    /**
     * @return string
     */
    public function getLookupCode()
    {
      return $this->LookupCode;
    }

    /**
     * @param string $LookupCode
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setLookupCode($LookupCode)
    {
      $this->LookupCode = $LookupCode;
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
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
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
    public function getNext()
    {
      return $this->Next;
    }

    /**
     * @param string $Next
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setNext($Next)
    {
      $this->Next = $Next;
      return $this;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
      return $this->Notes;
    }

    /**
     * @param string $Notes
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setNotes($Notes)
    {
      $this->Notes = $Notes;
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
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setNumLeft($NumLeft)
    {
      $this->NumLeft = $NumLeft;
      return $this;
    }

    /**
     * @return string
     */
    public function getOrderID()
    {
      return $this->OrderID;
    }

    /**
     * @param string $OrderID
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setOrderID($OrderID)
    {
      $this->OrderID = $OrderID;
      return $this;
    }

    /**
     * @return PaymentMethodArray
     */
    public function getPaymentMethods()
    {
      return $this->PaymentMethods;
    }

    /**
     * @param PaymentMethodArray $PaymentMethods
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setPaymentMethods($PaymentMethods)
    {
      $this->PaymentMethods = $PaymentMethods;
      return $this;
    }

    /**
     * @return string
     */
    public function getPriceTier()
    {
      return $this->PriceTier;
    }

    /**
     * @param string $PriceTier
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setPriceTier($PriceTier)
    {
      $this->PriceTier = $PriceTier;
      return $this;
    }

    /**
     * @return string
     */
    public function getReceiptNote()
    {
      return $this->ReceiptNote;
    }

    /**
     * @param string $ReceiptNote
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setReceiptNote($ReceiptNote)
    {
      $this->ReceiptNote = $ReceiptNote;
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
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setSchedule($Schedule)
    {
      $this->Schedule = $Schedule;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getSendReceipt()
    {
      return $this->SendReceipt;
    }

    /**
     * @param boolean $SendReceipt
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setSendReceipt($SendReceipt)
    {
      $this->SendReceipt = $SendReceipt;
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
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setSource($Source)
    {
      $this->Source = $Source;
      return $this;
    }

    /**
     * @return float
     */
    public function getTax()
    {
      return $this->Tax;
    }

    /**
     * @param float $Tax
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setTax($Tax)
    {
      $this->Tax = $Tax;
      return $this;
    }

    /**
     * @return string
     */
    public function getTaxClass()
    {
      return $this->TaxClass;
    }

    /**
     * @param string $TaxClass
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setTaxClass($TaxClass)
    {
      $this->TaxClass = $TaxClass;
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
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setUser($User)
    {
      $this->User = $User;
      return $this;
    }

    /**
     * @return string
     */
    public function getURL()
    {
      return $this->URL;
    }

    /**
     * @param string $URL
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObject
     */
    public function setURL($URL)
    {
      $this->URL = $URL;
      return $this;
    }

}
