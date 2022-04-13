<?php

use Illuminate\Http\Request;
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
    // Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
        // Route::get('clear', [ 'uses' => 'V1\CommonController@clear' ]);
    Route::post('login', [ 'uses' => 'AuthController@postLogin']);
    Route::post('customer/login', [ 'uses' => 'CustomerAuthController@postLogin']);
    Route::get('region-list', 'AuthController1@user');

    // Route::group(['middleware' => 'jwt.verify'], function(){
    Route::group(['middleware' => ['jwt.role:admin', 'jwt.auth']], function(){
        Route::get('customer/list', 'CustomerController@allCustomers');
        Route::get('user', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
    });
});
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
