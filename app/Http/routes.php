<?php 

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('test', 'HomeController@test');


Route::get('api/devices/{id}/messages', 'Api\MessageController@forDevice');
Route::get('api/devices/{id}/maintenance', 'Api\MaintenanceController@forDevice');
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



Route::get('device-api/maintenance', 'Api\DeviceApiController@allRequests');
Route::post('device-api/maintenance/{id?}', 'Api\DeviceApiController@storeRequest');
Route::get('device-api/device', 'Api\DeviceApiController@showDevice');
Route::post('device-api/device', 'Api\DeviceApiController@UpdateRoutingId');
Route::get('device-api/message', 'Api\DeviceApiController@getMessages');
Route::post('device-api/message', 'Api\DeviceApiController@createMessage');
Route::post('device-api/pay', 'Api\DeviceApiController@payRent');
Route::get('device-api/rent-status', 'Api\DeviceApiController@rentStatus');
Route::post('device-api/receivingnotifications', 'Api\PhoneAppController@receivingNotifications');
Route::post('device-api/loginapp', 'Api\PhoneAppController@isUser');

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');


// Password reset Routes
Route::get('password/reset/{token}', '\App\Http\Controllers\Auth\PasswordController@getReset');
Route::post('password/reset', '\App\Http\Controllers\Auth\PasswordController@postReset');
Route::get('password/email', '\App\Http\Controllers\Auth\PasswordController@getEmail');
Route::post('password/email', '\App\Http\Controllers\Auth\PasswordController@postEmail');


// Auth Routes
Route::get('login', '\App\Http\Controllers\Auth\AuthController@getLogin');
Route::get('auth/login/{routing_id?}', 'HomeController@index');
//Route::get('applogin/{routing_id?}', '\App\Http\Controllers\Auth\AuthController@getAppLogin');
Route::post('auth/login/{routing_id?}', '\App\Http\Controllers\Auth\AuthController@postLogin');
Route::get('logout', '\App\Http\Controllers\Auth\AuthController@getLogout');
Route::group(['middleware' => ['auth', 'sales']], function()
{
	Route::get('sales/register', ['as' => 'landlord.register', 'uses' => function() {
			return view('auth.register');
		}
	]);
	Route::post('sales/register', ['uses' => '\App\Services\SalesRegistrar@create']);
});


// Protected by the ACL middleware
Route::group(['middleware' => ['auth']], function()
{
	// Phone App Notification Routes
	Route::post('api/phoneverify/{id}', 'Api\PhoneAppController@phoneverify');
	Route::get('api/managenotifications/{id}', 'Api\PhoneAppController@manageNotifications');

	Route::group(['prefix' => 'sales', 'namespace' => 'Sales', 'middleware' => ['sales']], function()
	{
		Route::get('/', '\App\Http\Controllers\HomeController@index');
		Route::get('/registration/pay', 'PaymentController@getPayRegistration');
		Route::post('/registration/pay', 'PaymentController@postPayRegistration');

		Route::patch('/landlord/{id}', 'LandlordController@update');
		Route::post('/landlord/{id}/device', 'DeviceController@store');
		Route::get('/landlord/{id}/device/create', 'DeviceController@create');
		Route::get('/landlord/{id}/customer', 'LandlordController@customer');
		Route::resource('/landlord', 'LandlordController');


		Route::resource('device', 'DeviceController');

		Route::resource('payment', 'PaymentController');

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
		

		Route::group(['prefix' => 'transaction'], function ()
		{
			Route::get('/',['as' => 'landlord.transaction.index', 'uses' => 'TransactionController@index']);
			Route::get('/all',['as' => 'landlord.transaction.all', 'uses' => 'TransactionController@all']);
			Route::post('/',['as' => 'landlord.transaction.store', 'uses' => 'TransactionController@store']);
			Route::patch('{id}',['as' => 'landlord.transaction.update', 'uses' => 'TransactionController@update']);
			Route::delete('{id}',['as' => 'landlord.transaction.delete', 'uses' => 'TransactionController@destroy']);
		});
	});

	Route::group(['prefix' => 'manager', 'namespace' => 'Manager', 'middleware' => ['manager']], function()
	{
		Route::get('/', ['as' => 'manager.index', 'permission' => 'is_manager', 'uses' => 'DeviceController@index']);
		Route::get('calculator', ['as' => 'landlord.calculator', 'permission' => 'is_landlord', 'uses' => '\App\Http\Controllers\Manager\CalculatorController@index']);
		Route::get('calculator/estimate_roi', ['as' => 'landlord.calculator.estimate_roi', 'permission' => 'is_landlord', 'uses' => '\App\Http\Manager\Landlord\CalculatorController@estimateRoi']);
		Route::get('calendar', ['as' => 'manager.calendar', 'permission' => 'is_manager', 'uses' => 'CalendarController@index']);
		Route::get('calendar/all', ['as' => 'manager.calendar.all', 'permission' => 'is_manager', 'uses' => 'CalendarController@all']);
		
		Route::get('messages/all', 'MessageController@all');
		Route::resource('messages', 'MessageController');

		// Route::group(['prefix' => 'device'], function()
		// {
		// 	Route::get('/', ['as' => 'manager.device.index', 'permission' => 'is_manager', 'uses' => 'DeviceController@index']);
		// 	Route::get('/all', ['as' => 'manager.device.all', 'permission' => 'is_manager', 'uses' => 'DeviceController@all']);
		// 	Route::get('{id}', ['as' => 'manager.device.show', 'permission' => 'is_manager', 'uses' => 'DeviceController@show']);
		// });
		Route::get('device/all', 'DeviceController@all');
		Route::post('device/message', 'MessageController@store');
		Route::resource('device', 'DeviceController');

		Route::get('properties/all', 'PropertyController@all');
		Route::get('properties/{id}/devices', 'PropertyController@devices');
		Route::resource('properties', 'PropertyController');


		Route::post('profile/email', 'ProfileController@email');
		Route::post('profile/password', 'ProfileController@password');
		Route::resource('profile', 'ProfileController');
		// Route::group(['prefix' => 'maintenance'], function()
		// {
		// 	Route::get('/', ['as' => 'manager.maintenance.index', 'permission' => 'is_manager', 'uses' => 'MaintenanceController@index']);
		// 	Route::get('/all', ['as' => 'manager.maintenance.all', 'permission' => 'is_manager', 'uses' => 'MaintenanceController@all']);
		// 	Route::get('{id}', ['as' => 'manager.maintenance.show', 'permission' => 'is_manager', 'uses' => 'MaintenanceController@show']);
		// });

		Route::get('maintenance/all', 'MaintenanceController@all');
		Route::patch('maintenance/{id}', 'MaintenanceController@update');
		Route::patch('maintenance/{id}/close', 'MaintenanceController@closeRequest');
		Route::resource('maintenance', 'MaintenanceController');

		Route::get('transaction/all', 'TransactionController@all');
		Route::patch('transaction/{id}','TransactionController@update');
		Route::delete('{id}','TransactionController@destroy');
		Route::resource('transaction', 'TransactionController');

		// Route::group(['prefix' => 'transaction'], function ()
		// {
		// 	Route::get('/',['as' => 'landlord.transaction.index', 'uses' => 'TransactionController@index']);
		// 	Route::get('/all',['as' => 'landlord.transaction.all', 'uses' => 'TransactionController@all']);
		// 	Route::post('/',['as' => 'landlord.transaction.store', 'uses' => 'TransactionController@store']);
		// 	Route::patch('{id}',['as' => 'landlord.transaction.update', 'uses' => 'TransactionController@update']);
		// 	Route::delete('{id}',['as' => 'landlord.transaction.delete', 'uses' => 'TransactionController@destroy']);
		// });
	});
});



