<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FcmDevice;
use App\Services\FcmService;
use Illuminate\Http\Request;

class FcmTestController extends Controller
{
    public function send(Request $request, FcmService $fcmService)
    {
        $validated = $request->validate([
            'extension' => ['required', 'string'],
        ]);

        $device = FcmDevice::where('extension', $validated['extension'])
            ->where('is_active', true)
            ->latest()
            ->first();

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'No active FCM device found for this extension.',
            ], 404);
        }

        $result = $fcmService->sendToToken(
            $device->fcm_token,
            [
                'type' => 'incoming_call',
                'extension' => $device->extension,
                'caller_id' => '70167093',
            ],
            [
                'title' => 'Test Push',
                'body' => 'FCM is working from Laravel',
            ]
        );

        return response()->json([
            'success' => true,
            'result' => $result,
        ]);
    }
}