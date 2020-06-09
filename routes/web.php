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
Route::get('/locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});
Route::get('/{accountType}/verfiy/{email}/{verifyCode}', 'admin\AdminController@verifyEmail');
Route::get('needToActive', function (){
    return view('needToActive');
});
//to view th form
Route::get('user/forgotPassword', function (){
        return view('auth.passwordReset');
    })->name('forgotPassword');
Route::get('company/forgotPassword', function (){
        return view('company.passwordReset');
    })->name('company.forgoYourPassword');
Route::get('admin/forgotPassword', function (){
        return view('admin.passwordReset');
    })->name('admin.forgotPassword');

//to send email
Route::post('user/forgotPassword', 'Auth\loginController@resendEmail')->name('user.sendEmailReset');
Route::post('company/forgotPassword', 'CompanyAuth\loginController@resendEmail')->name('company.sendEmailReset');
Route::post('admin/forgotPassword', 'AdminAuth\loginController@resendEmail')->name('admin.sendEmailReset');
//to view reset new pass form
Route::get('{type}/resetPassword/{email}/{verfiyCode}', 'AdminAuth\loginController@ViewResetForm')->name('newPassResetForm');
Route::post('updatePassword', 'AdminAuth\loginController@updateNewPassword')->name('updatePassword');

Route::middleware('company.guest')->group(function (){
    Auth::routes(['verify' => true]);
    Route::get('/trips/search', 'users\usersController@search')->name('user.trips.search')->middleware('company.guest');
    Route::get('/trips/searchPagination', 'users\usersController@searchPagination')->name('user.trips.search.Pagination')->middleware('company.guest');
    Route::get('/home', 'users\usersController@index')->name('home')->middleware('company.guest');
    Route::get('/pagination', 'users\usersController@pagination')->name('paginatePosts')->middleware('company.guest');
    Route::get('/', 'users\usersController@index')->name('home')->middleware('company.guest');
    Route::get('/tripDetails/{trip_id}/', 'users\usersController@tripDetails')->name('users.tripDetails');
    Route::get('/edit-profile/', 'users\usersController@editProfile')->name('users.editProfile')->middleware(['auth','verified']);
    Route::post('/edit-profile/', 'users\usersController@updateProfile')->name('users.updateProfile')->middleware(['auth','verified']);

});

Route::middleware(['auth','verified'])->group(function(){
    Route::get('/myTrips', 'users\usersController@myTrips')->name('myJoinedTrips');
    Route::post('/trips/join', 'paypalController@payWithPayPal')->name('users.joinTrip');
    Route::get('/paypal/status/{trip_id}/{voucher_code?}', 'paypalController@joinToTrip')->name('paypal.status');
    Route::get('/trips/cancle/{trip_id}', 'users\usersController@cancleToTrip')->name('users.cancleTrip');
    Route::get('/tripDetails/rate/{trip_id}/{rate}', 'users\usersController@rateTrip')->name('users.RateTrip');
    Route::get('/voucher/check', 'users\usersController@checkVoucher')->name('users.check.voucher');

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

Route::group(['prefix' => 'company','middleware'=>'guest'], function () {
  Route::get('/login', 'CompanyAuth\LoginController@showLoginForm')->name('company.joinTrip');
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
    Route::get('/home', 'Admin\AdminController@homeAdmin')->name('admin.home');
    Route::get('/partners', 'Admin\AdminController@partnersControl');
    Route::get('/accept/partner/{partner_id}', 'Admin\AdminController@acceptPartner')->name('admin.accept.partner');
    Route::get('/reject/partner/{partner_id}', 'Admin\AdminController@rejectPartner')->name('admin.reject.partner');
    Route::get('/active/partner/{partner_id}', 'Admin\AdminController@activePartner')->name('admin.active.partner');
    Route::get('/users', 'Admin\AdminController@usersControl');
    Route::get('/users/{control}/{user_id}/', 'Admin\AdminController@blockUser')->name('users.control');
    Route::get('/edit-profile/', 'Admin\AdminController@editProfile')->name('company.editProfile');
    Route::post('/edit-profile/', 'Admin\AdminController@updateProfile')->name('company.updateProfile');

});
Route::group(['prefix' => 'company',  'middleware' => ['company','companyVerfied','guest']], function(){
    Route::get('/home', 'company\CompanyController@home')->name('home');
    Route::get('/trips/new','company\companyController@newTrip')->name('company.trips.new');
    Route::post('/trips/new','company\companyController@insertNewTrip')->name('company.trips.insert');
    Route::get('/trips/{action}/{trip_id}','company\companyController@controlTrip')->name('company.trips.control');
    Route::get('/tripDetails/{trip_id}','company\companyController@tripDetails')->name('company.trips.details');
    Route::post('/new-voucher','company\companyController@newVoucher')->name('company.trips.newVoucher');
    Route::get('/tripDetails/joiners/{action}/{trip_id}/{user_id}','company\companyController@controlJoiners')->name('company.trip.control.joiner');
    Route::get('/edit-profile/', 'company\companyController@editProfile')->name('company.editProfile');
    Route::post('/edit-profile/', 'company\companyController@updateProfile')->name('company.updateProfile');
    Route::post('/check-QR-code/', 'company\companyController@readQRcod')->name('company.checkQRCode');//check joiners code

});

