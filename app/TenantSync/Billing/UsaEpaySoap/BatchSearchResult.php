<?php

namespace TenantSync\Billing\UsaEpaySoap;

class BatchSearchResult
{

    /**
     * @var BatchStatusArray $Batches
     */
    protected $Batches = null;

    /**
     * @var int $BatchesMatched
     */
    protected $BatchesMatched = null;

    /**
     * @var int $BatchesReturned
     */
    protected $BatchesReturned = null;

    /**
     * @var int $Limit
     */
    protected $Limit = null;

    /**
     * @var int $StartIndex
     */
    protected $StartIndex = null;

    /**
     * @param BatchStatusArray $Batches
     * @param int $BatchesMatched
     * @param int $BatchesReturned
     * @param int $Limit
     * @param int $StartIndex
     */
    public function __construct($Batches, $BatchesMatched, $BatchesReturned, $Limit, $StartIndex)
    {
      $this->Batches = $Batches;
      $this->BatchesMatched = $BatchesMatched;
      $this->BatchesReturned = $BatchesReturned;
      $this->Limit = $Limit;
      $this->StartIndex = $StartIndex;
    }

    /**
     * @return BatchStatusArray
     */
    public function getBatches()
    {
      return $this->Batches;
    }

    /**
     * @param BatchStatusArray $Batches
     * @return \TenantSync\Billing\UsaEpaySoap\BatchSearchResult
     */
    public function setBatches($Batches)
    {
      $this->Batches = $Batches;
      return $this;
    }

    /**
     * @return int
     */
    public function getBatchesMatched()
    {
      return $this->BatchesMatched;
    }

    /**
     * @param int $BatchesMatched
     * @return \TenantSync\Billing\UsaEpaySoap\BatchSearchResult
     */
    public function setBatchesMatched($BatchesMatched)
    {
      $this->BatchesMatched = $BatchesMatched;
      return $this;
    }

    /**
     * @return int
     */
    public function getBatchesReturned()
    {
      return $this->BatchesReturned;
    }

    /**
     * @param int $BatchesReturned
     * @return \TenantSync\Billing\UsaEpaySoap\BatchSearchResult
     */
    public function setBatchesReturned($BatchesReturned)
    {
      $this->BatchesReturned = $BatchesReturned;
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
     * @return \TenantSync\Billing\UsaEpaySoap\BatchSearchResult
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
     * @return \TenantSync\Billing\UsaEpaySoap\BatchSearchResult
     */
    public function setStartIndex($StartIndex)
    {
      $this->StartIndex = $StartIndex;
      return $this;
    }

}
