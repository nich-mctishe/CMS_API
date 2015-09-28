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
Route::controllers([
    //register needs to be before auth
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
Route::get('home', ['middleware' => 'auth', 'uses' => 'HandlerController@index']);
Route::group(['prefix' => 'route-master'], function ()
{
    Route::get('{routeSuffix}', 'ViewController@index');

});
Route::group(['prefix' => 'api'], function ()
{
    Route::get('{section}/{id?}', 'ApiController@show');

    Route::post('{section}/update/{id}', 'ApiController@update');
    Route::post('{section}/images/{parentId}/{id?}', 'ApiFileController@fileUploadAction');
    Route::post('{section}', 'ApiController@create');
    Route::delete('{section}/{id}', 'ApiController@destroy');

    Route::group(['middleware' => 'auth'], function () {
        //these may need to be out of before auth if further postman testing is required.


    });
});
/**
 * this route is purely for development purposes remove before deployment.
 */
Route::get('csrf', function()
{
    return Session::token();
});
