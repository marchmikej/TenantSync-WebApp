<?php

namespace TenantSync\Billing\UsaEpaySoap;

class ueSecurityToken
{

    /**
     * @var string $ClientIP
     */
    protected $ClientIP = null;

    /**
     * @var ueHash $PinHash
     */
    protected $PinHash = null;

    /**
     * @var string $SourceKey
     */
    protected $SourceKey = null;

    /**
     * @param string $ClientIP
     * @param ueHash $PinHash
     * @param string $SourceKey
     */
    public function __construct($ClientIP, $PinHash, $SourceKey)
    {
      $this->ClientIP = $ClientIP;
      $this->PinHash = $PinHash;
      $this->SourceKey = $SourceKey;
    }

    /**
     * @return string
     */
    public function getClientIP()
    {
      return $this->ClientIP;
    }

    /**
     * @param string $ClientIP
     * @return \TenantSync\Billing\UsaEpaySoap\ueSecurityToken
     */
    public function setClientIP($ClientIP)
    {
      $this->ClientIP = $ClientIP;
      return $this;
    }

    /**
     * @return ueHash
     */
    public function getPinHash()
    {
      return $this->PinHash;
    }

    /**
     * @param ueHash $PinHash
     * @return \TenantSync\Billing\UsaEpaySoap\ueSecurityToken
     */
    public function setPinHash($PinHash)
    {
      $this->PinHash = $PinHash;
      return $this;
    }

    /**
     * @return string
     */
    public function getSourceKey()
    {
      return $this->SourceKey;
    }

    /**
     * @param string $SourceKey
     * @return \TenantSync\Billing\UsaEpaySoap\ueSecurityToken
     */
    public function setSourceKey($SourceKey)
    {
      $this->SourceKey = $SourceKey;
      return $this;
    }

}
