<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'B2B Marketplace API']);
});

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});
