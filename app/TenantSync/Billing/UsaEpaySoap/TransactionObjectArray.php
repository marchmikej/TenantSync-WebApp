<?php

namespace TenantSync\Billing\UsaEpaySoap;

class TransactionObjectArray
{

    /**
     * @var TransactionObject[] $TransactionObjectArray
     */
    protected $TransactionObjectArray = null;

    /**
     * @param TransactionObject[] $TransactionObjectArray
     */
    public function __construct(array $TransactionObjectArray)
    {
      $this->TransactionObjectArray = $TransactionObjectArray;
    }

    /**
     * @return TransactionObject[]
     */
    public function getTransactionObjectArray()
    {
      return $this->TransactionObjectArray;
    }

    /**
     * @param TransactionObject[] $TransactionObjectArray
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionObjectArray
     */
    public function setTransactionObjectArray(array $TransactionObjectArray)
    {
      $this->TransactionObjectArray = $TransactionObjectArray;
      return $this;
    }

}
