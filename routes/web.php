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
    return view('frontend.index');
});

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    /**
     * Dashboard
     */
    Route::get('/', 'AppController@index')->name('dashboard');
    Route::post('/ajax', 'AjaxController@index')->name('admin_ajax');

    Route::resource('categories', 'CategoryController');

    Route::resource('posts', 'PostController');

    Route::resource('pages', 'PageController');

    Route::resource('menus', 'MenuController');
    Route::get('/links', 'MenuController@links')->name('links');

    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('settings', 'SettingController');
});
