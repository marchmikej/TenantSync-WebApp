<?php

namespace TenantSync\Billing\UsaEpaySoap;

class PaymentMethodArray
{

    /**
     * @var PaymentMethod[] $PaymentMethodArray
     */
    protected $PaymentMethodArray = null;

    /**
     * @param PaymentMethod[] $PaymentMethodArray
     */
    public function __construct(array $PaymentMethodArray)
    {
      $this->PaymentMethodArray = $PaymentMethodArray;
    }

    /**
     * @return PaymentMethod[]
     */
    public function getPaymentMethodArray()
    {
      return $this->PaymentMethodArray;
    }

    /**
     * @param PaymentMethod[] $PaymentMethodArray
     * @return \TenantSync\Billing\UsaEpaySoap\PaymentMethodArray
     */
    public function setPaymentMethodArray(array $PaymentMethodArray)
    {
      $this->PaymentMethodArray = $PaymentMethodArray;
      return $this;
    }

}
