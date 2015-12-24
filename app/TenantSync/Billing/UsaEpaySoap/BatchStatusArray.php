<?php

namespace TenantSync\Billing\UsaEpaySoap;

class BatchStatusArray
{

    /**
     * @var BatchStatus[] $BatchStatusArray
     */
    protected $BatchStatusArray = null;

    /**
     * @param BatchStatus[] $BatchStatusArray
     */
    public function __construct(array $BatchStatusArray)
    {
      $this->BatchStatusArray = $BatchStatusArray;
    }

    /**
     * @return BatchStatus[]
     */
    public function getBatchStatusArray()
    {
      return $this->BatchStatusArray;
    }

    /**
     * @param BatchStatus[] $BatchStatusArray
     * @return \TenantSync\Billing\UsaEpaySoap\BatchStatusArray
     */
    public function setBatchStatusArray(array $BatchStatusArray)
    {
      $this->BatchStatusArray = $BatchStatusArray;
      return $this;
    }

}
