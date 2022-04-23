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
    return redirect('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect('home');
    });
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/threads', 'ThreadController')->except(['create', 'update']);
Route::resource('/threads/{thread}/messages', 'MessageController')->except(['create', 'update']);

Route::prefix('admin')->group(function () {
    Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'Admin\LoginController@login');
});

Route::prefix('admin')->middleware(['auth:admin'])->as('admin.')->group(function () {
    Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');
    Route::get('home', 'Admin\HomeController@index')->name('admin.home');
    Route::resource('threads', 'Admin\ThreadController')->except(['create', 'store', 'update']);
    Route::resource('threads/{thread}/messages', 'Admin\MessageController')->only(['destroy']);
});
