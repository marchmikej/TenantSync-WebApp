<?php

namespace TenantSync\Billing\UsaEpaySoap;

class ueHash
{

    /**
     * @var string $HashValue
     */
    protected $HashValue = null;

    /**
     * @var string $Seed
     */
    protected $Seed = null;

    /**
     * @var string $Type
     */
    protected $Type = null;

    /**
     * @param string $HashValue
     * @param string $Seed
     * @param string $Type
     */
    public function __construct($HashValue, $Seed, $Type)
    {
      $this->HashValue = $HashValue;
      $this->Seed = $Seed;
      $this->Type = $Type;
    }

    /**
     * @return string
     */
    public function getHashValue()
    {
      return $this->HashValue;
    }

    /**
     * @param string $HashValue
     * @return \TenantSync\Billing\UsaEpaySoap\ueHash
     */
    public function setHashValue($HashValue)
    {
      $this->HashValue = $HashValue;
      return $this;
    }

    /**
     * @return string
     */
    public function getSeed()
    {
      return $this->Seed;
    }

    /**
     * @param string $Seed
     * @return \TenantSync\Billing\UsaEpaySoap\ueHash
     */
    public function setSeed($Seed)
    {
      $this->Seed = $Seed;
      return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
      return $this->Type;
    }

    /**
     * @param string $Type
     * @return \TenantSync\Billing\UsaEpaySoap\ueHash
     */
    public function setType($Type)
    {
      $this->Type = $Type;
      return $this;
    }

}
