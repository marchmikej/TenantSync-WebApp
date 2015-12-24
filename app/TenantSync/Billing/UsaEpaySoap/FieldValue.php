<?php

namespace TenantSync\Billing\UsaEpaySoap;

class FieldValue
{

    /**
     * @var string $Field
     */
    protected $Field = null;

    /**
     * @var string $Value
     */
    protected $Value = null;

    /**
     * @param string $Field
     * @param string $Value
     */
    public function __construct($Field, $Value)
    {
      $this->Field = $Field;
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
     * @return \TenantSync\Billing\UsaEpaySoap\FieldValue
     */
    public function setField($Field)
    {
      $this->Field = $Field;
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
     * @return \TenantSync\Billing\UsaEpaySoap\FieldValue
     */
    public function setValue($Value)
    {
      $this->Value = $Value;
      return $this;
    }

}
