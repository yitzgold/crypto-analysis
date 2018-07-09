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
    DB::table('daily_scores')->insert(
        [
            [
                'coin' => 'BTC',
                'score' => 0.20, 
                'created_at' => '2018-07-06 23:45:01'
            ],
            [
                'coin' => 'LTC',
                'score' => 0.15, 
                'created_at' => '2018-07-06 23:45:01'
            ], 
            [
                'coin' => 'ETH',
                'score' => 0.22, 
                'created_at' => '2018-07-06 23:45:01'
            ]  
        ]
    );
}); 

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
