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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

//car list
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/car', 'admin\car\CarController@car')->name('car');
//car save
Route::post('/car-save', 'admin\car\CarController@carSave')->name('car_save');
//car update
Route::post('/car-update', 'admin\car\CarController@carUpdate')->name('car_update');
//car delete
Route::post('/car-delete', 'admin\car\CarController@carDelete')->name('car_delete');


// Search car
Route::get('/search-car', 'admin\search\SearchController@carSearch')->name('search_car');
// Search car result
Route::post('/search-result', 'admin\search\SearchController@resultSearch')->name('result_Search');

 
Route::post('/allposts', 'admin\car\CarController@allPosts' )->name('allposts');

Route::get('/mobile', 'admin\mobile\MobileController@mobile')->name('mobile');

//car save
Route::post('/mobile-save', 'admin\mobile\MobileController@mobileSave')->name('mobile_save');
//mobile update
Route::post('/mobile-update', 'admin\mobile\MobileController@mobileUpdate')->name('mobile_update');
//mobile delete
Route::post('/mobile-delete', 'admin\mobile\MobileController@mobileDelete')->name('mobile_delete');

Route::post('/allmobile', 'admin\mobile\MobileController@allmobile' )->name('allmobile');
// Admin Url

Route::get('/admin', function () {
    return view('admin.login');
});

Route::post('/admin/login','Admin\AuthController@checklogin')->name('check.login');
 