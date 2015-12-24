<?php

namespace TenantSync\Billing\UsaEpaySoap;

class SearchParam
{

    /**
     * @var string $Field
     */
    protected $Field = null;

    /**
     * @var string $Type
     */
    protected $Type = null;

    /**
     * @var string $Value
     */
    protected $Value = null;

    /**
     * @param string $Field
     * @param string $Type
     * @param string $Value
     */
    public function __construct($Field, $Type, $Value)
    {
      $this->Field = $Field;
      $this->Type = $Type;
      $this->Value = $Value;
    }

    /**
     * @return string
     */
    public function getField()
    {
      return $this->Field;
    }

    /**
     * @param string $Field
     * @return \TenantSync\Billing\UsaEpaySoap\SearchParam
     */
    public function setField($Field)
    {
      $this->Field = $Field;
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
     * @return \TenantSync\Billing\UsaEpaySoap\SearchParam
     */
    public function setType($Type)
    {
      $this->Type = $Type;
      return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
      return $this->Value;
    }

    /**
     * @param string $Value
     * @return \TenantSync\Billing\UsaEpaySoap\SearchParam
     */
    public function setValue($Value)
    {
      $this->Value = $Value;
      return $this;
    }

}
