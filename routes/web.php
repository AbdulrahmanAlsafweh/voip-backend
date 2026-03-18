<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FcmDeviceController;
Route::get('/', function () {
    return view('welcome');
});

