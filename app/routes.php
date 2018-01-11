<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'AuthController@index');
Route::post('/', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
Route::get('/dashboard', 'AuthController@dashboard');

Route::get('/settings', 'UserController@settings');

Route::resource('/products', 'ProductController', array('except' => array('update')));
Route::resource('/suppliers', 'SupplierController', array('except' => array('update')));
Route::resource('/manufacturers', 'ManufacturerController', array('except' => array('update')));
Route::resource('/purchase-orders', 'PurchaseOrderController', array('except' => array('update')));
Route::resource('/virtual-products', 'VirtualProductController', array('except' => array('update')));
Route::resource('/purchase-orders-items', 'PurchaseOrderItemController', array('except' => array('update')));
Route::resource('/purchase-order-checkins', 'PurchaseOrderCheckinController', array('except' => array('update')));
Route::resource('/sales-orders', 'SalesOrderController', array('except' => array('update')));
Route::resource('/sales-orders-items', 'SalesOrderItemController', array('except' => array('update')));
Route::resource('/sales-orders-notes', 'SalesOrderNoteController', array('except' => array('update')));
Route::resource('/users', 'UserController', array('except' => array('update')));
Route::resource('/sellers', 'SellerController', array('except' => array('update')));
Route::resource('/shipments', 'ShipmentController', array('except' => array('update')));
Route::resource('/api', 'UserApiProfileController', array('except' => array('update')));
Route::resource('/adjustment-memos', 'AdjustmentMemoController', array('except' => array('update')));


Route::get('/sales/pull-orders/{appkey}', 'ApiPullController@getOrders');
Route::get('/reports/', 'ReportController@index');
Route::get('/sales-report/', 'ReportController@salesReport');
Route::get('/inventory-report/{seller}', 'ReportController@inventoryReport');
Route::get('/purchase-report/{seller}', 'ReportController@purchaseReport');
Route::get('/shipping-report/', 'ReportController@shippingReport');
Route::get('/void-shipment/{ship_id}/{order_id}', 'ShipmentController@void');
Route::get('/purchase/remove-item/{id}', 'PurchaseOrderController@removeItem');

Route::post('/products/{id}', 'ProductController@update');
Route::post('/adjustment-memos/{id}', 'AdjustmentMemoController@update');
Route::post('/suppliers/{id}', 'SupplierController@update');
Route::post('/manufacturers/{id}', 'ManufacturerController@update');
Route::post('/purchase-orders/{id}', 'PurchaseOrderController@update');
Route::post('/purchase-orders-items/{id}', 'PurchaseOrderItemController@update');
Route::post('/purchase-order-checkins/{id}', 'PurchaseOrderCheckinController@update');
Route::post('/sales-orders/{id}', 'SalesOrderController@update');
Route::post('/sales-orders-items/{id}', 'SalesOrderItemController@update');
Route::post('/sales-orders-notes/{id}', 'SalesOrderNoteController@update');
Route::post('/virtual-products/{id}', 'VirtualProductController@update');
Route::post('/users/{id}', 'UserController@update');
Route::post('/reports/{id}', 'ReportController@update');
Route::post('/invoice/{id}', 'PurchaseOrderController@invoice');
Route::post('/sellers/{id}', 'SellerController@update');
Route::post('/api/{id}', 'UserApiProfileController@update');
Route::post('/scan', 'ShipmentController@scanned');
Route::post('/orders-status/{id}', 'SalesOrderController@changeStatus');
Route::post('/purcahse-status/{id}', 'PurchaseOrderController@changeStatus');

Route::get('/amazonupdate/', 'AmazonUpdateController@orderUpdates');

Route::get('/quickbooks', 'QuickbooksController@index');
Route::get('/quickbooks/amazon', 'QuickbooksController@amazon');
Route::get('/quickbooks/amazonfl', 'QuickbooksController@amazonfl');
Route::get('/quickbooks/cscart', 'QuickbooksController@cscart');
Route::get('/quickbooks/cscartfl', 'QuickbooksController@cscartfl');
Route::get('/quickbooks/all', 'QuickbooksController@reports');

Route::get('/purchase-orders/{id}/pdf', 'PurchaseOrderController@pdf');