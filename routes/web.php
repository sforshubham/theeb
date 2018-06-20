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

Route::get('/', 'GuestController@guest');
Route::get('/login', 'GuestController@guest');

// Language Switcher
Route::get('/lang_switch/{locale}', function ($locale) {
    Cookie::queue(Cookie::make('locale', $locale, 365 * 24 * 60));
    if (session()->has('user.IDNo')) {
        return redirect('/book');
    } else {
        return redirect('/');
    }
});
Route::get('/get_sfname/{locale}', function ($locale) {
    $locale = strtolower($locale);
    if ($locale == 'ar' || $locale == 'en') {
        //
    } else {
            $locale = 'ar';
    }
    App::setLocale($locale);
    Cookie::queue(Cookie::make('locale', $locale, 365 * 24 * 60));
    if (session()->has('user.FirstName')) {
    $name = view('includes.user-menu');
    } else {
        $name = '';
    }
    return $name;
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
Route::post('/new_reservation', ['as'=> 'new_reservation', 'uses'=>'UsersController@newReservation']);
Route::post('/modify_reservation', ['as'=> 'modify_reservation', 'uses'=>'UsersController@modifyReservation']);
Route::post('/cancel_reservation', ['as'=> 'cancel_reservation', 'uses'=>'UsersController@cancelReservation']);
Route::get('/tariff', 'UsersController@tariff');
Route::get('/book', 'UsersController@rentACar');
Route::get('/edit_profile', 'UsersController@editRenderView');
Route::get('/change_password', 'UsersController@changePassword');
Route::get('/car_detail/{index}', 'UsersController@viewCarDetail');
Route::get('/payment_mode', ['as'=> 'payment_mode', 'uses'=>'UsersController@paymentMode']);
Route::get('/payment_result', ['as'=> 'payment_result', 'uses'=>'UsersController@paymentMode']);
Route::post('/payment_request_route', ['as'=> 'payment_request_route', 'uses'=>'UsersController@paymentMode']);
Route::get('/payment_response_route', ['as'=> 'payment_response_route', 'uses'=>'UsersController@paymentMode']);
Route::post('/payment_response_route', ['as'=> 'payment_response_route', 'uses'=>'UsersController@paymentMode']);

Route::post('/edit_profile', 'UsersController@updateProfile');
Route::get('/testq', function () {
    return view('test');
});

// Rental History - Transaction API
Route::get('/agreement', ['as'=>"agreement", 'uses'=>'UsersController@getTransDetails']);
Route::get('/invoice', ['as'=>"invoice", 'uses'=>'UsersController@getTransDetails']);
Route::get('/payment', ['as'=>"payment", 'uses'=>'UsersController@getTransDetails']);
Route::get('/reservation', ['as'=>"reservation", 'uses'=>'UsersController@getTransDetails']);

// Signup & View & Update
Route::get('/signup', ['as'=>"signup", 'uses'=>'GuestController@createModifyDriver']);
Route::post('/signup', ['as'=>"signup", 'uses'=>'GuestController@createModifyDriver']);
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
Route::post('/download_rental_history_pdf', 'UsersController@downloadRentalHistoryPdf');

Route::get('/verify', ['as'=>'g', 'uses'=>'GuestController@verifyOTP']);
Route::post('/verify', ['as'=>'p', 'uses'=>'GuestController@verifyOTP']);