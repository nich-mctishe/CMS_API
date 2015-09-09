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

Route::group(['prefix' => 'api'], function () {

//    Route::get('{section}/{?id}');
//
//    Route::group(['middleware' => 'auth'], function () {
//        Route::post('{section}');
//        Route::put('{section}/{id}');
//        Route::delete('{section}/{id}');
//    });
});

// CRUD actions.

//DATABASE TABLES AND APPLICATION THEMES
//SKILLS
// belongs to skillCategory
// id | name | Category | desc
//skillCategory
//id | name

//CLIENTS
//hasOne Image
//id | name | Desc | Date Started | Date Ended | Role


//WORK EXPERIENCE
//hasOne image
//id | name | desc

//PROJECTS
//hasMany Image
//hasMany skillTags
//id | title | Desc | moreInfo

//skillTags
//hasOne skill
//id | skillId | projectId | projletId

//PROJLETS
//hasMany Images
//hasMany skillTags
//id | title | Desc

//image (could be a video)
//belongsTo projects
//belongsTo projlets
//belongsTo clients
//belongsTo workExperience
//id | fileName | folderLoc | parentId | parentSection | local:bool


