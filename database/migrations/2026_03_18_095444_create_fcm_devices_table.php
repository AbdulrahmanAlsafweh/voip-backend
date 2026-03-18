<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fcm_devices', function (Blueprint $table) {
            $table->id();

            // Your SIP extension, example: 1001 or 09400400
            $table->string('extension', 50)->index();

            // Optional if you have a users table and login system
            $table->unsignedBigInteger('user_id')->nullable()->index();

            // Unique device identifier from the mobile app
            $table->string('device_id', 191);

            // Android / ios / web
            $table->string('platform', 20)->default('android');

            // Firebase token
            $table->text('fcm_token');

            // Optional helpful fields
            $table->string('app_version', 50)->nullable();
            $table->string('device_name', 191)->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamp('last_seen_at')->nullable();

            $table->timestamps();

            // one row per extension+device
            $table->unique(['extension', 'device_id'], 'fcm_devices_extension_device_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fcm_devices');
    }
};
