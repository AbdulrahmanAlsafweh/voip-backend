<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FcmDevice;
use Illuminate\Http\Request;

class FcmDeviceController extends Controller
{
    public function registerToken(Request $request)
    {
        $validated = $request->validate([
            'extension'   => ['required', 'string', 'max:50'],
            'device_id'   => ['required', 'string', 'max:191'],
            'platform'    => ['required', 'in:android,ios,web'],
            'fcm_token'   => ['required', 'string'],
            'app_version' => ['nullable', 'string', 'max:50'],
            'device_name' => ['nullable', 'string', 'max:191'],
            'user_id'     => ['nullable', 'integer'],
        ]);

        $device = FcmDevice::updateOrCreate(
            [
                'extension' => $validated['extension'],
                'device_id' => $validated['device_id'],
            ],
            [
                'user_id'      => $validated['user_id'] ?? null,
                'platform'     => $validated['platform'],
                'fcm_token'    => $validated['fcm_token'],
                'app_version'  => $validated['app_version'] ?? null,
                'device_name'  => $validated['device_name'] ?? null,
                'is_active'    => true,
                'last_seen_at' => now(),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'FCM token saved successfully',
            'data' => $device,
        ]);
    }

    public function deactivateToken(Request $request)
    {
        $validated = $request->validate([
            'extension' => ['required', 'string', 'max:50'],
            'device_id' => ['required', 'string', 'max:191'],
        ]);

        $device = FcmDevice::where('extension', $validated['extension'])
            ->where('device_id', $validated['device_id'])
            ->first();

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found',
            ], 404);
        }

        $device->update([
            'is_active' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'FCM token deactivated successfully',
        ]);
    }
}