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

Route::get('/search','WelcomeController@search');

Auth::routes();
Route::group(['prefix'=>'admin'],function(){
    Route::get('/login','Auth\LoginController@showAdminLogin');
    Route::post('/login','Auth\LoginController@adminLogin')->name('admin.login');
});
Route::get('/home', 'HomeController@index')->name('home');
