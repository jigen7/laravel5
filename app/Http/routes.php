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

Route::get('jigen',['as' => 'jigen_sample', 'uses' => 'JigenController@jigenAction']);

//Set Prefilter and Postfilter as Middleware
Route::group(['middleware' => ['prefilters','postfilters']], function() {
    require __DIR__.'/Routes/routes_api.php';
});

//Route::group(['middleware' => 'auth'], function()
//{
    // Only authenticated users may enter...
//    require __DIR__.'/Routes/routes_cms.php';
//});

//CMS Login with Google OAuth
//Route::get('cms/login-google', 'Cms\LoginController@loginWithGoogle');

//Route::get('cms/login', 'Cms\LoginController@login');
//Route::get('cms/logout', 'Cms\LoginController@logout');


