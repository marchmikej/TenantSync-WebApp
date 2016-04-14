<?php 

Route::get('test', 'HomeController@test');

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');


// Tenant/Device routes
Route::get('device-api/maintenance', 'Api\DeviceApiController@getMaintenanceRequests');
Route::post('device-api/maintenance/{id}', 'Api\DeviceApiController@updateMaintenanceRequest');
Route::post('device-api/maintenance', 'Api\DeviceApiController@storeMaintenanceRequest');
Route::get('device-api/device', 'Api\DeviceApiController@getDevice');
Route::post('device-api/device', 'Api\DeviceApiController@UpdateRoutingId');
Route::get('device-api/message', 'Api\DeviceApiController@getMessages');
Route::post('device-api/message', 'Api\DeviceApiController@storeMessage');
Route::post('device-api/pay', 'Api\DeviceApiController@payRent');
Route::get('device-api/rent-status', 'Api\DeviceApiController@rentStatus');
Route::post('device-api/receivingnotifications', 'Api\PhoneAppController@receivingNotifications');
Route::post('device-api/loginapp', 'Api\PhoneAppController@isUser');

// Password reset Routes
Route::get('password/reset/{token}', '\App\Http\Controllers\Auth\PasswordController@getReset');
Route::post('password/reset', '\App\Http\Controllers\Auth\PasswordController@postReset');
Route::get('password/email', '\App\Http\Controllers\Auth\PasswordController@getEmail');
Route::post('password/email', '\App\Http\Controllers\Auth\PasswordController@postEmail');

// Auth Routes
Route::get('login', '\App\Http\Controllers\Auth\AuthController@getLogin');
Route::post('login', '\App\Http\Controllers\Auth\AuthController@postLogin');
Route::get('auth/login/{routing_id?}', 'HomeController@index');
Route::post('auth/login/{routing_id?}', '\App\Http\Controllers\Auth\AuthController@postLogin');
Route::get('logout', '\App\Http\Controllers\Auth\AuthController@getLogout');

Route::group(['middleware' => ['auth']], function()
{
	// Phone App Notification Routes
	Route::post('api/phoneverify/{id}', 'Api\PhoneAppController@phoneverify');
	Route::get('api/managenotifications/{id}', 'Api\PhoneAppController@manageNotifications');
	// End Phone app notification routes

	// Internal Api Routes
	Route::get('api/devices/{id}/messages', 'Api\MessageController@forDevice');
	Route::get('api/devices/{id}/maintenance', 'Api\MaintenanceController@forDevice');
	Route::patch('api/devices/{id}', 'Api\DeviceController@update');
	Route::resource('api/devices', 'Api\DeviceController');

	Route::patch('api/transactions/recurring/{id}', 'Api\RecurringTransactionController@update');
	Route::resource('api/transactions/recurring', 'Api\RecurringTransactionController');
	Route::patch('api/transactions/{id}', 'Api\TransactionController@update');
	Route::delete('api/transactions/{id}', 'Api\TransactionController@destroy');
	Route::resource('api/transactions', 'Api\TransactionController');

	Route::get('api/properties/{id}/devices', 'Api\PropertyController@devices');
	Route::resource('api/properties', 'Api\PropertyController');

	Route::delete('api/managers/properties', 'Api\ManagerController@removeProperties');
	Route::patch('api/managers/properties', 'Api\ManagerController@addProperties');
	Route::delete('api/managers/{id}', 'Api\ManagerController@destroy');
	Route::resource('api/managers', 'Api\ManagerController');

	Route::resource('api/rent-bills', 'Api\RentBillController');

	Route::delete('api/messages', 'Api\MessageController@destroy');
	Route::resource('api/messages', 'Api\MessageController');

	Route::patch('api/maintenance/{id}', 'Api\MaintenanceController@update');
	Route::patch('api/maintenance/{id}/close', 'Api\MaintenanceController@closeMaintenance');
	Route::resource('api/maintenance', 'Api\MaintenanceController');
	// End Api routes

	// Sales rep routes
	Route::group(['prefix' => 'sales', 'namespace' => 'Sales', 'middleware' => ['sales']], function()
	{
		Route::get('/', '\App\Http\Controllers\HomeController@index');
		Route::get('/registration/pay', 'PaymentController@getPayRegistration');
		Route::post('/registration/pay', 'PaymentController@postPayRegistration');
		// Route::get('sales/register', ['as' => 'landlord.register', 'uses' => function() {
		// 		return view('auth.register');
		// 	}
		// ]);
		Route::post('/register', ['uses' => '\App\Services\SalesRegistrar@create']);

		Route::patch('/landlord/{id}', 'LandlordController@update');

		Route::resource('/landlord/{id}/device', 'DeviceController');

		Route::resource('/landlord/{id}/properties', 'PropertyController');

		Route::get('/landlord/{id}/billing-account', 'LandlordController@getBillingAccount');
		Route::patch('/landlord/{id}/billing-account', 'LandlordController@updateBillingAccount');

		Route::resource('landlord/{id}/payment', 'PaymentController');
		Route::patch('landlord/{id}/payment', 'PaymentController@update');
		Route::get('landlord/{id}/payment', 'PaymentController@show');

		Route::resource('/landlord', 'LandlordController');

		Route::resource('/properties/{id}/device', 'DeviceController');

		Route::resource('device', 'DeviceController');

		Route::resource('gateway', 'GatewayController');

		Route::resource('profile', 'ProfileController');

		Route::resource('billing', 'BillingController');
	});



	// Landlord Routes
	Route::group(['prefix' => 'landlord', 'namespace' => 'Landlord', 'middleware' => ['landlord']], function()
	{
		Route::get('/', '\App\Http\Controllers\HomeController@index');
		Route::get('calendar', '\App\Http\Controllers\Landlord\CalendarController@index');
		Route::get('calendar/all', '\App\Http\Controllers\Landlord\CalendarController@all');
		Route::get('calculator', '\App\Http\Controllers\Landlord\CalculatorController@index');
		Route::get('calculator/estimate_roi', '\App\Http\Controllers\Landlord\CalculatorController@estimateRoi');

		Route::get('maintenance/all', 'MaintenanceController@all');
		Route::get('api/maintenance/{id}', 'MaintenanceController@get');
		Route::patch('maintenance/{id}', 'MaintenanceController@update');
		Route::patch('maintenance/{id}/close', 'MaintenanceController@closeRequest');
		Route::resource('maintenance', 'MaintenanceController');


		Route::get('device/all', 'DeviceController@all');
		Route::post('device/message', 'MessageController@store');
		Route::resource('device', 'DeviceController');


		Route::get('properties/all', 'PropertyController@all');
		Route::get('properties/{id}/devices', 'PropertyController@devices');
		Route::resource('properties', 'PropertyController');


		Route::resource('gateway', 'GatewayController');
		Route::resource('payment', 'PaymentController');

		Route::post('profile/password', 'ProfileController@password');
		Route::resource('profile', 'ProfileController');

		Route::get('messages/all', 'MessageController@all');
		
		Route::delete('managers/properties', 'ManagerController@removeProperties');
		Route::patch('managers/properties', 'ManagerController@addProperties');
		Route::get('managers/all', 'ManagerController@all');
		Route::delete('managers/{id}', 'ManagerController@destroy');
		Route::resource('managers', 'ManagerController');
		

		Route::get('transaction/', 'TransactionController@index');
		Route::get('transaction/all', 'TransactionController@all');
		Route::post('transaction', 'TransactionController@store');
		Route::patch('transaction/{id}', 'TransactionController@update');
		Route::delete('transaction/{id}', 'TransactionController@destroy');
	});

	// Manager routes
	Route::group(['prefix' => 'manager', 'namespace' => 'Manager', 'middleware' => ['manager']], function()
	{
		Route::get('/', 'DeviceController@index');
		Route::get('calculator', '\App\Http\Controllers\Manager\CalculatorController@index');
		Route::get('calculator/estimate_roi', '\App\Http\Manager\Landlord\CalculatorController@estimateRoi');
		Route::get('calendar', 'CalendarController@index');
		Route::get('calendar/all', 'CalendarController@all');
		
		Route::get('messages/all', 'MessageController@all');
		Route::resource('messages', 'MessageController');

		Route::get('device/all', 'DeviceController@all');
		Route::post('device/message', 'MessageController@store');
		Route::resource('device', 'DeviceController');

		Route::get('properties/all', 'PropertyController@all');
		Route::get('properties/{id}/devices', 'PropertyController@devices');
		Route::resource('properties', 'PropertyController');


		Route::post('profile/email', 'ProfileController@email');
		Route::post('profile/password', 'ProfileController@password');
		Route::resource('profile', 'ProfileController');

		Route::get('maintenance/all', 'MaintenanceController@all');
		Route::patch('maintenance/{id}', 'MaintenanceController@update');
		Route::patch('maintenance/{id}/close', 'MaintenanceController@closeRequest');
		Route::resource('maintenance', 'MaintenanceController');

		Route::get('transaction/all', 'TransactionController@all');
		Route::patch('transaction/{id}','TransactionController@update');
		Route::delete('{id}','TransactionController@destroy');
		Route::resource('transaction', 'TransactionController');
	});
});



