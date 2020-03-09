<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/image/store', 'ImageController@store');
Route::post('/image/check', 'ImageController@check');
