<?php

use Illuminate\Http\Request;
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


Route::group([
    'namespace' => 'API',
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'UserController@user');
        Route::post('user/update', 'UserController@update');
        Route::post('property/store', 'PropertyController@store');
        Route::post('property/{property}/update', 'PropertyController@update');
        Route::get('property/delete/{property}', 'PropertyController@delete');
    });
});

Route::group([
    'namespace' => 'API',
    'middleware' => 'api'
], function () {


    Route::get('listing_type', 'PropertyOptionsController@listing_type');
    Route::get('rooms_type', 'PropertyOptionsController@rooms_type');
    Route::get('property_type', 'PropertyOptionsController@property_type');


    Route::get('/home/properties', 'PropertyController@index');
    Route::get('/user/{user}', 'UserController@view');
    Route::get('/user/properties/{user}', 'UserController@properties');
    Route::get('/property/{property}', 'PropertyController@show');
});

Route::group([
    'namespace' => 'API',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('sendmail', 'PasswordResetController@sendResetLinkEmail');
});
