<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/image/store', 'ImageController@store');
Route::post('/image/check', 'ImageController@check');
Route::get('/image/read', 'ImageController@read')->name('imagesList');
