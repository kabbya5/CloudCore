<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/csrf-token', function () {
    return response()->json(['csrf' => csrf_token()]);
});
