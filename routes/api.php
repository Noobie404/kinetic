<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::namespace('App\Http\Controllers\Api')->group(function () {
    Route::post('login', [ 'uses' => 'AuthController@postLogin']);
    Route::post('customer/login', [ 'uses' => 'CustomerAuthController@postLogin']);
    Route::get('region-list', 'AuthController1@user');

    Route::group(['middleware' => 'jwt.verify'], function(){
        Route::post('logout', 'AuthController@logout');
    });

    Route::group(['middleware' => [ 'jwt.verify', 'jwt.role:admin']], function(){
        Route::get('customer/list', 'CustomerController@allCustomers');
        Route::get('customer/edit/{id}', 'CustomerController@editCustomer');
        Route::get('customer/delete/{id}', 'CustomerController@deleteCustomer');
        Route::post('customer/store', 'CustomerController@storeCustomer');
        Route::post('customer/update', 'CustomerController@updateCustomer');
        Route::get('bill/list', 'BillController@allBills');
        Route::get('bill/new', 'BillController@createBill');
        Route::post('bill/store', 'BillController@storeBill');
        Route::get('bill/edit/{id}', 'BillController@editBill');
        Route::get('bill/delete/{id}', 'BillController@deleteBill');
        Route::post('bill/update', 'BillController@updateBill');
    });
    Route::group(['middleware' => [ 'jwt.verify', 'jwt.role:customer']], function(){
        Route::get('customer/bill/list/{id}', 'CustomerBillController@allBills');
    });

});
