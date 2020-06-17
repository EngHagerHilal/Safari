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
Route::post('/forgotPassword', 'users\usersController@resendEmailPasswordAPI')->name('user.sendEmailReset');
Route::post('/resendEmailActivation','users\usersController@resendEmailActivation')->name('resend.email.activation.api');
Route::post('/new-message','Admin\AdminController@newMessage')->name('insert.new_message.api');

Route::get('/home','users\usersController@index')->name('user.home.api');
Route::get('/search','users\usersController@searchAPI')->name('user.search.api');
Route::post('/trip_datails/','users\usersController@tripDetailsAPI')->name('trips.details.api');
Route::post('/voucher/check', 'users\usersController@checkVoucher');
Route::post('/join','users\usersController@joinToTripAPI')->name('user.join.trip.api');
Route::post('/cancel','users\usersController@cancleToTripAPI')->name('user.cancel.trip.api');
Route::post('/tripDetails/rate/', 'users\usersController@rateTripAPI')->name('users.RateTrip.api');
Route::post('/myTrips','users\usersController@myJoinedTRipsAPI')->name('user.myTrips.api');
Route::post('/edit-profile/', 'users\usersController@editProfileAPI');//done
Route::post('/update-profile/', 'users\usersController@updateProfileAPI');//done


Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', 'AdminAuth\LoginController@ApiLogin')->name('admin.login.api');
    Route::post('/register', 'AdminAuth\RegisterController@APIregister')->name('admin.register.api');

    Route::post('/forgotPassword', 'AdminAuth\loginController@resendEmail')->name('admin.sendEmailReset');
    Route::post('/home', 'Admin\AdminController@APIhome')->name('admin.home.api');
    Route::post('/partners', 'Admin\AdminController@APIpartnersControl')->name('admin.companies.api');
    Route::post('/partner/accept/', 'Admin\AdminController@APIacceptCompant')->name('admin.companies.accept.api');
    Route::post('/partner/reject/', 'Admin\AdminController@APIrejectCompant')->name('admin.companies.reject.api');
    Route::post('/partner/block/', 'Admin\AdminController@APIblockCompant')->name('admin.companies.block.api');
    Route::post('/partner/active/', 'Admin\AdminController@APIactiveCompant')->name('admin.companies.active.api');


    Route::post('/users', 'Admin\AdminController@APIusersControl')->name('admin.users.api');
    Route::post('/users/accept/', 'Admin\AdminController@APIacceptCompant')->name('admin.companies.accept.api');
    Route::post('/users/reject/', 'Admin\AdminController@APIrejectCompant')->name('admin.companies.reject.api');
    Route::post('/edit-profile/', 'Admin\AdminController@editProfileAPI');//done
    Route::post('/update-profile/', 'Admin\AdminController@updateProfileAPI');//done

    Route::post('/ads/all', 'Admin\AdminController@allAdvertisementAPI');//done
    Route::post('/ads/new/', 'Admin\AdminController@insertNewADSAPI');//done
    Route::post('/ads/control/', 'Admin\AdminController@controlADSAPI');//done

});
Route::group(['prefix' => 'company'], function () {
    Route::post('/login', 'CompanyAuth\LoginController@ApiLogin')->name('company.login.api');
    Route::post('/register', 'CompanyAuth\RegisterController@APIregister')->name('company.register.api');
    Route::post('/forgotPassword', 'company\companyController@resendEmail')->name('company.sendEmailReset.api');

    Route::post('/my_trips/', 'company\companyController@homeAPI')->name('company.myTrips.api');
    Route::post('/trips/create', 'company\CompanyController@insertNewTripAPI')->name('company.create.trip.api');
    Route::post('/trips/trip_datails/', 'company\companyController@tripDetailsAPI')->name('company.trips.details.api');

    Route::post('/trips/control/', 'company\companyController@controlTripAPI')->name('company.trips.control.api');
    Route::post('/tripDetails/joiners/control', 'company\companyController@controlJoiners')->name('company.trip.control.joiner');
    Route::post('/edit-profile/', 'company\companyController@editProfileAPI')->name('company.editProfile.api');//done
    Route::post('/update-profile/', 'company\companyController@updateProfileAPI')->name('company.updateProfile.api');//done
    Route::post('/new-voucher', 'company\companyController@newVoucherAPI');//done
    Route::post('/check-QR-code/', 'company\companyController@checkUser_QR_API');//done
});
