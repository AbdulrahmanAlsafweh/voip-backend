<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FcmDeviceController;
Route::get('/', function () {
    return view('welcome');
});

Route::post('/fcm/register-token', [FcmDeviceController::class, 'registerToken']);
Route::post('/fcm/deactivate-token', [FcmDeviceController::class, 'deactivateToken']);