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

Route::get('/admin', function()
{
    $tweets = DB::table('tweets')
        ->wheredate('created_at', today())
        ->get();

    foreach($tweets as $tweet){
        echo 'created at  ' . $tweet['created_at'] . '  score:  ' . $tweet['score'];
    }
}); 

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
