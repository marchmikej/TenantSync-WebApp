<?php

namespace TenantSync\Billing\UsaEpaySoap;

class ReceiptArray
{

    /**
     * @var Receipt[] $ReceiptArray
     */
    protected $ReceiptArray = null;

    /**
     * @param Receipt[] $ReceiptArray
     */
    public function __construct(array $ReceiptArray)
    {
      $this->ReceiptArray = $ReceiptArray;
    }

    /**
     * @return Receipt[]
     */
    public function getReceiptArray()
    {
      return $this->ReceiptArray;
    }

    /**
     * @param Receipt[] $ReceiptArray
     * @return \TenantSync\Billing\UsaEpaySoap\ReceiptArray
     */
    public function setReceiptArray(array $ReceiptArray)
    {
      $this->ReceiptArray = $ReceiptArray;
      return $this;
    }

}
