<?php


 function autoload_2ec41db31f9ef78bb574791976a461b7($class)
{
    $classes = array(
        'TenantSync\Billing\UsaEpaySoap\UsaepayService' => __DIR__ .'/UsaepayService.php',
        'TenantSync\Billing\UsaEpaySoap\AccountDetails' => __DIR__ .'/AccountDetails.php',
        'TenantSync\Billing\UsaEpaySoap\Address' => __DIR__ .'/Address.php',
        'TenantSync\Billing\UsaEpaySoap\Bank' => __DIR__ .'/Bank.php',
        'TenantSync\Billing\UsaEpaySoap\BankArray' => __DIR__ .'/BankArray.php',
        'TenantSync\Billing\UsaEpaySoap\BatchSearchResult' => __DIR__ .'/BatchSearchResult.php',
        'TenantSync\Billing\UsaEpaySoap\BatchStatus' => __DIR__ .'/BatchStatus.php',
        'TenantSync\Billing\UsaEpaySoap\BatchStatusArray' => __DIR__ .'/BatchStatusArray.php',
        'TenantSync\Billing\UsaEpaySoap\BatchUploadStatus' => __DIR__ .'/BatchUploadStatus.php',
        'TenantSync\Billing\UsaEpaySoap\CheckData' => __DIR__ .'/CheckData.php',
        'TenantSync\Billing\UsaEpaySoap\CheckTrace' => __DIR__ .'/CheckTrace.php',
        'TenantSync\Billing\UsaEpaySoap\CreditCardData' => __DIR__ .'/CreditCardData.php',
        'TenantSync\Billing\UsaEpaySoap\CurrencyConversion' => __DIR__ .'/CurrencyConversion.php',
        'TenantSync\Billing\UsaEpaySoap\CurrencyConversionArray' => __DIR__ .'/CurrencyConversionArray.php',
        'TenantSync\Billing\UsaEpaySoap\CurrencyObject' => __DIR__ .'/CurrencyObject.php',
        'TenantSync\Billing\UsaEpaySoap\CurrencyObjectArray' => __DIR__ .'/CurrencyObjectArray.php',
        'TenantSync\Billing\UsaEpaySoap\CustomerObject' => __DIR__ .'/CustomerObject.php',
        'TenantSync\Billing\UsaEpaySoap\CustomerObjectArray' => __DIR__ .'/CustomerObjectArray.php',
        'TenantSync\Billing\UsaEpaySoap\CustomerSearchResult' => __DIR__ .'/CustomerSearchResult.php',
        'TenantSync\Billing\UsaEpaySoap\CustomerTransactionRequest' => __DIR__ .'/CustomerTransactionRequest.php',
        'TenantSync\Billing\UsaEpaySoap\doubleArray' => __DIR__ .'/doubleArray.php',
        'TenantSync\Billing\UsaEpaySoap\FieldValue' => __DIR__ .'/FieldValue.php',
        'TenantSync\Billing\UsaEpaySoap\FieldValueArray' => __DIR__ .'/FieldValueArray.php',
        'TenantSync\Billing\UsaEpaySoap\LineItem' => __DIR__ .'/LineItem.php',
        'TenantSync\Billing\UsaEpaySoap\LineItemArray' => __DIR__ .'/LineItemArray.php',
        'TenantSync\Billing\UsaEpaySoap\PaymentMethod' => __DIR__ .'/PaymentMethod.php',
        'TenantSync\Billing\UsaEpaySoap\PaymentMethodArray' => __DIR__ .'/PaymentMethodArray.php',
        'TenantSync\Billing\UsaEpaySoap\PriceTier' => __DIR__ .'/PriceTier.php',
        'TenantSync\Billing\UsaEpaySoap\PriceTierArray' => __DIR__ .'/PriceTierArray.php',
        'TenantSync\Billing\UsaEpaySoap\Product' => __DIR__ .'/Product.php',
        'TenantSync\Billing\UsaEpaySoap\ProductArray' => __DIR__ .'/ProductArray.php',
        'TenantSync\Billing\UsaEpaySoap\ProductCategory' => __DIR__ .'/ProductCategory.php',
        'TenantSync\Billing\UsaEpaySoap\ProductCategoryArray' => __DIR__ .'/ProductCategoryArray.php',
        'TenantSync\Billing\UsaEpaySoap\ProductInventory' => __DIR__ .'/ProductInventory.php',
        'TenantSync\Billing\UsaEpaySoap\ProductInventoryArray' => __DIR__ .'/ProductInventoryArray.php',
        'TenantSync\Billing\UsaEpaySoap\ProductSearchResult' => __DIR__ .'/ProductSearchResult.php',
        'TenantSync\Billing\UsaEpaySoap\Receipt' => __DIR__ .'/Receipt.php',
        'TenantSync\Billing\UsaEpaySoap\ReceiptArray' => __DIR__ .'/ReceiptArray.php',
        'TenantSync\Billing\UsaEpaySoap\RecurringBilling' => __DIR__ .'/RecurringBilling.php',
        'TenantSync\Billing\UsaEpaySoap\SearchParam' => __DIR__ .'/SearchParam.php',
        'TenantSync\Billing\UsaEpaySoap\SearchParamArray' => __DIR__ .'/SearchParamArray.php',
        'TenantSync\Billing\UsaEpaySoap\stringArray' => __DIR__ .'/stringArray.php',
        'TenantSync\Billing\UsaEpaySoap\SyncLog' => __DIR__ .'/SyncLog.php',
        'TenantSync\Billing\UsaEpaySoap\SyncLogArray' => __DIR__ .'/SyncLogArray.php',
        'TenantSync\Billing\UsaEpaySoap\SystemInfo' => __DIR__ .'/SystemInfo.php',
        'TenantSync\Billing\UsaEpaySoap\TransactionDetail' => __DIR__ .'/TransactionDetail.php',
        'TenantSync\Billing\UsaEpaySoap\TransactionObject' => __DIR__ .'/TransactionObject.php',
        'TenantSync\Billing\UsaEpaySoap\TransactionObjectArray' => __DIR__ .'/TransactionObjectArray.php',
        'TenantSync\Billing\UsaEpaySoap\TransactionRequestObject' => __DIR__ .'/TransactionRequestObject.php',
        'TenantSync\Billing\UsaEpaySoap\TransactionResponse' => __DIR__ .'/TransactionResponse.php',
        'TenantSync\Billing\UsaEpaySoap\TransactionSearchResult' => __DIR__ .'/TransactionSearchResult.php',
        'TenantSync\Billing\UsaEpaySoap\ueHash' => __DIR__ .'/ueHash.php',
        'TenantSync\Billing\UsaEpaySoap\ueSecurityToken' => __DIR__ .'/ueSecurityToken.php'
    );
    if (!empty($classes[$class])) {
        include $classes[$class];
    };
}

spl_autoload_register('autoload_2ec41db31f9ef78bb574791976a461b7');

// Do nothing. The rest is just leftovers from the code generation.
{
}
