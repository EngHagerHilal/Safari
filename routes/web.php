<?php


use Illuminate\Support\Facades\Auth;
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
Route::get('/exp',function(){
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
});
Route::get('/locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});
Route::any('/resendEmailActivation','users\usersController@resendEmailActivation')->name('resend.email.activation');

Route::get('/{accountType}/verfiy/{email}/{verifyCode}', 'Admin\AdminController@verifyEmail');
Route::get('needToActive', function (){
    if(\Illuminate\Support\Facades\Auth::check()){
        if(\auth()->user()->hasVerifiedEmail())
            return redirect(url('/'));
        return view('needToActive');
    }
    elseif(\Illuminate\Support\Facades\Auth::guard('company')->check()){
        if(\auth()->guard('company')->user()->hasVerifiedEmail())
            return redirect(url('/'));
        return view('company.needToActive');
    }
   return redirect(\route('login'));
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
Route::get('{type}/resetPassword/{email}/{verfiyCode}', 'AdminAuth\LoginController@ViewResetForm')->name('newPassResetForm');
Route::post('/updatePassword', 'AdminAuth\LoginController@updateNewPassword')->name('updatePassword');


Route::get('/about-us', function (){
    return view('admin.about-us');
})->name('about-us');
Route::get('/terms', function (){
    return view('admin.terms');
})->name('terms');

Route::get('/new-message', function (){
    return view('admin.message_to_admin');
})->name('new-message');

Route::post('/new-message','Admin\AdminController@newMessage')->name('insert.new_message');

Route::middleware('company.guest')->group(function (){
    Auth::routes(['verify' => true]);
    Route::get('/trips/search', 'users\usersController@search')->name('user.trips.search')->middleware('company.guest');
    Route::get('/trips/searching', function (){
        return view('searching');
    })->name('user.trips.search.mobile')->middleware('company.guest');
    Route::get('/trips/searchPagination', 'users\usersController@searchPagination')->name('user.trips.search.Pagination')->middleware('company.guest');
    Route::get('/home', 'users\usersController@index')->name('home')->middleware('company.guest');
    Route::get('/pagination', 'users\usersController@pagination')->name('paginatePosts')->middleware('company.guest');
    Route::get('/', 'users\usersController@index')->name('home')->middleware('company.guest');
    Route::get('/tripDetails/{trip_id}/', 'users\usersController@tripDetails')->name('users.tripDetails');

});

Route::middleware(['auth','usersVerfied'])->group(function(){
    Route::get('/edit-profile/', 'users\usersController@editProfile')->name('users.editProfile')->middleware(['auth','verified']);
    Route::post('/edit-profile/', 'users\usersController@updateProfile')->name('users.updateProfile')->middleware(['auth','verified']);

    Route::get('/myTrips', 'users\usersController@myTrips')->name('myJoinedTrips');
    Route::post('/trips/join', 'paypalController@payWithPayPal')->name('users.joinTrip');
    Route::get('/paypal/status/{trip_id}/{voucher_code?}', 'paypalController@joinToTrip')->name('paypal.status');
    Route::get('/trips/cancle/{trip_id}', 'users\usersController@cancleToTrip')->name('users.cancleTrip');
    Route::any('/tripDetails/rate/{trip_id}/{rate}', 'users\usersController@rateTrip')->name('users.RateTrip');
    Route::get('/voucher/check', 'users\usersController@checkVoucher')->name('users.check.voucher');

});

Route::group(['prefix' => 'admin'], function () {
  Route::get('/login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'AdminAuth\LoginController@login')->name('admin.post.login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('admin.logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('admin.register');
  Route::post('/register', 'AdminAuth\RegisterController@APIregister')->name('admin.post.register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('admin.password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm')->name('admin.password.rest.token');
});

Route::group(['prefix' => 'company','middleware'=>'guest'], function () {
  Route::get('/login', 'CompanyAuth\LoginController@showLoginForm')->name('company.login');
  Route::post('/login', 'CompanyAuth\LoginController@login');
  Route::post('/logout', 'CompanyAuth\LoginController@logout')->name('company.logout');
  Route::get('/register', 'CompanyAuth\RegisterController@showRegistrationForm')->name('company.register');
  Route::post('/register', 'CompanyAuth\RegisterController@register');
  Route::post('/password/email', 'CompanyAuth\ForgotPasswordController@sendResetLinkEmail')->name('company.password.request');
  Route::post('/password/reset', 'CompanyAuth\ResetPasswordController@reset')->name('company.password.email');
  Route::get('/password/reset', 'CompanyAuth\ForgotPasswordController@showLinkRequestForm')->name('company.password.reset');
  Route::get('/password/reset/{token}', 'CompanyAuth\ResetPasswordController@showResetForm');
    Route::get('/home', 'company\companyController@home')->name('home')->middleware('company');

    Route::get('/edit-profile/', 'company\companyController@editProfile')->middleware('company')->name('company.editProfile');

    Route::post('/edit-profile/', 'company\companyController@updateProfile')->middleware('company')->name('company.updateProfile');

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
    Route::get('/edit-profile/', 'Admin\AdminController@editProfile')->name('admin.editProfile');
    Route::post('/edit-profile/', 'Admin\AdminController@updateProfile')->name('admin.updateProfile');
    Route::get('/advertisement','Admin\AdminController@allAdvertisement')->name('advertisement');
    Route::get('/advertisement/new','Admin\AdminController@newADS')->name('ads.new');
    Route::post('/advertisement/insert','Admin\AdminController@insertNewADS')->name('admin.insert.new.ads');
    Route::get('/ads/control/{control}/{ads_id}','Admin\AdminController@controlADS')->name('ads.control');
});
Route::group(['prefix' => 'company',  'middleware' => ['company','companyVerfied','guest',]], function(){
    Route::get('/trips/new','company\companyController@newTrip')->name('company.trips.new')->middleware('companyAccepted');
    Route::post('/trips/new','company\companyController@insertNewTrip')->name('company.trips.insert')->middleware('companyAccepted');;
    Route::get('/trips/{action}/{trip_id}','company\companyController@controlTrip')->name('company.trips.control')->middleware('companyAccepted');;
    Route::get('/tripDetails/{trip_id}','company\companyController@tripDetails')->name('company.trips.details')->middleware('companyAccepted');;
    Route::post('/new-voucher','company\companyController@newVoucher')->name('company.trips.newVoucher')->middleware('companyAccepted');;
    Route::get('/tripDetails/joiners/{action}/{trip_id}/{user_id}','company\companyController@controlJoiners')->name('company.trip.control.joiner')->middleware('companyAccepted');;
    Route::post('/check-QR-code/', 'company\companyController@readQRcod')->name('company.checkQRCode')->middleware('companyAccepted');;//check joiners code

});

