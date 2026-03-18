<?php
use App\Http\Controllers\Api\FcmTestController;

Route::post('/fcm/test-send', [FcmTestController::class, 'send']);
Route::get('/ping', function () {
    return response()->json([
        'ok' => true,
        'message' => 'Laravel reached',
    ]);
});