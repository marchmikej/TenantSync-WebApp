<?php

namespace TenantSync\Billing\UsaEpaySoap;

class TransactionResponse
{

    /**
     * @var string $AcsUrl
     */
    protected $AcsUrl = null;

    /**
     * @var float $AuthAmount
     */
    protected $AuthAmount = null;

    /**
     * @var string $AuthCode
     */
    protected $AuthCode = null;

    /**
     * @var string $AvsResult
     */
    protected $AvsResult = null;

    /**
     * @var string $AvsResultCode
     */
    protected $AvsResultCode = null;

    /**
     * @var int $BatchNum
     */
    protected $BatchNum = null;

    /**
     * @var int $BatchRefNum
     */
    protected $BatchRefNum = null;

    /**
     * @var string $CardCodeResult
     */
    protected $CardCodeResult = null;

    /**
     * @var string $CardCodeResultCode
     */
    protected $CardCodeResultCode = null;

    /**
     * @var string $CardLevelResult
     */
    protected $CardLevelResult = null;

    /**
     * @var string $CardLevelResultCode
     */
    protected $CardLevelResultCode = null;

    /**
     * @var float $ConversionRate
     */
    protected $ConversionRate = null;

    /**
     * @var float $ConvertedAmount
     */
    protected $ConvertedAmount = null;

    /**
     * @var string $ConvertedAmountCurrency
     */
    protected $ConvertedAmountCurrency = null;

    /**
     * @var int $CustNum
     */
    protected $CustNum = null;

    /**
     * @var string $Error
     */
    protected $Error = null;

    /**
     * @var int $ErrorCode
     */
    protected $ErrorCode = null;

    /**
     * @var boolean $isDuplicate
     */
    protected $isDuplicate = null;

    /**
     * @var string $Payload
     */
    protected $Payload = null;

    /**
     * @var int $RefNum
     */
    protected $RefNum = null;

    /**
     * @var float $RemainingBalance
     */
    protected $RemainingBalance = null;

    /**
     * @var string $Result
     */
    protected $Result = null;

    /**
     * @var string $ResultCode
     */
    protected $ResultCode = null;

    /**
     * @var string $Status
     */
    protected $Status = null;

    /**
     * @var string $StatusCode
     */
    protected $StatusCode = null;

    /**
     * @var string $VpasResultCode
     */
    protected $VpasResultCode = null;

    /**
     * @param string $AcsUrl
     * @param float $AuthAmount
     * @param string $AuthCode
     * @param string $AvsResult
     * @param string $AvsResultCode
     * @param int $BatchNum
     * @param int $BatchRefNum
     * @param string $CardCodeResult
     * @param string $CardCodeResultCode
     * @param string $CardLevelResult
     * @param string $CardLevelResultCode
     * @param float $ConversionRate
     * @param float $ConvertedAmount
     * @param string $ConvertedAmountCurrency
     * @param int $CustNum
     * @param string $Error
     * @param int $ErrorCode
     * @param boolean $isDuplicate
     * @param string $Payload
     * @param int $RefNum
     * @param string $Result
     * @param string $ResultCode
     * @param string $Status
     * @param string $StatusCode
     * @param string $VpasResultCode
     */
    public function __construct($AcsUrl, $AuthAmount, $AuthCode, $AvsResult, $AvsResultCode, $BatchNum, $BatchRefNum, $CardCodeResult, $CardCodeResultCode, $CardLevelResult, $CardLevelResultCode, $ConversionRate, $ConvertedAmount, $ConvertedAmountCurrency, $CustNum, $Error, $ErrorCode, $isDuplicate, $Payload, $RefNum, $Result, $ResultCode, $Status, $StatusCode, $VpasResultCode)
    {
      $this->AcsUrl = $AcsUrl;
      $this->AuthAmount = $AuthAmount;
      $this->AuthCode = $AuthCode;
      $this->AvsResult = $AvsResult;
      $this->AvsResultCode = $AvsResultCode;
      $this->BatchNum = $BatchNum;
      $this->BatchRefNum = $BatchRefNum;
      $this->CardCodeResult = $CardCodeResult;
      $this->CardCodeResultCode = $CardCodeResultCode;
      $this->CardLevelResult = $CardLevelResult;
      $this->CardLevelResultCode = $CardLevelResultCode;
      $this->ConversionRate = $ConversionRate;
      $this->ConvertedAmount = $ConvertedAmount;
      $this->ConvertedAmountCurrency = $ConvertedAmountCurrency;
      $this->CustNum = $CustNum;
      $this->Error = $Error;
      $this->ErrorCode = $ErrorCode;
      $this->isDuplicate = $isDuplicate;
      $this->Payload = $Payload;
      $this->RefNum = $RefNum;
      $this->Result = $Result;
      $this->ResultCode = $ResultCode;
      $this->Status = $Status;
      $this->StatusCode = $StatusCode;
      $this->VpasResultCode = $VpasResultCode;
    }

    /**
     * @return string
     */
    public function getAcsUrl()
    {
      return $this->AcsUrl;
    }

    /**
     * @param string $AcsUrl
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setAcsUrl($AcsUrl)
    {
      $this->AcsUrl = $AcsUrl;
      return $this;
    }

    /**
     * @return float
     */
    public function getAuthAmount()
    {
      return $this->AuthAmount;
    }

    /**
     * @param float $AuthAmount
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setAuthAmount($AuthAmount)
    {
      $this->AuthAmount = $AuthAmount;
      return $this;
    }

    /**
     * @return string
     */
    public function getAuthCode()
    {
      return $this->AuthCode;
    }

    /**
     * @param string $AuthCode
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setAuthCode($AuthCode)
    {
      $this->AuthCode = $AuthCode;
      return $this;
    }

    /**
     * @return string
     */
    public function getAvsResult()
    {
      return $this->AvsResult;
    }

    /**
     * @param string $AvsResult
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setAvsResult($AvsResult)
    {
      $this->AvsResult = $AvsResult;
      return $this;
    }

    /**
     * @return string
     */
    public function getAvsResultCode()
    {
      return $this->AvsResultCode;
    }

    /**
     * @param string $AvsResultCode
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setAvsResultCode($AvsResultCode)
    {
      $this->AvsResultCode = $AvsResultCode;
      return $this;
    }

    /**
     * @return int
     */
    public function getBatchNum()
    {
      return $this->BatchNum;
    }

    /**
     * @param int $BatchNum
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setBatchNum($BatchNum)
    {
      $this->BatchNum = $BatchNum;
      return $this;
    }

    /**
     * @return int
     */
    public function getBatchRefNum()
    {
      return $this->BatchRefNum;
    }

    /**
     * @param int $BatchRefNum
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setBatchRefNum($BatchRefNum)
    {
      $this->BatchRefNum = $BatchRefNum;
      return $this;
    }

    /**
     * @return string
     */
    public function getCardCodeResult()
    {
      return $this->CardCodeResult;
    }

    /**
     * @param string $CardCodeResult
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setCardCodeResult($CardCodeResult)
    {
      $this->CardCodeResult = $CardCodeResult;
      return $this;
    }

    /**
     * @return string
     */
    public function getCardCodeResultCode()
    {
      return $this->CardCodeResultCode;
    }

    /**
     * @param string $CardCodeResultCode
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setCardCodeResultCode($CardCodeResultCode)
    {
      $this->CardCodeResultCode = $CardCodeResultCode;
      return $this;
    }

    /**
     * @return string
     */
    public function getCardLevelResult()
    {
      return $this->CardLevelResult;
    }

    /**
     * @param string $CardLevelResult
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setCardLevelResult($CardLevelResult)
    {
      $this->CardLevelResult = $CardLevelResult;
      return $this;
    }

    /**
     * @return string
     */
    public function getCardLevelResultCode()
    {
      return $this->CardLevelResultCode;
    }

    /**
     * @param string $CardLevelResultCode
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setCardLevelResultCode($CardLevelResultCode)
    {
      $this->CardLevelResultCode = $CardLevelResultCode;
      return $this;
    }

    /**
     * @return float
     */
    public function getConversionRate()
    {
      return $this->ConversionRate;
    }

    /**
     * @param float $ConversionRate
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setConversionRate($ConversionRate)
    {
      $this->ConversionRate = $ConversionRate;
      return $this;
    }

    /**
     * @return float
     */
    public function getConvertedAmount()
    {
      return $this->ConvertedAmount;
    }

    /**
     * @param float $ConvertedAmount
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setConvertedAmount($ConvertedAmount)
    {
      $this->ConvertedAmount = $ConvertedAmount;
      return $this;
    }

    /**
     * @return string
     */
    public function getConvertedAmountCurrency()
    {
      return $this->ConvertedAmountCurrency;
    }

    /**
     * @param string $ConvertedAmountCurrency
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setConvertedAmountCurrency($ConvertedAmountCurrency)
    {
      $this->ConvertedAmountCurrency = $ConvertedAmountCurrency;
      return $this;
    }

    /**
     * @return int
     */
    public function getCustNum()
    {
      return $this->CustNum;
    }

    /**
     * @param int $CustNum
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setCustNum($CustNum)
    {
      $this->CustNum = $CustNum;
      return $this;
    }

    /**
     * @return string
     */
    public function getError()
    {
      return $this->Error;
    }

    /**
     * @param string $Error
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setError($Error)
    {
      $this->Error = $Error;
      return $this;
    }

    /**
     * @return int
     */
    public function getErrorCode()
    {
      return $this->ErrorCode;
    }

    /**
     * @param int $ErrorCode
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setErrorCode($ErrorCode)
    {
      $this->ErrorCode = $ErrorCode;
      return $this;
    }

    /**
     * @return boolean
     */
    public function getIsDuplicate()
    {
      return $this->isDuplicate;
    }

    /**
     * @param boolean $isDuplicate
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setIsDuplicate($isDuplicate)
    {
      $this->isDuplicate = $isDuplicate;
      return $this;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
      return $this->Payload;
    }

    /**
     * @param string $Payload
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setPayload($Payload)
    {
      $this->Payload = $Payload;
      return $this;
    }

    /**
     * @return int
     */
    public function getRefNum()
    {
      return $this->RefNum;
    }

    /**
     * @param int $RefNum
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setRefNum($RefNum)
    {
      $this->RefNum = $RefNum;
      return $this;
    }

    /**
     * @return float
     */
    public function getRemainingBalance()
    {
      return $this->RemainingBalance;
    }

    /**
     * @param float $RemainingBalance
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setRemainingBalance($RemainingBalance)
    {
      $this->RemainingBalance = $RemainingBalance;
      return $this;
    }

    /**
     * @return string
     */
    public function getResult()
    {
      return $this->Result;
    }

    /**
     * @param string $Result
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setResult($Result)
    {
      $this->Result = $Result;
      return $this;
    }

    /**
     * @return string
     */
    public function getResultCode()
    {
      return $this->ResultCode;
    }

    /**
     * @param string $ResultCode
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setResultCode($ResultCode)
    {
      $this->ResultCode = $ResultCode;
      return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
      return $this->Status;
    }

    /**
     * @param string $Status
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setStatus($Status)
    {
      $this->Status = $Status;
      return $this;
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
      return $this->StatusCode;
    }

    /**
     * @param string $StatusCode
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setStatusCode($StatusCode)
    {
      $this->StatusCode = $StatusCode;
      return $this;
    }

    /**
     * @return string
     */
    public function getVpasResultCode()
    {
      return $this->VpasResultCode;
    }

    /**
     * @param string $VpasResultCode
     * @return \TenantSync\Billing\UsaEpaySoap\TransactionResponse
     */
    public function setVpasResultCode($VpasResultCode)
    {
      $this->VpasResultCode = $VpasResultCode;
      return $this;
    }

}
