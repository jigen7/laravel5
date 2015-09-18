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

// Web Routes

Route::group(array('prefix'=>'panel','module'=>'Cms','namespace' => 'App\Modules\Cms\Controllers'), function() {

Route::get('sample', 'CustomCmsController@testAction');





});
