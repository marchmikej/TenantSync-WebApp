<?php

namespace TenantSync\Billing\UsaEpaySoap;

class CustomerSearchResult
{

    /**
     * @var CustomerObjectArray $Customers
     */
    protected $Customers = null;

    /**
     * @var int $CustomersMatched
     */
    protected $CustomersMatched = null;

    /**
     * @var int $CustomersReturned
     */
    protected $CustomersReturned = null;

    /**
     * @var int $Limit
     */
    protected $Limit = null;

    /**
     * @var int $StartIndex
     */
    protected $StartIndex = null;

    /**
     * @param CustomerObjectArray $Customers
     * @param int $CustomersMatched
     * @param int $CustomersReturned
     * @param int $Limit
     * @param int $StartIndex
     */
    public function __construct($Customers, $CustomersMatched, $CustomersReturned, $Limit, $StartIndex)
    {
      $this->Customers = $Customers;
      $this->CustomersMatched = $CustomersMatched;
      $this->CustomersReturned = $CustomersReturned;
      $this->Limit = $Limit;
      $this->StartIndex = $StartIndex;
    }

    /**
     * @return CustomerObjectArray
     */
    public function getCustomers()
    {
      return $this->Customers;
    }

    /**
     * @param CustomerObjectArray $Customers
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerSearchResult
     */
    public function setCustomers($Customers)
    {
      $this->Customers = $Customers;
      return $this;
    }

    /**
     * @return int
     */
    public function getCustomersMatched()
    {
      return $this->CustomersMatched;
    }

    /**
     * @param int $CustomersMatched
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerSearchResult
     */
    public function setCustomersMatched($CustomersMatched)
    {
      $this->CustomersMatched = $CustomersMatched;
      return $this;
    }

    /**
     * @return int
     */
    public function getCustomersReturned()
    {
      return $this->CustomersReturned;
    }

    /**
     * @param int $CustomersReturned
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerSearchResult
     */
    public function setCustomersReturned($CustomersReturned)
    {
      $this->CustomersReturned = $CustomersReturned;
      return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
      return $this->Limit;
    }

    /**
     * @param int $Limit
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerSearchResult
     */
    public function setLimit($Limit)
    {
      $this->Limit = $Limit;
      return $this;
    }

    /**
     * @return int
     */
    public function getStartIndex()
    {
      return $this->StartIndex;
    }

    /**
     * @param int $StartIndex
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerSearchResult
     */
    public function setStartIndex($StartIndex)
    {
      $this->StartIndex = $StartIndex;
      return $this;
    }

}
