<?php

namespace TenantSync\Billing\UsaEpaySoap;

class FieldValueArray
{

    /**
     * @var FieldValue[] $FieldValueArray
     */
    protected $FieldValueArray = null;

    /**
     * @param FieldValue[] $FieldValueArray
     */
    public function __construct(array $FieldValueArray)
    {
      $this->FieldValueArray = $FieldValueArray;
    }

    /**
     * @return FieldValue[]
     */
    public function getFieldValueArray()
    {
      return $this->FieldValueArray;
    }

    /**
     * @param FieldValue[] $FieldValueArray
     * @return \TenantSync\Billing\UsaEpaySoap\FieldValueArray
     */
    public function setFieldValueArray(array $FieldValueArray)
    {
      $this->FieldValueArray = $FieldValueArray;
      return $this;
    }

}
