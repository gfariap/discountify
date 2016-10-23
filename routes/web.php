<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'AuthController@index')->name('index');
Route::get('callback', 'AuthController@callback')->name('callback');
Route::get('index', function() {
    return view('index');
});
Route::group([ 'prefix' => '{store}' ], function() {
    Route::get('discounts', 'DiscountsController@index')->name('discounts');
    Route::get('customize', 'ThemeController@index')->name('customize');
    Route::put('customize', 'ThemeController@update')->name('customize.update');
});