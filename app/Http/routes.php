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

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', ['as' => 'login.index', 'uses' => 'AuthController@index']);
    Route::post('/login', ['as' => 'login.store', 'uses' => 'AuthController@login']);
    Route::get('/register', ['as' => 'register.index', 'uses' => 'RegisterController@index']);
    Route::post('/register', ['as' => 'register.store', 'uses' => 'RegisterController@store']);
    Route::get('/forgot-password', [
        'as' => 'login.forgot-password-form',
        'uses' => 'AuthController@forgotPasswordForm'
    ]);
    Route::post('/forgot-password', ['as' => 'login.forgot-password', 'uses' => 'AuthController@forgotPassword']);
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/logout', ['as' =>'logout', 'uses' => 'AuthController@logout']);
    Route::get('/', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);
});
