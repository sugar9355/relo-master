<?php

/*
|--------------------------------------------------------------------------
| User Authentication Routes
|--------------------------------------------------------------------------
*/

Auth::routes();

Route::get('auth/facebook', 'Auth\SocialLoginController@redirectToFaceBook');
Route::get('auth/facebook/callback', 'Auth\SocialLoginController@handleFacebookCallback');
Route::get('auth/google', 'Auth\SocialLoginController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\SocialLoginController@handleGoogleCallback');
Route::post('account/kit', 'Auth\SocialLoginController@account_kit')->name('account.kit');

/*
|--------------------------------------------------------------------------
| Provider Authentication Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'provider'], function () {

    Route::get('auth/facebook', 'Auth\SocialLoginController@providerToFaceBook');
    Route::get('auth/google', 'Auth\SocialLoginController@providerToGoogle');

    Route::get('/login', 'ProviderAuth\LoginController@showLoginForm');
    Route::post('/login', 'ProviderAuth\LoginController@login');
    Route::post('/logout', 'ProviderAuth\LoginController@logout');

    Route::get('/register', 'ProviderAuth\RegisterController@showRegistrationForm');
    Route::post('/register', 'ProviderAuth\RegisterController@register');

    Route::post('/password/email', 'ProviderAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'ProviderAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'ProviderAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'ProviderAuth\ResetPasswordController@showResetForm');
});

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/store', 'AdminAuth\LoginController@store');
    Route::post('/logout', 'AdminAuth\LoginController@logout');

    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

/*
|--------------------------------------------------------------------------
| Dispatcher Authentication Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'dispatcher'], function () {
    Route::get('/login', 'DispatcherAuth\LoginController@showLoginForm');
    Route::post('/login', 'DispatcherAuth\LoginController@login');
    Route::post('/logout', 'DispatcherAuth\LoginController@logout');

    Route::post('/password/email', 'DispatcherAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'DispatcherAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'DispatcherAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'DispatcherAuth\ResetPasswordController@showResetForm');
});

/*
|--------------------------------------------------------------------------
| Fleet Authentication Routes
|--------------------------------------------------------------------------
*/


Route::group(['prefix' => 'fleet'], function () {
    Route::get('/login', 'FleetAuth\LoginController@showLoginForm');
    Route::post('/login', 'FleetAuth\LoginController@login');
    Route::post('/logout', 'FleetAuth\LoginController@logout');

    Route::post('/password/email', 'FleetAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'FleetAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'FleetAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'FleetAuth\ResetPasswordController@showResetForm');
});

/*
|--------------------------------------------------------------------------
| Account Authentication Routes
|--------------------------------------------------------------------------
*/


Route::group(['prefix' => 'account'], function () {
    Route::get('/login', 'AccountAuth\LoginController@showLoginForm');
    Route::post('/login', 'AccountAuth\LoginController@login');
    Route::post('/logout', 'AccountAuth\LoginController@logout');

    Route::get('/register', 'AccountAuth\RegisterController@showRegistrationForm');
    Route::post('/register', 'AccountAuth\RegisterController@register');

    Route::post('/password/email', 'AccountAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'AccountAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'AccountAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'AccountAuth\ResetPasswordController@showResetForm');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
    Route::get('/', 'Auth\LoginController@showLoginForm');
    
//  ================ booking form =====================
    
    Route::any('/booking/{booking_id?}/{step?}',            'HomeController@booking')->name('booking');
    Route::get('/calendar/{booking_id?}',                     'HomeController@calendar')->name('calendar');
    // Route::get('/update_crew/{booking_id}/{crew}',             'HomeController@update_crew')->name('update_crew');
    Route::post('/update_crew/{booking_id}',             'HomeController@update_crew')->name('update_crew');
    Route::get('/update_insurance/{booking_id}/{amount}',     'HomeController@update_insurance')->name('update_insurance');
    Route::get('/update_item_insurance/{booking_id}/{booking_item_id}/{amount}', 'HomeController@update_item_insurance')->name('update_item_insurance');
    Route::any('/summary/{booking_id?}/{step?}',             'HomeController@summary')->name('summary');
    Route::any('/summary_shuffle/{booking_id?}/{step?}',             'HomeController@summary_shuffle')->name('summary_shuffle');
    Route::any('payment', 'HomeController@payment')->name('payment');
    
    Route::post('/update_location/{booking_id?}',         'Booking\LocationController@update_location')->name('update_location');
    
    Route::get('save_date/{booking_id}/{date}',         'Booking\BookingDateController@save_date')->name('save_date');
    Route::get('save_shuffle_date/{booking_id}/{date}/{type}',         'Booking\BookingDateController@save_shuffle_date')->name('save_shuffle_date');
    Route::get('save_shuffle_date_time/{booking_id}',         'Booking\BookingDateController@save_shuffle_date_time')->name('save_shuffle_date_time');
    Route::get('save_recommended_date/{booking_id}', 'Booking\BookingDateController@save_recommended_date')->name('save_recommended_date');
    // Route::post('save_date/{booking_id}', 'Booking\BookingDateController@save_date')->name('save_date');
    Route::get('save_time/{booking_id}/{start}/{end}',     'Booking\BookingDateController@save_time')->name('save_time');
    Route::post('save_loc',     'HomeController@save_loc')->name('save_loc');
    
    Route::post('/packaging/{booking_id?}',             'Booking\InventoryController@packaging')->name('packaging');
    Route::post('/quantity/{booking_id?}',                'Booking\InventoryController@quantity')->name('quantity');
    Route::post('/accuracy/{booking_id?}',                 'Booking\InventoryController@accuracy')->name('accuracy');
    Route::post('add_item/{booking_id}/',                 'Booking\InventoryController@add_item')->name('add_item');
    Route::post('add_preset/{booking_id}/', 'Booking\InventoryController@add_preset')->name('add_preset');
    Route::post('show_chosen_preset/{booking_id}/', 'HomeController@show_chosen_preset')->name('show_chosen_preset');
    Route::post('show_searched_item/{booking_id}/', 'HomeController@show_searched_item')->name('show_searched_item');
    Route::post('show_selected_items/{booking_id}/', 'HomeController@show_selected_items')->name('show_selected_items');
    Route::post('update_item_info/{booking_id}', 'Booking\InventoryController@update_item_info')->name('update_item_info');
    Route::get('delete_item/{booking_id}/{booking_item_id}', 'Booking\InventoryController@delete_item')->name('delete_item');
    Route::post('remove_item_preview/{booking_id}', 'HomeController@remove_item_preview')->name('remove_item_preview');
    Route::post('update_qty_item_preview/{booking_id}', 'HomeController@update_qty_item_preview')->name('update_qty_item_preview');
    Route::get('check_vehicle/{vtype_id}', 'HomeController@check_vehicle')->name('check_vehicle');
    Route::post('/change_vehicle/{booking_id}', 'HomeController@change_vehicle')->name('change_vehicle');
    Route::post('/save-remind-later','BookingController@saveRemindlater')->name('save-remind-later');
    Route::post('/saveBooking-future','BookingController@saveBooking')->name('saveBooking-future');
        

        
//  ================ booking form =====================

Route::get("/map", 'HomeController@showMap');

Route::post("/map", "HomeController@storeTempMapLocation");

Route::get('/date', 'HomeController@showDate');
Route::post("/date", "HomeController@storeTempDate");

Route::get('/drop_date', 'HomeController@showDropDate');
Route::post("/drop_date", "HomeController@storeTempDropDate");

Route::get('/location', 'HomeController@location');
Route::get('/get_ratio/{id}', 'HomeController@getRatio');
Route::get('/get_items/{id}', 'HomeController@getItemsByCategoryId');
Route::post('add_to_cart/{id}', 'HomeController@addToCart');

Route::get('testPay', 'HomeController@testPay');

Route::get("update_junk/{index}/{qty}", "HomeController@updateJunk");
Route::get("add_to_junk/{id}", "HomeController@addJunk");

Route::group(['middleware' => "web"], function (){
    Route::post('location/store', 'HomeController@storeTempLocation');
    Route::get('shop', 'HomeController@shop');
    Route::get('add_preset_cart/{id}', 'HomeController@addPreSetCart');
    Route::get('get_cart', 'HomeController@getSuccessResponse');
    Route::post('remove_to_cart/{id}', 'HomeController@removeToCart');
    Route::get('get_questions/{id}/{itemIds}', 'HomeController@getQuestions');
    Route::get('cart', 'HomeController@checkoutShow');
    Route::get('/insurance', 'HomeController@insurance');
    Route::post('/insurance', 'HomeController@storeInsurance');
    Route::post('checkout', 'HomeController@checkout');
    Route::get('thank-you', 'HomeController@thankYou');
});

/*Route::get('/initsetup', function () {
    return Setting::all();
});*/

/*Route::get('/ride', function () {
    return view('ride');
});

Route::get('/drive', function () {
    return view('drive');
});*/

/*Route::get('privacy', function () {
    $page = 'page_privacy';
    $title = 'Privacy Policy';
    return view('static', compact('page', 'title'));
});*/

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard/{booking?}', 'HomeController@dashboard');

// user profiles
Route::get('/profile', 'HomeControllerBackup@profile');
Route::get('/edit/profile', 'HomeControllerBackup@edit_profile');
Route::post('/profile', 'HomeControllerBackup@update_profile');

// update password
Route::get('/change/password', 'HomeControllerBackup@change_password');
Route::post('/change/password', 'HomeControllerBackup@update_password');

/*// ride
Route::get('/confirm/ride', 'RideController@confirm_ride');
Route::post('/create/ride', 'RideController@create_ride');
Route::post('/cancel/ride', 'RideController@cancel_ride');
Route::get('/onride', 'RideController@onride');
Route::post('/payment', 'PaymentController@payment');
Route::post('/rate', 'RideController@rate');*/

/*// status check
Route::get('/status', 'RideController@status');*/

// trips
Route::get('/trips', 'HomeControllerBackup@trips');
Route::get('/book_now/{type}/{id}', 'HomeController@bookNow');
Route::get('/upcoming/trips', 'HomeControllerBackup@upcoming_trips');
Route::get('/trip/show/{type}/{id}', 'HomeControllerBackup@showTrip');
Route::get('/trip/storage/item/{id}', 'HomeControllerBackup@getStorageItems');
Route::post('/trip/storage/return/{id}', 'HomeControllerBackup@storeReturnStorageRequest')->name('store.storage.return');

/*// wallet
Route::get('/wallet', 'HomeController@wallet');
Route::post('/add/money', 'PaymentController@add_money');*/

// payment
//Route::get('/payment', 'HomeControllerBackup@payment');

// card
Route::resource('card', 'Resource\CardResource');

/*// promotions
Route::get('/promotions', 'HomeController@promotions_index')->name('promocodes.index');
Route::post('/promotions', 'HomeController@promotions_store')->name('promocodes.store');*/


Route::post('replyhook', 'HomeController@replyhook')->name('replyhook');