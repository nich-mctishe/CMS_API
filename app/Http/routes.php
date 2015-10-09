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

Route::get('/', 'ViewController@runHome');
// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::group(['middleware' => 'auth'], function() {
    Route::get('auth/register', 'Auth\AuthController@getRegister');
    Route::post('auth/register', 'Auth\AuthController@postRegister');
});


Route::get('home', ['middleware' => 'auth', 'uses' => 'ViewController@redirectToBase']);
Route::group(['prefix' => 'route-master'], function ()
{
    Route::get('{routeSuffix}', 'ViewController@index');
    Route::get('lp/{routeSuffix}/{articleId?}', 'ViewController@landingPage');
});
Route::group(['prefix' => 'api'], function () {
    Route::get('{section}/{id?}', 'ApiController@show');
});
Route::group(['middleware' => 'auth', 'prefix' => 'api'], function () {
    //these may need to be out of before auth if further postman testing is required.
    Route::post('{section}/update/{id}', 'ApiController@update');
    Route::post('{section}/images/{parentId}/{id?}', 'ApiFileController@fileUploadAction');
    Route::post('{section}', 'ApiController@create');
    Route::delete('{section}/{id}', 'ApiController@destroy');
});
/**
 * this route is purely for development purposes remove before deployment.
 */
//Route::get('csrf', function()
//{
//    return Session::token();
//});
