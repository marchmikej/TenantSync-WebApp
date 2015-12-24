<?php

namespace TenantSync\Billing\UsaEpaySoap;

class doubleArray
{

    /**
     * @var double[] $doubleArray
     */
    protected $doubleArray = null;

    /**
     * @param double[] $doubleArray
     */
    public function __construct(array $doubleArray)
    {
      $this->doubleArray = $doubleArray;
    }

    /**
     * @return double[]
     */
    public function getDoubleArray()
    {
      return $this->doubleArray;
    }

    /**
     * @param double[] $doubleArray
     * @return \TenantSync\Billing\UsaEpaySoap\doubleArray
     */
    public function setDoubleArray(array $doubleArray)
    {
      $this->doubleArray = $doubleArray;
      return $this;
    }

}
