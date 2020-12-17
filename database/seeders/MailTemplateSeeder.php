<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\Constant;

class MailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mail_templates')->truncate();
        $baseUrl = Constant::BASE_URL;

        DB::table('mail_templates')->insert([
            [
                "title" => "EXAMPLE BLADE",
                "content" => NULL,
                "code" => 'EXAMPLE_BLADE',
                "blade_path" => 'admin.mail-template',
                "attachment_path" => NULL,
            ],
            [
                "title" => "(ELF)Register account",
                "content" => "<h2>HỆ THỐNG QUẢN LÝ HỌC TRỰC TUYẾN</h2>
                <div>
                    <p>Dear Mr/ Ms [[userName]] </p>
                    <p> Bạn đã đăng ký tài khoản thành công. </p>
                </div>",
                "code" => 'REGISTER_ACCOUNT',
                "blade_path" => NULL,
                "attachment_path" => 'images/5.jpg',
            ],
            [
                "title" => "[ELF] Reset password",
                "content" => "<h2>HỆ THỐNG QUẢN LÝ HỌC TRỰC TUYẾN</h2>
                <div>
                    <p>Mật khẩu tài khoản của bạn đã được thay đổi, vui lòng sử dụng thông tin dưới đây để đăng nhập.</p>
                    <p>URL: <a href='$baseUrl'>$baseUrl</a></p>
                    <p>Username: [[userName]]</p>
                    <p>Password: <b>[[password]]</b></p>
                </div>",
                "code" => 'RESET_PASSWORD',
                "blade_path" => NULL,
                "attachment_path" => NULL,
            ]
        ]);
    }
}
