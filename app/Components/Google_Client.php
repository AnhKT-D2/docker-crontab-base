<?php

namespace App\Components;

use Google_Client as BaseGoogleClient;

class Google_Client
{
    protected $client;

    public function __construct(BaseGoogleClient $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        //kiểm tra credentials và token có tồn tại hay không
        if (!file_exists(storage_path('google/credentials.json'))) {
            throw new \Exception(
                'You have not create client for application.'
                . ' Please create on "console.google.com" and save to your storage "storage/google/credentials.json"!'
            );
        }

        $this->client->setAuthConfig(storage_path('google/credentials.json'));
        $this->client->setAccessType('offline');

        $credentialsPath = storage_path('google/token.json');
        if (!file_exists($credentialsPath)) {
            throw new \Exception('Do not receive access token. Please run command "php artisan google:get-token" to get token!');
        }

        $accessToken = json_decode(file_get_contents($credentialsPath), true);
        $this->client->setAccessToken($accessToken);

        if ($this->client->isAccessTokenExpired()) {
            $this->client->refreshToken($credentialsPath);
            file_put_contents($credentialsPath, json_encode($this->client->getAccessToken()));
        }

        return $this->client;
    }
}
