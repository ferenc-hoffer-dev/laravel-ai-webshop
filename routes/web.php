<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/nosleep', function () {
    return view('nosleep');
});

Route::get('/health', function () {
    return response('OK', 200);
});
