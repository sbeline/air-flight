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


Route::post('flight', 'FlightController@searchFlight')->name('flight.search');
Route::post('autocompletionflight', 'FlightController@autocompletion')->name('flight.autocompletion');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
