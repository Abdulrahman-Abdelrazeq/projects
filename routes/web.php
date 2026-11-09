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
    return view('auth.login');
});

Auth::routes();

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('optimize:clear');
    return Artisan::output();
});

Route::group(['middleware' => ['auth:web'], 'namespace' => 'Admin'], function () {
    Route::resource('users', 'UserController');
    Route::resource('shops', 'ShopController');
    Route::resource('subscriptions', 'SubscriptionController');
    Route::post('subscriptions/{id}/sync', 'SubscriptionController@syncNow')->name('subscriptions.sync');
    Route::resource('instructions', 'InstructionController');
    Route::get('/user/change-status/{id}', 'UserController@changeStatus')->name('user.changeStatus');
});

Route::get('/home', 'HomeController@index')->name('home');



//Route::get('login', 'AuthController@login');
Route::get('register', 'AuthController@register');
Route::get('forget-password', 'AuthController@forgetPassword');


