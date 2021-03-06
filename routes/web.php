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

Route::get('/', 'WelcomeController@index');
Route::get('/clear-cache', function() {

    $exitCode = Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    // return what you want
});
Route::get('/clear-config', function() {

    Artisan::call('config:clear');
    // return what you want
});
Route::get('/many-seed', function() {

    Artisan::call('db:seed --class=ManyTherapistSeeder');
    // return what you want
});
Route::get('/cache-config', function() {

    Artisan::call('config:cache');
    // return what you want
});

Route::get('/search','WelcomeController@search');
Route::get('/terms','WelcomeController@terms');
Route::get('/about','WelcomeController@about');
Route::get('/privacy-policy','WelcomeController@privacyPolicy');

Auth::routes();
Route::group(['prefix'=>'admin'],function(){
    Route::get('/login','Auth\LoginController@showAdminLogin');
    Route::post('/login','Auth\LoginController@adminLogin')->name('admin.login');

});


Route::group(['prefix'=>'therapist'],function(){
    Route::get('/login','Auth\LoginController@showTherapistLogin');
    Route::post('/login','Auth\LoginController@therapistLogin')->name('therapist.login');
    Route::get('/register','Auth\RegisterController@showTherapistRegister');
    Route::post('/register','Auth\RegisterController@therapistRegister');
    Route::get('/dashboard','Therapist\DashboardController@index');
    Route::get('/edit-profile','Therapist\DashboardController@editProfile');
    Route::post('/edit-profile','Therapist\DashboardController@updateProfile');
    Route::resource('/service','Therapist\TherapistServiceController');
    Route::post('/edit-any-profile-detail','Therapist\TherapistServiceController@editAnyProfileDetail');
    Route::resource('/education','Therapist\TherapistEducationController');
    Route::resource('/specialization','Therapist\TherapistSpecializationController');
    Route::resource('/schedule','Therapist\TherapistScheduleController');
    Route::post('/schedule-by-date','Therapist\TherapistScheduleController@searchByDate');
    Route::get('/bookings','Therapist\BookingController@index');
    Route::post('/booking/{id}','Therapist\BookingController@update');
    Route::get('/reviews','Therapist\DashboardController@reviews');
    Route::get('/subscription','Therapist\SubscriptionController@getSubscription');
    Route::post('/subscription','Therapist\SubscriptionController@postSubscription');
    //Password reset routes
    Route::get('password/reset', 'Therapist\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'Therapist\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'Therapist\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Therapist\ResetPasswordController@reset');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/therapist-profile/{slug}','WelcomeController@therapistSearch');
Route::post('/schedule-by-date-and-slug','WelcomeController@searchByDateAndSlug');
Route::post('/new-schedule','WelcomeController@newSchedule');


Route::group(['prefix'=>'user'],function(){
   Route::resource('booking','User\BookingController');
   Route::get('/dashboard','User\DashboardController@index');
    Route::get('/edit-profile','User\DashboardController@editProfile');
    Route::post('/edit-profile','User\DashboardController@updateProfile');
    Route::get('/bookings','User\DashboardController@reviews');
    Route::get('/bookings','User\DashboardController@bookings');
    Route::post('/booking/{id}','User\DashboardController@updateBooking');
    Route::get('/reviews','User\DashboardController@reviews');
    Route::post('/api/booking','User\BookingController@apiBooking');

});
Route::get('/submit-review/{slug}', 'User\ReviewController@create');
Route::post('/submit-review/{slug}', 'User\ReviewController@store');
Route::get('/social-login/{provider}', 'SocialController@redirect');
Route::get('login/{provider}/callback','SocialController@Callback');
Route::get('/t-social-login/{provider}', 'SocialController@therapistRedirect');
Route::get('t-login/{provider}/callback','SocialController@therapistCallback');
Route::get('/plans','WelcomeController@plans');

Route::post('/api/login','Auth\LoginController@userApiLogin');
Route::post('/api/register','Auth\RegisterController@userApiRegister');
Route::post('/api/t-login','Auth\LoginController@therapistApiLogin');
Route::post('/api/t-register','Auth\RegisterController@therapistApiRegister');
Route::get('/admin-register','Auth\RegisterController@showAdminTherapistRegister');
Route::post('/admin-register','Auth\RegisterController@adminTherapistRegister');




