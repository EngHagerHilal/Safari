<?php

Route::get('/', function () {
    return view('company.home');
});

//Route::get('/home', 'company\companyController@home')->name('home')->middleware('company');

//profile
Route::get('/profile/edit/', function () {
    return view('company.edit_profile');
});
Route::post('/profile/update', 'company\profileController@updateCurrentPassword');
