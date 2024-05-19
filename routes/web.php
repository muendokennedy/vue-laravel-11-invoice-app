<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{pathMatch}', fn() => view('welcome')
)->where('pathMatch', '.*');
