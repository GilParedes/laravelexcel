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

Route::get('/export', 'ImportController@createExcel');
Route::get('/import', 'ImportController@importExcel');
Route::get('/iteraciones', 'ImportController@importInterators');
Route::get('/indexes', 'ImportController@importIndexes');
Route::get('/cordenadas', 'ImportController@importCordenadas');

