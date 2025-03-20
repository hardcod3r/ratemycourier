<?php

use Illuminate\Support\Facades\Route;
use Dedoc\Scramble\Scramble;
Route::get('/', function () {
    return view('welcome');
});
Route::redirect('/docs', '/docs/api');
