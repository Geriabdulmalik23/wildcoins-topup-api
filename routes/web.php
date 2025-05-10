<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json('Welcome ');
});
Route::get('/test-jwt-secret', function () {
    return env('JWT_SECRET', 'JWT_SECRET NOT FOUND');
});