<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/{accountType}/verfiy/{email}/{verifyCode}', 'admin\AdminController@verifyEmail');
Route::get('needToActive', function (){
    return view('needToActive');
});

Auth::routes(['verify' => true]);
Route::get('/trips/search', 'users\usersController@search')->name('user.trips.search');

Route::middleware(['auth','verified'])->group(function(){
    Route::get('/home', 'users\usersController@index')->name('home');
    Route::get('/trips/join/{trip_id}', 'users\usersController@joinToTrip')->name('users.joinTrip');
    Route::get('/trips/cancle/{trip_id}', 'users\usersController@cancleToTrip')->name('users.cancleTrip');

});

Route::group(['prefix' => 'admin'], function () {
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'AdminAuth\LoginController@login')->name('admin.post.login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('admin.register');
  Route::post('/register', 'AdminAuth\RegisterController@register')->name('admin.post.register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('admin.password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm')->name('admin.password.rest.token');
});

Route::group(['prefix' => 'company'], function () {
  Route::get('/login', 'CompanyAuth\LoginController@showLoginForm')->name('company.login');
  Route::post('/login', 'CompanyAuth\LoginController@login');
  Route::post('/logout', 'CompanyAuth\LoginController@logout')->name('company.logout');

  Route::get('/register', 'CompanyAuth\RegisterController@showRegistrationForm')->name('company.register');
  Route::post('/register', 'CompanyAuth\RegisterController@register');

  Route::post('/password/email', 'CompanyAuth\ForgotPasswordController@sendResetLinkEmail')->name('company.password.request');
  Route::post('/password/reset', 'CompanyAuth\ResetPasswordController@reset')->name('company.password.email');
  Route::get('/password/reset', 'CompanyAuth\ForgotPasswordController@showLinkRequestForm')->name('company.password.reset');
  Route::get('/password/reset/{token}', 'CompanyAuth\ResetPasswordController@showResetForm');
});

//auth admin routes
Route::group(['prefix' => 'admin',  'middleware' => ['admin','adminVerfied']], function()
{
    Route::get('/home', 'Admin\AdminController@homeAdmin')->name('home');;
    Route::get('/partners', 'Admin\AdminController@partnersControl');
    Route::get('/accept/partner/{partner_id}', 'Admin\AdminController@acceptPartner')->name('admin.accept.partner');
    Route::get('/reject/partner/{partner_id}', 'Admin\AdminController@rejectPartner')->name('admin.reject.partner');
    Route::get('/active/partner/{partner_id}', 'Admin\AdminController@activePartner')->name('admin.active.partner');
    Route::get('/users', 'Admin\AdminController@usersControl');
});
Route::group(['prefix' => 'company',  'middleware' => ['company','companyVerfied']], function(){
    Route::get('/trips/new','company\companyController@newTrip')->name('company.trips.new');
    Route::post('/trips/new','company\companyController@insertNewTrip')->name('company.trips.insert');
    Route::get('/trips/{action}/{trip_id}','company\companyController@controlTrip')->name('company.trips.control');
    Route::get('/tripDetails/{trip_id}','company\companyController@tripDetails')->name('company.trips.details');

});

