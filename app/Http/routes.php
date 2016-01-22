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
// Route::get('test', 'HomeController@test');


Route::get('api/maintenance', 'Api\ApiController@allRequests');
Route::post('api/maintenance/{id?}', 'Api\ApiController@storeRequest');
Route::get('api/device', 'Api\ApiController@showDevice');
Route::post('api/device', 'Api\ApiController@UpdateRoutingId');
Route::get('api/message', 'Api\ApiController@getMessages');
Route::post('api/message', 'Api\ApiController@createMessage');
Route::post('api/pay', 'Api\ApiController@payRent');
Route::post('api/rent-status', 'Api\ApiController@rentStatus');

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
		Route::get('/registration/pay',['as' => 'sales.registration.getPay', 'permission' => 'is_sales_rep', 'uses' => 'PaymentController@getPayRegistration']);
		Route::post('/registration/pay',['as' => 'sales.registration.postPay', 'permission' => 'is_sales_rep', 'uses' => 'PaymentController@postPayRegistration']);

		Route::patch('/landlord/{id}', 'LandlordController@update');
		Route::get('/landlord/{id}/customer', 'LandlordController@customer');
		Route::resource('/landlord', 'LandlordController');
		// Route::group(['prefix' => 'landlord'], function()
		// {
		// 	Route::get('/',['as' => 'sales.landlord.index', 'permission' => 'view_all_landlords', 'uses' => 'LandlordController@index']);
		// 	Route::get('/create',['as' => 'sales.landlord.create', 'permission' => 'create_landlord', 'uses' => 'LandlordController@create']);
		// 	Route::post('/',['as' => 'sales.landlord.store', 'permission' => 'create_landlord', 'uses' => 'LandlordController@store']);
		// 	Route::get('{id}',['as' => 'sales.landlord.show', 'permission' => 'view_landlord', 'uses' => 'LandlordController@show']);
		// 	Route::get('{id}/edit',['as' => 'sales.landlord.edit', 'permission' => 'edit_landlord', 'uses' => 'LandlordController@edit']);
		// 	Route::post('{id}/edit',['as' => 'sales.landlord.update', 'permission' => 'edit_landlord', 'uses' => 'LandlordController@update']);
		// 	Route::post('{id}/delete',['as' => 'sales.landlord.delete', 'permission' => 'delete_landlord', 'uses' => 'LandlordController@delete']);
		// });

		Route::resource('device', 'DeviceController');
		// Route::group(['prefix' => 'device'], function()
		// {
		// 	Route::get('/',['as' => 'sales.device.index', 'permission' => 'view_all_devices', 'uses' => 'DeviceController@index']);
		// 	Route::get('/create',['as' => 'sales.device.create', 'permission' => 'create_device', 'uses' => 'DeviceController@create']);
		// 	Route::post('/',['as' => 'sales.device.store', 'permission' => 'view_all_devices', 'uses' => 'DeviceController@store']);
		// 	Route::get('{id}',['as' => 'sales.device.show', 'permission' => 'view_all_devices', 'uses' => 'DeviceController@show']);
		// 	Route::get('{id}/edit',['as' => 'sales.device.edit', 'permission' => 'view_all_devices', 'uses' => 'DeviceController@edit']);
		// 	Route::post('{id}/edit',['as' => 'sales.device.update', 'permission' => 'view_all_devices', 'uses' => 'DeviceController@update']);
		// 	Route::post('{id}/delete',['as' => 'sales.device.update', 'permission' => 'view_all_devices', 'uses' => 'DeviceController@delete']);
		// });

		Route::resource('payment', 'PaymentController');
		// Route::group(['prefix' => 'payment'], function()
		// {
		// 	Route::get('create', ['as' => 'sales.payment.create', 'permission' => 'is_sales_rep', 'uses' => 'PaymentController@create']);
		// 	Route::get('type', ['as' => 'sales.payment.type', 'permission' => 'is_sales_rep', 'uses' => 'PaymentController@type']);
		// 	Route::post('card', ['as' => 'sales.payment.card', 'permission' => 'is_sales_rep', 'uses' => 'PaymentController@card']);
		// });

		Route::resource('gateway', 'GatewayController');
		Route::resource('profile', 'ProfileController');
		Route::resource('billing', 'BillingController');
	});



	// Landlord Routes
	Route::group(['prefix' => 'landlord', 'namespace' => 'Landlord', 'middleware' => ['landlord']], function()
	{
		Route::get('/',['as' => 'landlord.index', 'permission' => 'is_landlord', 'uses' => '\App\Http\Controllers\HomeController@index']);
		Route::get('calendar', ['as' => 'landlord.calendar', 'permission' => 'is_landlord', 'uses' => '\App\Http\Controllers\Landlord\CalendarController@index']);
		Route::get('calendar/all', ['as' => 'landlord.calendar.all', 'permission' => 'is_landlord', 'uses' => '\App\Http\Controllers\Landlord\CalendarController@all']);
		Route::get('calculator', ['as' => 'landlord.calculator', 'permission' => 'is_landlord', 'uses' => '\App\Http\Controllers\Landlord\CalculatorController@index']);
		Route::get('calculator/estimate_roi', ['as' => 'landlord.calculator.estimate_roi', 'permission' => 'is_landlord', 'uses' => '\App\Http\Controllers\Landlord\CalculatorController@estimateRoi']);

		Route::get('maintenance/all', 'MaintenanceController@all');
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
		
		Route::get('managers/all', 'ManagerController@all');
		Route::patch('managers/properties', 'ManagerController@addProperties');
		Route::delete('managers/properties', 'ManagerController@removeProperties');
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



