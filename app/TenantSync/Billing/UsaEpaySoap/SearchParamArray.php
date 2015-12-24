<?php

namespace TenantSync\Billing\UsaEpaySoap;

class SearchParamArray
{

    /**
     * @var SearchParam[] $SearchParamArray
     */
    protected $SearchParamArray = null;

    /**
     * @param SearchParam[] $SearchParamArray
     */
    public function __construct(array $SearchParamArray)
    {
      $this->SearchParamArray = $SearchParamArray;
    }

    /**
     * @return SearchParam[]
     */
    public function getSearchParamArray()
    {
      return $this->SearchParamArray;
    }

    /**
     * @param SearchParam[] $SearchParamArray
     * @return \TenantSync\Billing\UsaEpaySoap\SearchParamArray
     */
    public function setSearchParamArray(array $SearchParamArray)
    {
      $this->SearchParamArray = $SearchParamArray;
      return $this;
    }

}
