<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login','Auth\LoginController@ApiLogin')->name('user.login.api');
Route::post('/register','Auth\RegisterController@APIregister')->name('user.register.api');
Route::post('/home','users\usersController@indexAPI')->name('user.home.api');
Route::post('/trip_datails/','users\usersController@tripDetailsAPI')->name('trips.details.api');
Route::post('/join','users\usersController@joinToTripAPI')->name('user.join.trip.api');
Route::post('/cancel','users\usersController@cancleToTripAPI')->name('user.cancel.trip.api');
Route::post('/search','users\usersController@searchAPI')->name('user.search.api');

Route::post('/admin/login','AdminAuth\LoginController@ApiLogin')->name('admin.login.api');
Route::post('/admin/register','AdminAuth\RegisterController@APIregister')->name('admin.register.api');
Route::post('/admin/home','Admin\AdminController@APIhome')->name('admin.home.api');
Route::post('/admin/companies','Admin\AdminController@APIpartnersControl')->name('admin.companies.api');
Route::post('/admin/companies/accept/','Admin\AdminController@APIacceptCompant')->name('admin.companies.accept.api');
Route::post('/admin/companies/reject/','Admin\AdminController@APIrejectCompant')->name('admin.companies.reject.api');

Route::post('/admin/users','Admin\AdminController@APIusersControl')->name('admin.users.api');
Route::post('/admin/users/accept/','Admin\AdminController@APIacceptCompant')->name('admin.companies.accept.api');
Route::post('/admin/users/reject/','Admin\AdminController@APIrejectCompant')->name('admin.companies.reject.api');

Route::post('/company/login','CompanyAuth\LoginController@ApiLogin')->name('company.login.api');
Route::post('/company/register','CompanyAuth\RegisterController@APIregister')->name('company.register.api');
Route::post('/company/my_trips/','company\companyController@homeAPI')->name('company.myTrips.api');
Route::post('/company/trips/create','company\CompanyController@insertNewTripAPI')->name('company.create.trip.api');
Route::post('/company/trips/control/','company\companyController@controlTripAPI')->name('company.trips.control.api');
Route::post('/company/trips/trip_datails/','company\companyController@tripDetailsAPI')->name('company.trips.details.api');
