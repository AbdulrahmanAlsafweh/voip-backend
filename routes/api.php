<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FcmTestController;
use App\Http\Controllers\Api\FcmDeviceController;

Route::get('/ping', function () {
    return response()->json([
        'ok' => true,
        'message' => 'Laravel reached',
    ]);
});

Route::post('/fcm/test-send', [FcmTestController::class, 'send']);
Route::post('/fcm/register-token', [FcmDeviceController::class, 'registerToken']);
Route::post('/fcm/deactivate-token', [FcmDeviceController::class, 'deactivateToken']);