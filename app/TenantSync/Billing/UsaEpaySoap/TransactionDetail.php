<?php

namespace TenantSync\Billing\UsaEpaySoap;

class TransactionDetail
{

    /**
     * @var boolean $AllowPartialAuth
     */
    protected $AllowPartialAuth = null;

    /**
     * @var float $Amount
     */
    protected $Amount = null;

    /**
     * @var string $Clerk
     */
    protected $Clerk = null;

    /**
     * @var string $Currency
     */
    protected $Currency = null;

    /**
     * @var string $Description
     */
    protected $Description = null;

    /**
     * @var string $Comments
     */
    protected $Comments = null;

    /**
     * @var float $Discount
     */
    protected $Discount = null;

    /**
     * @var string $Invoice
     */
    protected $Invoice = null;

    /**
     * @var boolean $NonTax
     */
    protected $NonTax = null;

    /**
     * @var string $OrderID
     */
    protected $OrderID = null;

    /**
     * @var string $PONum
     */
    protected $PONum = null;

    /**
     * @var float $Shipping
     */
    protected $Shipping = null;

    /**
     * @var float $Subtotal
     */
    protected $Subtotal = null;

    /**
     * @var string $Table
     */
    protected $Table = null;

    /**
     * @var float $Tax
     */
    protected $Tax = null;

    /**
     * @var string $Terminal
     */
    protected $Terminal = null;

    /**
     * @var float $Tip
     */
    protected $Tip = null;

    
    public function __construct()
    {
    
    }

    /**
     * @return boolean
     */
    public function getAllowPartialAuth()
    {
      return $this->AllowPartialAuth;
    }

    /**
     * @param boolean $AllowPartialAuth
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setAllowPartialAuth($AllowPartialAuth)
    {
      $this->AllowPartialAuth = $AllowPartialAuth;
      return $this;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setAmount($Amount)
    {
      $this->Amount = $Amount;
      return $this;
    }

    /**
     * @return string
     */
    public function getClerk()
    {
      return $this->Clerk;
    }

    /**
     * @param string $Clerk
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setClerk($Clerk)
    {
      $this->Clerk = $Clerk;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setCurrency($Currency)
    {
      $this->Currency = $Currency;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setDescription($Description)
    {
      $this->Description = $Description;
      return $this;
    }

    /**
     * @return string
     */
    public function getComments()
    {
      return $this->Comments;
    }

    /**
     * @param string $Comments
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setComments($Comments)
    {
      $this->Comments = $Comments;
      return $this;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
      return $this->Discount;
    }

    /**
     * @param float $Discount
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setDiscount($Discount)
    {
      $this->Discount = $Discount;
      return $this;
    }

    /**
     * @return string
     */
    public function getInvoice()
    {
      return $this->Invoice;
    }

    /**
     * @param string $Invoice
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setInvoice($Invoice)
    {
      $this->Invoice = $Invoice;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getNonTax()
    {
      return $this->NonTax;
    }

    /**
     * @param boolean $NonTax
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setNonTax($NonTax)
    {
      $this->NonTax = $NonTax;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setOrderID($OrderID)
    {
      $this->OrderID = $OrderID;
      return $this;
    }

    /**
     * @return string
     */
    public function getPONum()
    {
      return $this->PONum;
    }

    /**
     * @param string $PONum
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setPONum($PONum)
    {
      $this->PONum = $PONum;
      return $this;
    }

    /**
     * @return float
     */
    public function getShipping()
    {
      return $this->Shipping;
    }

    /**
     * @param float $Shipping
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setShipping($Shipping)
    {
      $this->Shipping = $Shipping;
      return $this;
    }

    /**
     * @return float
     */
    public function getSubtotal()
    {
      return $this->Subtotal;
    }

    /**
     * @param float $Subtotal
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setSubtotal($Subtotal)
    {
      $this->Subtotal = $Subtotal;
      return $this;
    }

    /**
     * @return string
     */
    public function getTable()
    {
      return $this->Table;
    }

    /**
     * @param string $Table
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setTable($Table)
    {
      $this->Table = $Table;
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
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setTax($Tax)
    {
      $this->Tax = $Tax;
      return $this;
    }

    /**
     * @return string
     */
    public function getTerminal()
    {
      return $this->Terminal;
    }

    /**
     * @param string $Terminal
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setTerminal($Terminal)
    {
      $this->Terminal = $Terminal;
      return $this;
    }

    /**
     * @return float
     */
    public function getTip()
    {
      return $this->Tip;
    }

    /**
     * @param float $Tip
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionDetail
     */
    public function setTip($Tip)
    {
      $this->Tip = $Tip;
      return $this;
    }

}
