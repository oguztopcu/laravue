<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('app'));

Route::get('/{path?}', function ($path) {
    return view('app');
})->where('path', '.*');
