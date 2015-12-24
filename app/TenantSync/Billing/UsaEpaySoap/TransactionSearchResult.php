<?php

namespace TenantSync\Billing\UsaEpaySoap;

class TransactionSearchResult
{

    /**
     * @var float $AuthOnlyAmount
     */
    protected $AuthOnlyAmount = null;

    /**
     * @var int $AuthOnlyCount
     */
    protected $AuthOnlyCount = null;

    /**
     * @var float $CreditsAmount
     */
    protected $CreditsAmount = null;

    /**
     * @var int $CreditsCount
     */
    protected $CreditsCount = null;

    /**
     * @var float $DeclinesAmount
     */
    protected $DeclinesAmount = null;

    /**
     * @var int $DeclinesCount
     */
    protected $DeclinesCount = null;

    /**
     * @var float $ErrorsAmount
     */
    protected $ErrorsAmount = null;

    /**
     * @var int $ErrorsCount
     */
    protected $ErrorsCount = null;

    /**
     * @var int $Limit
     */
    protected $Limit = null;

    /**
     * @var float $SalesAmount
     */
    protected $SalesAmount = null;

    /**
     * @var int $SalesCount
     */
    protected $SalesCount = null;

    /**
     * @var int $StartIndex
     */
    protected $StartIndex = null;

    /**
     * @var TransactionObjectArray $Transactions
     */
    protected $Transactions = null;

    /**
     * @var int $TransactionsMatched
     */
    protected $TransactionsMatched = null;

    /**
     * @var int $TransactionsReturned
     */
    protected $TransactionsReturned = null;

    /**
     * @var float $VoidsAmount
     */
    protected $VoidsAmount = null;

    /**
     * @var int $VoidsCount
     */
    protected $VoidsCount = null;

    /**
     * @param float $AuthOnlyAmount
     * @param int $AuthOnlyCount
     * @param float $CreditsAmount
     * @param int $CreditsCount
     * @param float $DeclinesAmount
     * @param int $DeclinesCount
     * @param float $ErrorsAmount
     * @param int $ErrorsCount
     * @param int $Limit
     * @param float $SalesAmount
     * @param int $SalesCount
     * @param int $StartIndex
     * @param TransactionObjectArray $Transactions
     * @param int $TransactionsMatched
     * @param int $TransactionsReturned
     * @param float $VoidsAmount
     * @param int $VoidsCount
     */
    public function __construct($AuthOnlyAmount, $AuthOnlyCount, $CreditsAmount, $CreditsCount, $DeclinesAmount, $DeclinesCount, $ErrorsAmount, $ErrorsCount, $Limit, $SalesAmount, $SalesCount, $StartIndex, $Transactions, $TransactionsMatched, $TransactionsReturned, $VoidsAmount, $VoidsCount)
    {
      $this->AuthOnlyAmount = $AuthOnlyAmount;
      $this->AuthOnlyCount = $AuthOnlyCount;
      $this->CreditsAmount = $CreditsAmount;
      $this->CreditsCount = $CreditsCount;
      $this->DeclinesAmount = $DeclinesAmount;
      $this->DeclinesCount = $DeclinesCount;
      $this->ErrorsAmount = $ErrorsAmount;
      $this->ErrorsCount = $ErrorsCount;
      $this->Limit = $Limit;
      $this->SalesAmount = $SalesAmount;
      $this->SalesCount = $SalesCount;
      $this->StartIndex = $StartIndex;
      $this->Transactions = $Transactions;
      $this->TransactionsMatched = $TransactionsMatched;
      $this->TransactionsReturned = $TransactionsReturned;
      $this->VoidsAmount = $VoidsAmount;
      $this->VoidsCount = $VoidsCount;
    }

    /**
     * @return float
     */
    public function getAuthOnlyAmount()
    {
      return $this->AuthOnlyAmount;
    }

    /**
     * @param float $AuthOnlyAmount
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setAuthOnlyAmount($AuthOnlyAmount)
    {
      $this->AuthOnlyAmount = $AuthOnlyAmount;
      return $this;
    }

    /**
     * @return int
     */
    public function getAuthOnlyCount()
    {
      return $this->AuthOnlyCount;
    }

    /**
     * @param int $AuthOnlyCount
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setAuthOnlyCount($AuthOnlyCount)
    {
      $this->AuthOnlyCount = $AuthOnlyCount;
      return $this;
    }

    /**
     * @return float
     */
    public function getCreditsAmount()
    {
      return $this->CreditsAmount;
    }

    /**
     * @param float $CreditsAmount
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setCreditsAmount($CreditsAmount)
    {
      $this->CreditsAmount = $CreditsAmount;
      return $this;
    }

    /**
     * @return int
     */
    public function getCreditsCount()
    {
      return $this->CreditsCount;
    }

    /**
     * @param int $CreditsCount
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setCreditsCount($CreditsCount)
    {
      $this->CreditsCount = $CreditsCount;
      return $this;
    }

    /**
     * @return float
     */
    public function getDeclinesAmount()
    {
      return $this->DeclinesAmount;
    }

    /**
     * @param float $DeclinesAmount
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setDeclinesAmount($DeclinesAmount)
    {
      $this->DeclinesAmount = $DeclinesAmount;
      return $this;
    }

    /**
     * @return int
     */
    public function getDeclinesCount()
    {
      return $this->DeclinesCount;
    }

    /**
     * @param int $DeclinesCount
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setDeclinesCount($DeclinesCount)
    {
      $this->DeclinesCount = $DeclinesCount;
      return $this;
    }

    /**
     * @return float
     */
    public function getErrorsAmount()
    {
      return $this->ErrorsAmount;
    }

    /**
     * @param float $ErrorsAmount
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setErrorsAmount($ErrorsAmount)
    {
      $this->ErrorsAmount = $ErrorsAmount;
      return $this;
    }

    /**
     * @return int
     */
    public function getErrorsCount()
    {
      return $this->ErrorsCount;
    }

    /**
     * @param int $ErrorsCount
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setErrorsCount($ErrorsCount)
    {
      $this->ErrorsCount = $ErrorsCount;
      return $this;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
      return $this->Limit;
    }

    /**
     * @param int $Limit
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setLimit($Limit)
    {
      $this->Limit = $Limit;
      return $this;
    }

    /**
     * @return float
     */
    public function getSalesAmount()
    {
      return $this->SalesAmount;
    }

    /**
     * @param float $SalesAmount
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setSalesAmount($SalesAmount)
    {
      $this->SalesAmount = $SalesAmount;
      return $this;
    }

    /**
     * @return int
     */
    public function getSalesCount()
    {
      return $this->SalesCount;
    }

    /**
     * @param int $SalesCount
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setSalesCount($SalesCount)
    {
      $this->SalesCount = $SalesCount;
      return $this;
    }

    /**
     * @return int
     */
    public function getStartIndex()
    {
      return $this->StartIndex;
    }

    /**
     * @param int $StartIndex
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setStartIndex($StartIndex)
    {
      $this->StartIndex = $StartIndex;
      return $this;
    }

    /**
     * @return TransactionObjectArray
     */
    public function getTransactions()
    {
      return $this->Transactions;
    }

    /**
     * @param TransactionObjectArray $Transactions
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setTransactions($Transactions)
    {
      $this->Transactions = $Transactions;
      return $this;
    }

    /**
     * @return int
     */
    public function getTransactionsMatched()
    {
      return $this->TransactionsMatched;
    }

    /**
     * @param int $TransactionsMatched
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setTransactionsMatched($TransactionsMatched)
    {
      $this->TransactionsMatched = $TransactionsMatched;
      return $this;
    }

    /**
     * @return int
     */
    public function getTransactionsReturned()
    {
      return $this->TransactionsReturned;
    }

    /**
     * @param int $TransactionsReturned
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setTransactionsReturned($TransactionsReturned)
    {
      $this->TransactionsReturned = $TransactionsReturned;
      return $this;
    }

    /**
     * @return float
     */
    public function getVoidsAmount()
    {
      return $this->VoidsAmount;
    }

    /**
     * @param float $VoidsAmount
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setVoidsAmount($VoidsAmount)
    {
      $this->VoidsAmount = $VoidsAmount;
      return $this;
    }

    /**
     * @return int
     */
    public function getVoidsCount()
    {
      return $this->VoidsCount;
    }

    /**
     * @param int $VoidsCount
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionSearchResult
     */
    public function setVoidsCount($VoidsCount)
    {
      $this->VoidsCount = $VoidsCount;
      return $this;
    }

}
