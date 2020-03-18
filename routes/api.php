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

    Route::get('/user/{id}', 'UserController@view');

    Route::get('/home/properties', 'PropertyController@index');
    Route::get('/property/{id}', 'PropertyController@show');


    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'UserController@user');
        Route::resource('properties', 'PropertyController');
        // Route::get('/property/{id}', 'PropertyController@show');
        // Route::post('/property/save', 'PropertyController@store');
        // Route::post('/property/update', 'PropertyController@update');
        // Route::get('/property/delete/{id}/{api_token}', 'PropertyController@delete');





    });
});

Route::group([
    'namespace' => 'API',
    'middleware' => 'api',
    'prefix' => 'password'
], function () {
    Route::post('sendmail', 'PasswordResetController@sendResetLinkEmail');
});
