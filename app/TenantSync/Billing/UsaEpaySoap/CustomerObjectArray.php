<?php

namespace TenantSync\Billing\UsaEpaySoap;

class CustomerObjectArray
{

    /**
     * @var CustomerObject[] $CustomerObjectArray
     */
    protected $CustomerObjectArray = null;

    /**
     * @param CustomerObject[] $CustomerObjectArray
     */
    public function __construct(array $CustomerObjectArray)
    {
      $this->CustomerObjectArray = $CustomerObjectArray;
    }

    /**
     * @return CustomerObject[]
     */
    public function getCustomerObjectArray()
    {
      return $this->CustomerObjectArray;
    }

    /**
     * @param CustomerObject[] $CustomerObjectArray
     * @return \TenantSync\Billing\UsaEpaySoap\CustomerObjectArray
     */
    public function setCustomerObjectArray(array $CustomerObjectArray)
    {
      $this->CustomerObjectArray = $CustomerObjectArray;
      return $this;
    }

}
