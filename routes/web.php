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

Route::get('/search','WelcomeController@search');

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



});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/therapist-profile/{slug}','WelcomeController@therapistSearch');
Route::post('/schedule-by-date-and-slug','WelcomeController@searchByDateAndSlug');


Route::group(['prefix'=>'user'],function(){
   Route::resource('booking','User\BookingController');
});


