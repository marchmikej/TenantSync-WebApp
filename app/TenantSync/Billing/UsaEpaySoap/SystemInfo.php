<?php

namespace TenantSync\Billing\UsaEpaySoap;

class SystemInfo
{

    /**
     * @var string $ApiVersion
     */
    protected $ApiVersion = null;

    /**
     * @var string $Environment
     */
    protected $Environment = null;

    /**
     * @var string $Datacenter
     */
    protected $Datacenter = null;

    /**
     * @var string $Time
     */
    protected $Time = null;

    /**
     * @param string $ApiVersion
     * @param string $Environment
     * @param string $Datacenter
     * @param string $Time
     */
    public function __construct($ApiVersion, $Environment, $Datacenter, $Time)
    {
      $this->ApiVersion = $ApiVersion;
      $this->Environment = $Environment;
      $this->Datacenter = $Datacenter;
      $this->Time = $Time;
    }

    /**
     * @return string
     */
    public function getApiVersion()
    {
      return $this->ApiVersion;
    }

    /**
     * @param string $ApiVersion
     * @return \TenantSync\Billing\UsaEpaySoap\SystemInfo
     */
    public function setApiVersion($ApiVersion)
    {
      $this->ApiVersion = $ApiVersion;
      return $this;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
      return $this->Environment;
    }

    /**
     * @param string $Environment
     * @return \TenantSync\Billing\UsaEpaySoap\SystemInfo
     */
    public function setEnvironment($Environment)
    {
      $this->Environment = $Environment;
      return $this;
    }

    /**
     * @return string
     */
    public function getDatacenter()
    {
      return $this->Datacenter;
    }

    /**
     * @param string $Datacenter
     * @return \TenantSync\Billing\UsaEpaySoap\SystemInfo
     */
    public function setDatacenter($Datacenter)
    {
      $this->Datacenter = $Datacenter;
      return $this;
    }

    /**
     * @return string
     */
    public function getTime()
    {
      return $this->Time;
    }

    /**
     * @param string $Time
     * @return \TenantSync\Billing\UsaEpaySoap\SystemInfo
     */
    public function setTime($Time)
    {
      $this->Time = $Time;
      return $this;
    }

}
