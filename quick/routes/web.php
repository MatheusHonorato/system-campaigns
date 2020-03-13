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


Route::get('teste', function () {
    echo "teste";
})->name('teste');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::resource('campanhas', 'CampaignController')->names('campaigns')->parameters(['campanhas'=>'campaigns']);

    Route::resource('categorias', 'CategoryController')->names('categories')->parameters(['categorias'=>'categories']);

    Route::get('listar/categorias/{type}', 'CategoryController@index')->name('categories.list');

    Route::resource('tipos', 'TypeController')->names('types')->parameters(['tipos'=>'types']);

    Route::resource('clinicas', 'ClinicController')->names('clinics')->parameters(['clinicas'=>'clinics']);

    Route::resource('posts', 'PostController')->names('posts')->parameters(['posts'=>'posts']);

    Route::get('posts_filter/{id}', 'PostController@list_filter')->name('posts.filter');

    Route::get('categories_filter/{type}', 'CategoryController@list_filter')->name('category.filter');

    Route::resource('figures', 'FigureController')->names('figures')->parameters(['figures'=>'figures']);

    Route::resource('logos', 'LogoController')->names('logos')->parameters(['logos'=>'logos']);

    Route::get('download', 'DownloadController@index')->name('download');

    Route::get('alert', 'AlertCampaignController@index')->name('alert.campaign.list');

    Route::post('alert', 'AlertCampaignController@store')->name('alert.campaign.register');

    Route::get('register', 'Auth\RegisterController@register');
});

