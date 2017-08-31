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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'DataController@Handle')->name('home');
Route::get('/userviews/handle', 'DataController@Handle')->name('handle');
Route::get('/userviews/user', 'DataController@User')->name('user');
Route::get('/userviews/stat', 'DataController@Stat')->name('stat');
Route::get('/userviews/handle', 'DataController@AutHandle')->name('authandle');