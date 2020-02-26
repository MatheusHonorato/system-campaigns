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
})->name('welcome');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::resource('campanhas', 'CampaignController')->names('campaigns')->parameters(['campanhas'=>'campaigns']);

    Route::resource('clinicas', 'ClinicController')->names('clinics')->parameters(['clinicas'=>'clinics']);

    Route::resource('posts', 'PostController')->names('posts')->parameters(['posts'=>'posts']);

    Route::resource('figures', 'FigureController')->names('figures')->parameters(['figures'=>'figures']);

    Route::resource('logos', 'LogoController')->names('logos')->parameters(['logos'=>'logos']);

    Route::get('download', 'DownloadController@index')->name('download');

});


