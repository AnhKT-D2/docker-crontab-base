<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GoogleGetToken extends Command
{
    protected $signature = 'google:get-token';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $client = $this->getClient();
        $credentialsPath = storage_path('google/token.json');
        if (file_exists($credentialsPath)
            && !$this->confirm('Token is ready to use! Do you want to retrieve the token?')
        ) {
            return $this->info('Old token still held!');
        }

        $this->runGetToken($client, $credentialsPath);
    }

    private function getClient()
    {
        $client = new \Google_Client(); // khởi tạo Google Client
        $client->setApplicationName('Demo Laravel'); // đặt tên cho ứng dụng (không quan trọng lắm)

        // cài đặt xin quyền truy cập của token, ở đây tôi đang xin truy cập đến dữ liệu Calendar và Drive
        $client->setScopes([
            \Google_Service_Calendar::CALENDAR,
            \Google_Service_Drive::DRIVE,
            \Google_Service_Drive::DRIVE_FILE,
            \Google_Service_Drive::DRIVE_METADATA,
        ]);
        $client->setAuthConfig(storage_path('google/credentials.json')); // đường dẫn đến file credentials.json
        $client->setAccessType('offline');

        return $client;
    }

    private function runGetToken(\Google_Client $client, $credentialsPath)
    {
        // Yêu cầu xác thực từ phía User
        $this->info("Open the following link in your browser:");
        $this->comment($client->createAuthUrl());
        $authCode = trim($this->ask('Enter verification code'));
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // Kiểm tra lỗi
        if (array_key_exists('error', $accessToken)) {
            throw new \Exception(join(', ', $accessToken));
        }

        // Lưu token vào file
        if (!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0777, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
        $this->info("Credentials saved to {$credentialsPath}!", $credentialsPath);
    }
}
