<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api/v1'], function(){

    Route::get('/branches', 'ApiController@getAllBranches');
    Route::get('/vehicle_types', 'ApiController@getAllVehicleTypes');
    Route::post('/login', 'ApiController@login');
    Route::get('/profile', 'UsersController@driverProfile');
    Route::get('/logout', 'ApiController@logout');


    Route::get('/branches2', 'SoapController@getAllBranches');
    Route::get('/vehicle_types2', 'SoapController@getAllVehicleTypes');
    Route::get('/loging', 'ApiController@login');

});