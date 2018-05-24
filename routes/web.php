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
    if (session()->has('user.IDNo')) {
        return redirect('/book');
    } else {
        return view('app.login');
    }
});

Route::group(['prefix' => 'api/v1'], function(){

});

Route::get('/branches', 'GuestController@getAllBranches');
Route::get('/vehicle_types', 'GuestController@getAllVehicleTypes');
Route::get('/logout', 'GuestController@logout');
Route::post('/login', 'GuestController@login');
Route::post('/forgot_password', 'GuestController@forgotPassword');
Route::get('/request_password', 'GuestController@requestPassword');

Route::get('/profile', 'UsersController@driverProfile');
Route::get('/price_estimation', 'UsersController@priceEstimation');
Route::post('/reset_password', 'UsersController@resetPassword');
Route::post('/payment', 'UsersController@makePayment');
Route::post('/document_print', 'UsersController@documentPrint');
Route::get('/booking', 'UsersController@myBooking');
Route::post('/new_reservation', 'UsersController@manageReservation');
Route::post('/modify_reservation', 'UsersController@manageReservation');
Route::post('/cancel_reservation', 'UsersController@manageReservation');
Route::get('/tariff', 'UsersController@tariff');
Route::get('/book', 'UsersController@rentACar');
Route::get('/change_password', 'UsersController@changePassword');

Route::get('/testq', function () {
    return view('test');
});

// Rental History - Transaction API
Route::get('/agreement', ['as'=>"agreement", 'uses'=>'UsersController@getTransDetails']);
Route::get('/invoice', ['as'=>"invoice", 'uses'=>'UsersController@getTransDetails']);
Route::get('/payment', ['as'=>"payment", 'uses'=>'UsersController@getTransDetails']);
Route::get('/reservation', ['as'=>"reservation", 'uses'=>'UsersController@getTransDetails']);

// Signup & View & Update
Route::get('/signup', 'GuestController@createModifyDriver');
Route::post('/signup', 'GuestController@createModifyDriver');
Route::get('/view_driver', ['as'=>"view_driver", 'uses'=>'GuestController@createModifyDriver']);

/**
 * Delete below given routes CAREFULLY
 */
Route::get('/branches2', 'SoapController@getAllBranches');
Route::get('/vehicle_types2', 'SoapController@getAllVehicleTypes');
Route::get('/loging', 'GuestController@login');
//Route::get('/profile', 'UsersController@driverProfile');
Route::get('/test', 'SoapController@noshow');
Route::get('/payfort', 'UsersController@payFortPay');
Route::get('/maps', 'GuestController@maps');
Route::get('/sharer', 'GuestController@sharer');
