<?php

namespace TenantSync\Billing\UsaEpaySoap;

class Bank
{

    /**
     * @var string $Code
     */
    protected $Code = null;

    /**
     * @var string $Name
     */
    protected $Name = null;

    /**
     * @param string $Code
     * @param string $Name
     */
    public function __construct($Code, $Name)
    {
      $this->Code = $Code;
      $this->Name = $Name;
    }

    /**
     * @return string
     */
    public function getCode()
    {
      return $this->Code;
    }

    /**
     * @param string $Code
     * @return \TenantSync\Billing\UsaEpaySoap\Bank
     */
    public function setCode($Code)
    {
      $this->Code = $Code;
      return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
      return $this->Name;
    }

    /**
     * @param string $Name
     * @return \TenantSync\Billing\UsaEpaySoap\Bank
     */
    public function setName($Name)
    {
      $this->Name = $Name;
      return $this;
    }

}
