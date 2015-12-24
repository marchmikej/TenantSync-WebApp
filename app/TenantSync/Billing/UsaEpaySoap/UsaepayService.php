<?php

namespace TenantSync\Billing\UsaEpaySoap;

class UsaepayService extends \SoapClient
{

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array (
      'AccountDetails' => 'TenantSync\\Billing\\UsaEpaySoap\\AccountDetails',
      'Address' => 'TenantSync\\Billing\\UsaEpaySoap\\Address',
      'Bank' => 'TenantSync\\Billing\\UsaEpaySoap\\Bank',
      'BankArray' => 'TenantSync\\Billing\\UsaEpaySoap\\BankArray',
      'BatchSearchResult' => 'TenantSync\\Billing\\UsaEpaySoap\\BatchSearchResult',
      'BatchStatus' => 'TenantSync\\Billing\\UsaEpaySoap\\BatchStatus',
      'BatchStatusArray' => 'TenantSync\\Billing\\UsaEpaySoap\\BatchStatusArray',
      'BatchUploadStatus' => 'TenantSync\\Billing\\UsaEpaySoap\\BatchUploadStatus',
      'CheckData' => 'TenantSync\\Billing\\UsaEpaySoap\\CheckData',
      'CheckTrace' => 'TenantSync\\Billing\\UsaEpaySoap\\CheckTrace',
      'CreditCardData' => 'TenantSync\\Billing\\UsaEpaySoap\\CreditCardData',
      'CurrencyConversion' => 'TenantSync\\Billing\\UsaEpaySoap\\CurrencyConversion',
      'CurrencyConversionArray' => 'TenantSync\\Billing\\UsaEpaySoap\\CurrencyConversionArray',
      'CurrencyObject' => 'TenantSync\\Billing\\UsaEpaySoap\\CurrencyObject',
      'CurrencyObjectArray' => 'TenantSync\\Billing\\UsaEpaySoap\\CurrencyObjectArray',
      'CustomerObject' => 'TenantSync\\Billing\\UsaEpaySoap\\CustomerObject',
      'CustomerObjectArray' => 'TenantSync\\Billing\\UsaEpaySoap\\CustomerObjectArray',
      'CustomerSearchResult' => 'TenantSync\\Billing\\UsaEpaySoap\\CustomerSearchResult',
      'CustomerTransactionRequest' => 'TenantSync\\Billing\\UsaEpaySoap\\CustomerTransactionRequest',
      'doubleArray' => 'TenantSync\\Billing\\UsaEpaySoap\\doubleArray',
      'FieldValue' => 'TenantSync\\Billing\\UsaEpaySoap\\FieldValue',
      'FieldValueArray' => 'TenantSync\\Billing\\UsaEpaySoap\\FieldValueArray',
      'LineItem' => 'TenantSync\\Billing\\UsaEpaySoap\\LineItem',
      'LineItemArray' => 'TenantSync\\Billing\\UsaEpaySoap\\LineItemArray',
      'PaymentMethod' => 'TenantSync\\Billing\\UsaEpaySoap\\PaymentMethod',
      'PaymentMethodArray' => 'TenantSync\\Billing\\UsaEpaySoap\\PaymentMethodArray',
      'PriceTier' => 'TenantSync\\Billing\\UsaEpaySoap\\PriceTier',
      'PriceTierArray' => 'TenantSync\\Billing\\UsaEpaySoap\\PriceTierArray',
      'Product' => 'TenantSync\\Billing\\UsaEpaySoap\\Product',
      'ProductArray' => 'TenantSync\\Billing\\UsaEpaySoap\\ProductArray',
      'ProductCategory' => 'TenantSync\\Billing\\UsaEpaySoap\\ProductCategory',
      'ProductCategoryArray' => 'TenantSync\\Billing\\UsaEpaySoap\\ProductCategoryArray',
      'ProductInventory' => 'TenantSync\\Billing\\UsaEpaySoap\\ProductInventory',
      'ProductInventoryArray' => 'TenantSync\\Billing\\UsaEpaySoap\\ProductInventoryArray',
      'ProductSearchResult' => 'TenantSync\\Billing\\UsaEpaySoap\\ProductSearchResult',
      'Receipt' => 'TenantSync\\Billing\\UsaEpaySoap\\Receipt',
      'ReceiptArray' => 'TenantSync\\Billing\\UsaEpaySoap\\ReceiptArray',
      'RecurringBilling' => 'TenantSync\\Billing\\UsaEpaySoap\\RecurringBilling',
      'SearchParam' => 'TenantSync\\Billing\\UsaEpaySoap\\SearchParam',
      'SearchParamArray' => 'TenantSync\\Billing\\UsaEpaySoap\\SearchParamArray',
      'stringArray' => 'TenantSync\\Billing\\UsaEpaySoap\\stringArray',
      'SyncLog' => 'TenantSync\\Billing\\UsaEpaySoap\\SyncLog',
      'SyncLogArray' => 'TenantSync\\Billing\\UsaEpaySoap\\SyncLogArray',
      'SystemInfo' => 'TenantSync\\Billing\\UsaEpaySoap\\SystemInfo',
      'TransactionDetail' => 'TenantSync\\Billing\\UsaEpaySoap\\TransactionDetail',
      'TransactionObject' => 'TenantSync\\Billing\\UsaEpaySoap\\TransactionObject',
      'TransactionObjectArray' => 'TenantSync\\Billing\\UsaEpaySoap\\TransactionObjectArray',
      'TransactionRequestObject' => 'TenantSync\\Billing\\UsaEpaySoap\\TransactionRequestObject',
      'TransactionResponse' => 'TenantSync\\Billing\\UsaEpaySoap\\TransactionResponse',
      'TransactionSearchResult' => 'TenantSync\\Billing\\UsaEpaySoap\\TransactionSearchResult',
      'ueHash' => 'TenantSync\\Billing\\UsaEpaySoap\\ueHash',
      'ueSecurityToken' => 'TenantSync\\Billing\\UsaEpaySoap\\ueSecurityToken',
    );

    /**
     * @param array $options A array of config values
     * @param string $wsdl The wsdl file to use
     */
    public function __construct(array $options = array(), $wsdl = 'https://sandbox.usaepay.com/soap/gate/0AE595C1/usaepay.wsdl')
    {
      foreach (self::$classmap as $key => $value) {
        if (!isset($options['classmap'][$key])) {
          $options['classmap'][$key] = $value;
        }
      }
      $options = array_merge(array (
      'features' => 1,
    ), $options);
      parent::__construct($wsdl, $options);
    }

    /**
     * Add a Stored Customer Record
     *
     * @param ueSecurityToken $Token
     * @param CustomerObject $CustomerData
     * @return integer
     */
    public function addCustomer(ueSecurityToken $Token, CustomerObject $CustomerData)
    {
      return $this->__soapCall('addCustomer', array($Token, $CustomerData));
    }

    /**
     * Add Payment Method For a Customer
     *
     * @param ueSecurityToken $Token
     * @param integer $CustNum
     * @param PaymentMethod $PaymentMethod
     * @param boolean $MakeDefault
     * @param boolean $Verify
     * @return integer
     */
    public function addCustomerPaymentMethod(ueSecurityToken $Token, $CustNum, PaymentMethod $PaymentMethod, $MakeDefault, $Verify)
    {
      return $this->__soapCall('addCustomerPaymentMethod', array($Token, $CustNum, $PaymentMethod, $MakeDefault, $Verify));
    }

    /**
     * Add a new product
     *
     * @param ueSecurityToken $Token
     * @param Product $Product
     * @return string
     */
    public function addProduct(ueSecurityToken $Token, Product $Product)
    {
      return $this->__soapCall('addProduct', array($Token, $Product));
    }

    /**
     * Add a new product category
     *
     * @param ueSecurityToken $Token
     * @param ProductCategory $ProductCategory
     * @return string
     */
    public function addProductCategory(ueSecurityToken $Token, ProductCategory $ProductCategory)
    {
      return $this->__soapCall('addProductCategory', array($Token, $ProductCategory));
    }

    /**
     * Add a new receipt template
     *
     * @param ueSecurityToken $Token
     * @param Receipt $Receipt
     * @return integer
     */
    public function addReceipt(ueSecurityToken $Token, Receipt $Receipt)
    {
      return $this->__soapCall('addReceipt', array($Token, $Receipt));
    }

    /**
     * Adjust product inventory
     *
     * @param ueSecurityToken $Token
     * @param string $ProductRefNum
     * @param ProductInventoryArray $Inventory
     * @return ProductInventoryArray
     */
    public function adjustInventory(ueSecurityToken $Token, $ProductRefNum, ProductInventoryArray $Inventory)
    {
      return $this->__soapCall('adjustInventory', array($Token, $ProductRefNum, $Inventory));
    }

    /**
     * Convert multiple currency amounts in a single method call
     *
     * @param ueSecurityToken $Token
     * @param string $FromCurrency
     * @param string $ToCurrency
     * @param doubleArray $Amounts
     * @return CurrencyConversionArray
     */
    public function bulkCurrencyConversion(ueSecurityToken $Token, $FromCurrency, $ToCurrency, doubleArray $Amounts)
    {
      return $this->__soapCall('bulkCurrencyConversion', array($Token, $FromCurrency, $ToCurrency, $Amounts));
    }

    /**
     * Capture a queued transaction
     *
     * @param ueSecurityToken $Token
     * @param integer $RefNum
     * @param float $Amount
     * @return TransactionResponse
     */
    public function captureTransaction(ueSecurityToken $Token, $RefNum, $Amount)
    {
      return $this->__soapCall('captureTransaction', array($Token, $RefNum, $Amount));
    }

    /**
     * Close the batch specified by BatchRefNum
     *
     * @param ueSecurityToken $Token
     * @param integer $BatchRefNum
     * @return boolean
     */
    public function closeBatch(ueSecurityToken $Token, $BatchRefNum)
    {
      return $this->__soapCall('closeBatch', array($Token, $BatchRefNum));
    }

    /**
     * Convert existing transaction into a stored customer.
     *
     * @param ueSecurityToken $Token
     * @param integer $RefNum
     * @param FieldValueArray $UpdateData
     * @return integer
     */
    public function convertTranToCust(ueSecurityToken $Token, $RefNum, FieldValueArray $UpdateData)
    {
      return $this->__soapCall('convertTranToCust', array($Token, $RefNum, $UpdateData));
    }

    /**
     * Copy customer from one source key to another
     *
     * @param ueSecurityToken $CopyFromToken
     * @param integer $CustNum
     * @param ueSecurityToken $CopyToToken
     * @return integer
     */
    public function copyCustomer(ueSecurityToken $CopyFromToken, $CustNum, ueSecurityToken $CopyToToken)
    {
      return $this->__soapCall('copyCustomer', array($CopyFromToken, $CustNum, $CopyToToken));
    }

    /**
     * Post a new batch of transactions to the gateway for processing.
     *
     * @param ueSecurityToken $Token
     * @param string $FileName
     * @param boolean $AutoStart
     * @param string $Format
     * @param string $Encoding
     * @param stringArray $Fields
     * @param string $Data
     * @param boolean $OverrideDuplicates
     * @return BatchUploadStatus
     */
    public function createBatchUpload(ueSecurityToken $Token, $FileName, $AutoStart, $Format, $Encoding, stringArray $Fields, $Data, $OverrideDuplicates)
    {
      return $this->__soapCall('createBatchUpload', array($Token, $FileName, $AutoStart, $Format, $Encoding, $Fields, $Data, $OverrideDuplicates));
    }

    /**
     * Lookup currency conversion rate for single dollar amount.
     *
     * @param ueSecurityToken $Token
     * @param string $FromCurrency
     * @param string $ToCurrency
     * @param float $Amount
     * @return CurrencyConversion
     */
    public function currencyConversion(ueSecurityToken $Token, $FromCurrency, $ToCurrency, $Amount)
    {
      return $this->__soapCall('currencyConversion', array($Token, $FromCurrency, $ToCurrency, $Amount));
    }

    /**
     * Delete the customer specified by CustNum
     *
     * @param ueSecurityToken $Token
     * @param integer $CustNum
     * @return boolean
     */
    public function deleteCustomer(ueSecurityToken $Token, $CustNum)
    {
      return $this->__soapCall('deleteCustomer', array($Token, $CustNum));
    }

    /**
     * Delete Payment Method
     *
     * @param ueSecurityToken $Token
     * @param integer $Custnum
     * @param integer $PaymentMethodID
     * @return boolean
     */
    public function deleteCustomerPaymentMethod(ueSecurityToken $Token, $Custnum, $PaymentMethodID)
    {
      return $this->__soapCall('deleteCustomerPaymentMethod', array($Token, $Custnum, $PaymentMethodID));
    }

    /**
     * Delete product specified by ProductRefNum.
     *
     * @param ueSecurityToken $Token
     * @param string $ProductRefNum
     * @return boolean
     */
    public function deleteProduct(ueSecurityToken $Token, $ProductRefNum)
    {
      return $this->__soapCall('deleteProduct', array($Token, $ProductRefNum));
    }

    /**
     * Delete product category specified by ProductCategoryRefNum.
     *
     * @param ueSecurityToken $Token
     * @param string $ProductCategoryRefNum
     * @return boolean
     */
    public function deleteProductCategory(ueSecurityToken $Token, $ProductCategoryRefNum)
    {
      return $this->__soapCall('deleteProductCategory', array($Token, $ProductCategoryRefNum));
    }

    /**
     * Delete a customer receipt template
     *
     * @param ueSecurityToken $Token
     * @param integer $ReceiptRefNum
     * @return boolean
     */
    public function deleteReceipt(ueSecurityToken $Token, $ReceiptRefNum)
    {
      return $this->__soapCall('deleteReceipt', array($Token, $ReceiptRefNum));
    }

    /**
     * Disable the recurring billing for the customer specified by CustNum
     *
     * @param ueSecurityToken $Token
     * @param integer $CustNum
     * @return boolean
     */
    public function disableCustomer(ueSecurityToken $Token, $CustNum)
    {
      return $this->__soapCall('disableCustomer', array($Token, $CustNum));
    }

    /**
     * Enable recurring billing for the customer specified by CustNum
     *
     * @param ueSecurityToken $Token
     * @param integer $CustNum
     * @return boolean
     */
    public function enableCustomer(ueSecurityToken $Token, $CustNum)
    {
      return $this->__soapCall('enableCustomer', array($Token, $CustNum));
    }

    /**
     * Email a transaction receipt specified by ReceiptRefNum
     *
     * @param ueSecurityToken $Token
     * @param integer $RefNum
     * @param integer $ReceiptRefNum
     * @param string $Email
     * @return boolean
     */
    public function emailTransactionReceipt(ueSecurityToken $Token, $RefNum, $ReceiptRefNum, $Email)
    {
      return $this->__soapCall('emailTransactionReceipt', array($Token, $RefNum, $ReceiptRefNum, $Email));
    }

    /**
     * Email a transaction receipt specied by ReceiptName
     *
     * @param ueSecurityToken $Token
     * @param integer $RefNum
     * @param string $ReceiptName
     * @param string $Email
     * @return boolean
     */
    public function emailTransactionReceiptByName(ueSecurityToken $Token, $RefNum, $ReceiptName, $Email)
    {
      return $this->__soapCall('emailTransactionReceiptByName', array($Token, $RefNum, $ReceiptName, $Email));
    }

    /**
     * Retrieves Information about Merchants account
     *
     * @param ueSecurityToken $Token
     * @return AccountDetails
     */
    public function getAccountDetails(ueSecurityToken $Token)
    {
      return $this->__soapCall('getAccountDetails', array($Token));
    }

    /**
     * Retrieves list of banks and financial institutions available for direct payment
     *
     * @param ueSecurityToken $Token
     * @return BankArray
     */
    public function getBankList(ueSecurityToken $Token)
    {
      return $this->__soapCall('getBankList', array($Token));
    }

    /**
     * Retrieve the status of the batch specified by BatchRefNum
     *
     * @param ueSecurityToken $Token
     * @param integer $BatchRefNum
     * @return BatchStatus
     */
    public function getBatchStatus(ueSecurityToken $Token, $BatchRefNum)
    {
      return $this->__soapCall('getBatchStatus', array($Token, $BatchRefNum));
    }

    /**
     * Retrieve transactions in the batch specified by BatchRefNum
     *
     * @param ueSecurityToken $Token
     * @param integer $BatchRefNum
     * @return TransactionObjectArray
     */
    public function getBatchTransactions(ueSecurityToken $Token, $BatchRefNum)
    {
      return $this->__soapCall('getBatchTransactions', array($Token, $BatchRefNum));
    }

    /**
     * Retrieve the status of the currently running batch.
     *
     * @param ueSecurityToken $Token
     * @param integer $UploadRefNum
     * @return BatchUploadStatus
     */
    public function getBatchUploadStatus(ueSecurityToken $Token, $UploadRefNum)
    {
      return $this->__soapCall('getBatchUploadStatus', array($Token, $UploadRefNum));
    }

    /**
     * Retreive all check status data for the transactions specified by RefNum
     *
     * @param ueSecurityToken $Token
     * @param integer $RefNum
     * @return CheckTrace
     */
    public function getCheckTrace(ueSecurityToken $Token, $RefNum)
    {
      return $this->__soapCall('getCheckTrace', array($Token, $RefNum));
    }

    /**
     * Retrieve the customer details for the given CustNum
     *
     * @param ueSecurityToken $Token
     * @param integer $CustNum
     * @return CustomerObject
     */
    public function getCustomer(ueSecurityToken $Token, $CustNum)
    {
      return $this->__soapCall('getCustomer', array($Token, $CustNum));
    }

    /**
     * Pull details of all transactions run for CustNum
     *
     * @param ueSecurityToken $Token
     * @param integer $CustNum
     * @return TransactionSearchResult
     */
    public function getCustomerHistory(ueSecurityToken $Token, $CustNum)
    {
      return $this->__soapCall('getCustomerHistory', array($Token, $CustNum));
    }

    /**
     * Retrieve a specific customer Payment Methods for the given CustNum/MethodID
     *
     * @param ueSecurityToken $Token
     * @param integer $CustNum
     * @param integer $MethodID
     * @return PaymentMethod
     */
    public function getCustomerPaymentMethod(ueSecurityToken $Token, $CustNum, $MethodID)
    {
      return $this->__soapCall('getCustomerPaymentMethod', array($Token, $CustNum, $MethodID));
    }

    /**
     * Retrieve the customers Payment Methods for the given CustNum
     *
     * @param ueSecurityToken $Token
     * @param integer $CustNum
     * @return PaymentMethodArray
     */
    public function getCustomerPaymentMethods(ueSecurityToken $Token, $CustNum)
    {
      return $this->__soapCall('getCustomerPaymentMethods', array($Token, $CustNum));
    }

    /**
     * Pull a customer report
     *
     * @param ueSecurityToken $Token
     * @param string $Report
     * @param FieldValueArray $Options
     * @param string $Format
     * @return string
     */
    public function getCustomerReport(ueSecurityToken $Token, $Report, FieldValueArray $Options, $Format)
    {
      return $this->__soapCall('getCustomerReport', array($Token, $Report, $Options, $Format));
    }

    /**
     * Retrieve the custom fields defined by merchants
     *
     * @param ueSecurityToken $Token
     * @return FieldValueArray
     */
    public function getCustomFields(ueSecurityToken $Token)
    {
      return $this->__soapCall('getCustomFields', array($Token));
    }

    /**
     * Retrieve the product details for the given ProductRefNum
     *
     * @param ueSecurityToken $Token
     * @param string $ProductRefNum
     * @return Product
     */
    public function getProduct(ueSecurityToken $Token, $ProductRefNum)
    {
      return $this->__soapCall('getProduct', array($Token, $ProductRefNum));
    }

    /**
     * Retrieve the product category details for the given ProductCategoryRefNum
     *
     * @param ueSecurityToken $Token
     * @param string $ProductCategoryRefNum
     * @return ProductCategory
     */
    public function getProductCategory(ueSecurityToken $Token, $ProductCategoryRefNum)
    {
      return $this->__soapCall('getProductCategory', array($Token, $ProductCategoryRefNum));
    }

    /**
     * Retreive list of product categories
     *
     * @param ueSecurityToken $Token
     * @return ProductCategoryArray
     */
    public function getProductCategories(ueSecurityToken $Token)
    {
      return $this->__soapCall('getProductCategories', array($Token));
    }

    /**
     * Retrieve the product inventory
     *
     * @param ueSecurityToken $Token
     * @param string $ProductRefNum
     * @return ProductInventoryArray
     */
    public function getProductInventory(ueSecurityToken $Token, $ProductRefNum)
    {
      return $this->__soapCall('getProductInventory', array($Token, $ProductRefNum));
    }

    /**
     * Retreive a receipt template by RefNum
     *
     * @param ueSecurityToken $Token
     * @param integer $ReceiptRefNum
     * @return Receipt
     */
    public function getReceipt(ueSecurityToken $Token, $ReceiptRefNum)
    {
      return $this->__soapCall('getReceipt', array($Token, $ReceiptRefNum));
    }

    /**
     * Retreive a receipt template by receipt name
     *
     * @param ueSecurityToken $Token
     * @param string $Name
     * @return Receipt
     */
    public function getReceiptByName(ueSecurityToken $Token, $Name)
    {
      return $this->__soapCall('getReceiptByName', array($Token, $Name));
    }

    /**
     * Retreive list of receipt templates by target
     *
     * @param ueSecurityToken $Token
     * @param string $Target
     * @return ReceiptArray
     */
    public function getReceipts(ueSecurityToken $Token, $Target)
    {
      return $this->__soapCall('getReceipts', array($Token, $Target));
    }

    /**
     * Pull a merchant report
     *
     * @param ueSecurityToken $Token
     * @param string $Report
     * @param FieldValueArray $Options
     * @param string $Format
     * @return string
     */
    public function getReport(ueSecurityToken $Token, $Report, FieldValueArray $Options, $Format)
    {
      return $this->__soapCall('getReport', array($Token, $Report, $Options, $Format));
    }

    /**
     * Retrieve Supported Currencies
     *
     * @param ueSecurityToken $Token
     * @return CurrencyObjectArray
     */
    public function getSupportedCurrencies(ueSecurityToken $Token)
    {
      return $this->__soapCall('getSupportedCurrencies', array($Token));
    }

    /**
     * Retrieve changes to data objects made on the server
     *
     * @param ueSecurityToken $Token
     * @param string $ObjectName
     * @param integer $FromPosition
     * @return SyncLogArray
     */
    public function getSyncLog(ueSecurityToken $Token, $ObjectName, $FromPosition)
    {
      return $this->__soapCall('getSyncLog', array($Token, $ObjectName, $FromPosition));
    }

    /**
     * Returns the last position in the change log for a given object
     *
     * @param ueSecurityToken $Token
     * @param string $ObjectName
     * @return integer
     */
    public function getSyncLogCurrentPosition(ueSecurityToken $Token, $ObjectName)
    {
      return $this->__soapCall('getSyncLogCurrentPosition', array($Token, $ObjectName));
    }

    /**
     * Retreive information about service
     *
     * @param ueSecurityToken $Token
     * @return SystemInfo
     */
    public function getSystemInfo(ueSecurityToken $Token)
    {
      return $this->__soapCall('getSystemInfo', array($Token));
    }

    /**
     * Retreive all information for the transactions specified by RefNum
     *
     * @param ueSecurityToken $Token
     * @param integer $RefNum
     * @return TransactionObject
     */
    public function getTransaction(ueSecurityToken $Token, $RefNum)
    {
      return $this->__soapCall('getTransaction', array($Token, $RefNum));
    }

    /**
     * Get Specific Transaction Details
     *
     * @param ueSecurityToken $Token
     * @param integer $RefNum
     * @param stringArray $Fields
     * @return FieldValueArray
     */
    public function getTransactionCustom(ueSecurityToken $Token, $RefNum, stringArray $Fields)
    {
      return $this->__soapCall('getTransactionCustom', array($Token, $RefNum, $Fields));
    }

    /**
     * Pull a transaction report
     *
     * @param ueSecurityToken $Token
     * @param string $StartDate
     * @param string $EndDate
     * @param string $Report
     * @param string $Format
     * @return string
     */
    public function getTransactionReport(ueSecurityToken $Token, $StartDate, $EndDate, $Report, $Format)
    {
      return $this->__soapCall('getTransactionReport', array($Token, $StartDate, $EndDate, $Report, $Format));
    }

    /**
     * Retrieve the current status of transaction specified by RefNum
     *
     * @param ueSecurityToken $Token
     * @param integer $RefNum
     * @return TransactionResponse
     */
    public function getTransactionStatus(ueSecurityToken $Token, $RefNum)
    {
      return $this->__soapCall('getTransactionStatus', array($Token, $RefNum));
    }

    /**
     * Move customer from one source key to another
     *
     * @param ueSecurityToken $MoveFromToken
     * @param integer $CustNum
     * @param ueSecurityToken $MoveToToken
     * @return integer
     */
    public function moveCustomer(ueSecurityToken $MoveFromToken, $CustNum, ueSecurityToken $MoveToToken)
    {
      return $this->__soapCall('moveCustomer', array($MoveFromToken, $CustNum, $MoveToToken));
    }

    /**
     * Pause a Batch Upload that is already running
     *
     * @param ueSecurityToken $Token
     * @param integer $UploadRefNum
     * @return boolean
     */
    public function pauseBatchUpload(ueSecurityToken $Token, $UploadRefNum)
    {
      return $this->__soapCall('pauseBatchUpload', array($Token, $UploadRefNum));
    }

    /**
     * Post an Offline Authorization
     *
     * @param ueSecurityToken $Token
     * @param TransactionRequestObject $Params
     * @return TransactionResponse
     */
    public function postAuth(ueSecurityToken $Token, TransactionRequestObject $Params)
    {
      return $this->__soapCall('postAuth', array($Token, $Params));
    }

    /**
     * Update specified data for customer specified by CustNum
     *
     * @param ueSecurityToken $Token
     * @param integer $CustNum
     * @param FieldValueArray $UpdateData
     * @return boolean
     */
    public function quickUpdateCustomer(ueSecurityToken $Token, $CustNum, FieldValueArray $UpdateData)
    {
      return $this->__soapCall('quickUpdateCustomer', array($Token, $CustNum, $UpdateData));
    }

    /**
     * Update specified data for product specified by ProductRefNum
     *
     * @param ueSecurityToken $Token
     * @param string $ProductRefNum
     * @param FieldValueArray $UpdateData
     * @return boolean
     */
    public function quickUpdateProduct(ueSecurityToken $Token, $ProductRefNum, FieldValueArray $UpdateData)
    {
      return $this->__soapCall('quickUpdateProduct', array($Token, $ProductRefNum, $UpdateData));
    }

    /**
     * Refund part or all of a transaction
     *
     * @param ueSecurityToken $Token
     * @param integer $RefNum
     * @param float $Amount
     * @return TransactionResponse
     */
    public function refundTransaction(ueSecurityToken $Token, $RefNum, $Amount)
    {
      return $this->__soapCall('refundTransaction', array($Token, $RefNum, $Amount));
    }

    /**
     * Render receipt for transaction
     *
     * @param ueSecurityToken $Token
     * @param integer $RefNum
     * @param integer $ReceiptRefNum
     * @param string $ContentType
     * @return string
     */
    public function renderReceipt(ueSecurityToken $Token, $RefNum, $ReceiptRefNum, $ContentType)
    {
      return $this->__soapCall('renderReceipt', array($Token, $RefNum, $ReceiptRefNum, $ContentType));
    }

    /**
     * Render receipt for transaction
     *
     * @param ueSecurityToken $Token
     * @param integer $RefNum
     * @param string $ReceiptName
     * @param string $ContentType
     * @return string
     */
    public function renderReceiptByName(ueSecurityToken $Token, $RefNum, $ReceiptName, $ContentType)
    {
      return $this->__soapCall('renderReceiptByName', array($Token, $RefNum, $ReceiptName, $ContentType));
    }

    /**
     * Start a Paused Batch Upload
     *
     * @param ueSecurityToken $Token
     * @param integer $UploadRefNum
     * @return boolean
     */
    public function runBatchUpload(ueSecurityToken $Token, $UploadRefNum)
    {
      return $this->__soapCall('runBatchUpload', array($Token, $UploadRefNum));
    }

    /**
     * Run a Credit transaction
     *
     * @param ueSecurityToken $Token
     * @param TransactionRequestObject $Params
     * @return TransactionResponse
     */
    public function runCredit(ueSecurityToken $Token, TransactionRequestObject $Params)
    {
      return $this->__soapCall('runCredit', array($Token, $Params));
    }

    /**
     * Run a Check Credit transaction
     *
     * @param ueSecurityToken $Token
     * @param TransactionRequestObject $Params
     * @return TransactionResponse
     */
    public function runCheckCredit(ueSecurityToken $Token, TransactionRequestObject $Params)
    {
      return $this->__soapCall('runCheckCredit', array($Token, $Params));
    }

    /**
     * Run a sale for a customer stored in the customer database
     *
     * @param ueSecurityToken $Token
     * @param integer $CustNum
     * @param integer $PaymentMethodID
     * @param CustomerTransactionRequest $Parameters
     * @return TransactionResponse
     */
    public function runCustomerTransaction(ueSecurityToken $Token, $CustNum, $PaymentMethodID, CustomerTransactionRequest $Parameters)
    {
      return $this->__soapCall('runCustomerTransaction', array($Token, $CustNum, $PaymentMethodID, $Parameters));
    }

    /**
     * Run a sale based on the credit card details of a previous transaction.
     *
     * @param ueSecurityToken $Token
     * @param integer $RefNum
     * @param TransactionDetail $Details
     * @param boolean $AuthOnly
     * @return TransactionResponse
     */
    public function runQuickSale(ueSecurityToken $Token, $RefNum, TransactionDetail $Details, $AuthOnly)
    {
      return $this->__soapCall('runQuickSale', array($Token, $RefNum, $Details, $AuthOnly));
    }

    /**
     * Run a credit based on the credit card details of a previous transaction.
     *
     * @param ueSecurityToken $Token
     * @param integer $RefNum
     * @param TransactionDetail $Details
     * @return TransactionResponse
     */
    public function runQuickCredit(ueSecurityToken $Token, $RefNum, TransactionDetail $Details)
    {
      return $this->__soapCall('runQuickCredit', array($Token, $RefNum, $Details));
    }

    /**
     * Run a Check Sale
     *
     * @param ueSecurityToken $Token
     * @param TransactionRequestObject $Params
     * @return TransactionResponse
     */
    public function runCheckSale(ueSecurityToken $Token, TransactionRequestObject $Params)
    {
      return $this->__soapCall('runCheckSale', array($Token, $Params));
    }

    /**
     * Run a Credit CardSale
     *
     * @param ueSecurityToken $Token
     * @param TransactionRequestObject $Params
     * @return TransactionResponse
     */
    public function runSale(ueSecurityToken $Token, TransactionRequestObject $Params)
    {
      return $this->__soapCall('runSale', array($Token, $Params));
    }

    /**
     * Run an AuthOnly Credit Card Sale
     *
     * @param ueSecurityToken $Token
     * @param TransactionRequestObject $Params
     * @return TransactionResponse
     */
    public function runAuthOnly(ueSecurityToken $Token, TransactionRequestObject $Params)
    {
      return $this->__soapCall('runAuthOnly', array($Token, $Params));
    }

    /**
     * Runs a Transaction using the USAePay Transaction API
     *
     * @param ueSecurityToken $Token
     * @param TransactionRequestObject $Parameters
     * @return TransactionResponse
     */
    public function runTransaction(ueSecurityToken $Token, TransactionRequestObject $Parameters)
    {
      return $this->__soapCall('runTransaction', array($Token, $Parameters));
    }

    /**
     * Provides a Soap wrapper for the USAePay Transaction API
     *
     * @param ueSecurityToken $Token
     * @param FieldValueArray $Parameters
     * @return TransactionResponse
     */
    public function runTransactionAPI(ueSecurityToken $Token, FieldValueArray $Parameters)
    {
      return $this->__soapCall('runTransactionAPI', array($Token, $Parameters));
    }

    /**
     * Search Settled Batches
     *
     * @param ueSecurityToken $Token
     * @param SearchParamArray $Search
     * @param boolean $MatchAll
     * @param integer $Start
     * @param integer $Limit
     * @param string $Sort
     * @return BatchSearchResult
     */
    public function searchBatches(ueSecurityToken $Token, SearchParamArray $Search, $MatchAll, $Start, $Limit, $Sort)
    {
      return $this->__soapCall('searchBatches', array($Token, $Search, $MatchAll, $Start, $Limit, $Sort));
    }

    /**
     * Search Settled Batches, return counts only
     *
     * @param ueSecurityToken $Token
     * @param SearchParamArray $Search
     * @param boolean $MatchAll
     * @param integer $Start
     * @param integer $Limit
     * @param string $Sort
     * @return BatchSearchResult
     */
    public function searchBatchesCount(ueSecurityToken $Token, SearchParamArray $Search, $MatchAll, $Start, $Limit, $Sort)
    {
      return $this->__soapCall('searchBatchesCount', array($Token, $Search, $MatchAll, $Start, $Limit, $Sort));
    }

    /**
     * Find the customer refnum (CustNum) associated with the userdefined CustID
     *
     * @param ueSecurityToken $Token
     * @param string $CustID
     * @return integer
     */
    public function searchCustomerID(ueSecurityToken $Token, $CustID)
    {
      return $this->__soapCall('searchCustomerID', array($Token, $CustID));
    }

    /**
     * Search customer database
     *
     * @param ueSecurityToken $Token
     * @param SearchParamArray $Search
     * @param boolean $MatchAll
     * @param integer $Start
     * @param integer $Limit
     * @param string $Sort
     * @return CustomerSearchResult
     */
    public function searchCustomers(ueSecurityToken $Token, SearchParamArray $Search, $MatchAll, $Start, $Limit, $Sort)
    {
      return $this->__soapCall('searchCustomers', array($Token, $Search, $MatchAll, $Start, $Limit, $Sort));
    }

    /**
     * Search customer database return only count of what was found
     *
     * @param ueSecurityToken $Token
     * @param SearchParamArray $Search
     * @param boolean $MatchAll
     * @param integer $Start
     * @param integer $Limit
     * @param string $Sort
     * @return CustomerSearchResult
     */
    public function searchCustomersCount(ueSecurityToken $Token, SearchParamArray $Search, $MatchAll, $Start, $Limit, $Sort)
    {
      return $this->__soapCall('searchCustomersCount', array($Token, $Search, $MatchAll, $Start, $Limit, $Sort));
    }

    /**
     * Search Customers and return specified fields
     *
     * @param ueSecurityToken $Token
     * @param SearchParamArray $Search
     * @param boolean $MatchAll
     * @param integer $Start
     * @param integer $Limit
     * @param stringArray $FieldList
     * @param string $Format
     * @param string $Sort
     * @return string
     */
    public function searchCustomersCustom(ueSecurityToken $Token, SearchParamArray $Search, $MatchAll, $Start, $Limit, stringArray $FieldList, $Format, $Sort)
    {
      return $this->__soapCall('searchCustomersCustom', array($Token, $Search, $MatchAll, $Start, $Limit, $FieldList, $Format, $Sort));
    }

    /**
     * Search Products
     *
     * @param ueSecurityToken $Token
     * @param SearchParamArray $Search
     * @param boolean $MatchAll
     * @param integer $Start
     * @param integer $Limit
     * @param string $Sort
     * @return ProductSearchResult
     */
    public function searchProducts(ueSecurityToken $Token, SearchParamArray $Search, $MatchAll, $Start, $Limit, $Sort)
    {
      return $this->__soapCall('searchProducts', array($Token, $Search, $MatchAll, $Start, $Limit, $Sort));
    }

    /**
     * Search Products, return counts only
     *
     * @param ueSecurityToken $Token
     * @param SearchParamArray $Search
     * @param boolean $MatchAll
     * @param integer $Start
     * @param integer $Limit
     * @param string $Sort
     * @return ProductSearchResult
     */
    public function searchProductsCount(ueSecurityToken $Token, SearchParamArray $Search, $MatchAll, $Start, $Limit, $Sort)
    {
      return $this->__soapCall('searchProductsCount', array($Token, $Search, $MatchAll, $Start, $Limit, $Sort));
    }

    /**
     * Search Products and return custom response
     *
     * @param ueSecurityToken $Token
     * @param SearchParamArray $Search
     * @param boolean $MatchAll
     * @param integer $Start
     * @param integer $Limit
     * @param stringArray $FieldList
     * @param string $Format
     * @param string $Sort
     * @return string
     */
    public function searchProductsCustom(ueSecurityToken $Token, SearchParamArray $Search, $MatchAll, $Start, $Limit, stringArray $FieldList, $Format, $Sort)
    {
      return $this->__soapCall('searchProductsCustom', array($Token, $Search, $MatchAll, $Start, $Limit, $FieldList, $Format, $Sort));
    }

    /**
     * Search transactions and return transaction records
     *
     * @param ueSecurityToken $Token
     * @param SearchParamArray $Search
     * @param boolean $MatchAll
     * @param integer $Start
     * @param integer $Limit
     * @param string $Sort
     * @return TransactionSearchResult
     */
    public function searchTransactions(ueSecurityToken $Token, SearchParamArray $Search, $MatchAll, $Start, $Limit, $Sort)
    {
      return $this->__soapCall('searchTransactions', array($Token, $Search, $MatchAll, $Start, $Limit, $Sort));
    }

    /**
     * Search transactions and return counts,  omit tran data
     *
     * @param ueSecurityToken $Token
     * @param SearchParamArray $Search
     * @param boolean $MatchAll
     * @param integer $Start
     * @param integer $Limit
     * @param string $Sort
     * @return TransactionSearchResult
     */
    public function searchTransactionsCount(ueSecurityToken $Token, SearchParamArray $Search, $MatchAll, $Start, $Limit, $Sort)
    {
      return $this->__soapCall('searchTransactionsCount', array($Token, $Search, $MatchAll, $Start, $Limit, $Sort));
    }

    /**
     * Search Transactions and return specified fields
     *
     * @param ueSecurityToken $Token
     * @param SearchParamArray $Search
     * @param boolean $MatchAll
     * @param integer $Start
     * @param integer $Limit
     * @param stringArray $FieldList
     * @param string $Format
     * @param string $Sort
     * @return string
     */
    public function searchTransactionsCustom(ueSecurityToken $Token, SearchParamArray $Search, $MatchAll, $Start, $Limit, stringArray $FieldList, $Format, $Sort)
    {
      return $this->__soapCall('searchTransactionsCustom', array($Token, $Search, $MatchAll, $Start, $Limit, $FieldList, $Format, $Sort));
    }

    /**
     * Replace all data for customer specified by CustNum
     *
     * @param ueSecurityToken $Token
     * @param integer $CustNum
     * @param CustomerObject $CustomerData
     * @return boolean
     */
    public function updateCustomer(ueSecurityToken $Token, $CustNum, CustomerObject $CustomerData)
    {
      return $this->__soapCall('updateCustomer', array($Token, $CustNum, $CustomerData));
    }

    /**
     * Update a Customer Payment Method
     *
     * @param ueSecurityToken $Token
     * @param PaymentMethod $PaymentMethod
     * @param boolean $Verify
     * @return boolean
     */
    public function updateCustomerPaymentMethod(ueSecurityToken $Token, PaymentMethod $PaymentMethod, $Verify)
    {
      return $this->__soapCall('updateCustomerPaymentMethod', array($Token, $PaymentMethod, $Verify));
    }

    /**
     * Replace all data for product specified by ProductRefNum
     *
     * @param ueSecurityToken $Token
     * @param string $ProductRefNum
     * @param Product $Product
     * @return boolean
     */
    public function updateProduct(ueSecurityToken $Token, $ProductRefNum, Product $Product)
    {
      return $this->__soapCall('updateProduct', array($Token, $ProductRefNum, $Product));
    }

    /**
     * Replace all data for product category specified by ProductCategoryRefNum
     *
     * @param ueSecurityToken $Token
     * @param string $ProductCategoryRefNum
     * @param ProductCategory $ProductCategory
     * @return boolean
     */
    public function updateProductCategory(ueSecurityToken $Token, $ProductCategoryRefNum, ProductCategory $ProductCategory)
    {
      return $this->__soapCall('updateProductCategory', array($Token, $ProductCategoryRefNum, $ProductCategory));
    }

    /**
     * Update receipt template
     *
     * @param ueSecurityToken $Token
     * @param integer $ReceiptRefNum
     * @param Receipt $Receipt
     * @return integer
     */
    public function updateReceipt(ueSecurityToken $Token, $ReceiptRefNum, Receipt $Receipt)
    {
      return $this->__soapCall('updateReceipt', array($Token, $ReceiptRefNum, $Receipt));
    }

    /**
     * Void the transaction specified by RefNum
     *
     * @param ueSecurityToken $Token
     * @param integer $RefNum
     * @return boolean
     */
    public function voidTransaction(ueSecurityToken $Token, $RefNum)
    {
      return $this->__soapCall('voidTransaction', array($Token, $RefNum));
    }

    /**
     * Override the transaction specified by RefNum
     *
     * @param ueSecurityToken $Token
     * @param integer $RefNum
     * @param string $Reason
     * @return boolean
     */
    public function overrideTransaction(ueSecurityToken $Token, $RefNum, $Reason)
    {
      return $this->__soapCall('overrideTransaction', array($Token, $RefNum, $Reason));
    }

}
