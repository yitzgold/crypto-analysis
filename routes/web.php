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


Route::get('/', 'ChartsDisplayController@displayChart');

Route::get('/abc', function () {
    $avgScore = $users = DB::table('tweets')->get();
    var_dump($avgScore);

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
