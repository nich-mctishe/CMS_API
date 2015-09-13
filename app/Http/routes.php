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

Route::get('/', function () {
    return view('welcome');
});
/**
 * this route is purely for development purposes
 */
Route::get('csrf', function() {
    return Session::token();
});
Route::controllers([
    //register needs to be before auth
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
Route::get('home', ['middleware' => 'auth', 'uses' => 'HandlerController@index']);

Route::group(['prefix' => 'api'], function () {

    Route::get('{section}/{id?}', 'ApiController@show');

    //this is temporary, these will need to be before auth.
    Route::post('{section}/update/{id}', 'ApiController@update');
    Route::post('{section}', 'ApiController@create');
    Route::delete('{section}/{id}', 'ApiController@destroy');

    Route::group(['middleware' => 'auth'], function () {

        //Route::delete('{section}/{id}', 'ApiController@destroy');
    });
});



