<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;

class FcmService
{
    protected string $projectId;
    protected string $credentialsPath;
    protected Client $http;

    public function __construct()
    {
        $this->projectId = env('FIREBASE_PROJECT_ID');
        $this->credentialsPath = env('FIREBASE_CREDENTIALS');
        $this->http = new Client([
            'timeout' => 15,
        ]);
    }

    protected function getAccessToken(): string
    {
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];

        $credentials = new ServiceAccountCredentials(
            $scopes,
            $this->credentialsPath
        );

        $token = $credentials->fetchAuthToken();

        if (empty($token['access_token'])) {
            throw new \Exception('Unable to fetch Firebase access token.');
        }

        return $token['access_token'];
    }

    public function sendToToken(string $fcmToken, array $data = [], ?array $notification = null): array
    {
        $accessToken = $this->getAccessToken();

        $payload = [
            'message' => [
                'token' => $fcmToken,
                'data' => $data,
            ],
        ];

        if ($notification) {
            $payload['message']['notification'] = $notification;
        }

        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        $response = $this->http->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type'  => 'application/json',
            ],
            'json' => $payload,
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}