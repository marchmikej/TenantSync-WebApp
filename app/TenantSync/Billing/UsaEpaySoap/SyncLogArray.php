<?php

namespace TenantSync\Billing\UsaEpaySoap;

class SyncLogArray
{

    /**
     * @var SyncLog[] $SyncLogArray
     */
    protected $SyncLogArray = null;

    /**
     * @param SyncLog[] $SyncLogArray
     */
    public function __construct(array $SyncLogArray)
    {
      $this->SyncLogArray = $SyncLogArray;
    }

    /**
     * @return SyncLog[]
     */
    public function getSyncLogArray()
    {
      return $this->SyncLogArray;
    }

    /**
     * @param SyncLog[] $SyncLogArray
     * @return \TenantSync\Billing\UsaEpaySoap\SyncLogArray
     */
    public function setSyncLogArray(array $SyncLogArray)
    {
      $this->SyncLogArray = $SyncLogArray;
      return $this;
    }

}
