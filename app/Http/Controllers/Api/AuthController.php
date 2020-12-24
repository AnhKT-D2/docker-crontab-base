<?php

namespace App\Http\Controllers\Api;

use App\Enums\Constant;
use App\Enums\ErrorType;
use App\Mail\MailResetPassword;
use App\Models\ResetPassword;
use App\Models\User;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Mail\MailServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class AuthController extends ApiController
{
    private $authService;
    private $mailService;

    public function __construct(AuthServiceInterface $authService, MailServiceInterface $mailService)
    {
        $this->authService = $authService;
        $this->mailService = $mailService;
    }

    public function signIn(Request $request)
    {
        $result = $this->authService->signIn($request->all());
        if (!$result['success']) {
            return $this->sendError(ErrorType::CODE_4010, ErrorType::STATUS_4010);
        }

        return $this->sendSuccess($result['data']);
    }

    public function account()
    {
        $account = $this->authService->account();

        return $this->sendSuccess($account);
    }

    public function sendMail(Request $request)
    {
        $result = $this->mailService->sendEmail("nguyentranhiep96@gmail.com", "RESET_PASSWORD", ["user" => "aaa"]);

        if (!$result["success"]) {
            return $this->sendError(ErrorType::CODE_5000, ErrorType::STATUS_5000, $result["message"]);
        }

        return $this->sendSuccess();
    }

    public function sendMultiMail(Request $request)
    {
        $result = $this->mailService->sendMultiMail(["nguyentranhiep96@gmail.com", "vanhiepbk97@gmail.com", "kieutuananh2121999@gmail.com", "mikyway212@gmail.com", "hiepnv@fabbi.io", "anhkt@fabbi.io", "longdv@fabbi.io"], "RESET_PASSWORD", ["user" => "aaa"]);

        if (!$result["success"]) {
            return $this->sendError(ErrorType::CODE_5000, ErrorType::STATUS_5000, $result["message"]);
        }

        return $this->sendSuccess();
    }

    public function sendPasswordResetLink(Request $request)
    {
        $mail = $request->email;
        //check mail exists
        $response = Http::post('https://accounts.google.com/InputValidator?resource=signup&service=mail', [
            [
                'Input' => 'GmailAddress',
                'GmailAddress' => Str::before($mail, '@gmail.com'),
                'FirstName' => '',
                'LastName' => ''
            ],
            'Locale' => 'en'])->json();
        if ($response[0]['Valid'] == 'true') {
            return $this->sendError(
                ErrorType::CODE_4014,
                ErrorType::STATUS_4014
            );
        }

        $token = Str::random(60);
        $url = url('/reset-password/' . $token);
        try {
            Mail::to($mail)->send(new MailResetPassword($url));
            ResetPassword::updateOrCreate(['email' => $mail], ['token' => $token]);

            return $this->sendSuccess($token);
        } catch (\Exception $exception) {

            return $this->sendError(
                ErrorType::CODE_5000,
                ErrorType::STATUS_5000,
                $exception->getMessage()
            );
        }
    }

    public function resetPassword(Request $request, $token)
    {
        $password = bcrypt($request->password);

        DB::beginTransaction();
        try {
            $passwordReset = ResetPassword::where('token', $token)->firstOrFail();
            $checkLifeToken = strtotime(Carbon::now()) - strtotime($passwordReset->updated_at);
            if ($checkLifeToken > Constant::LIFE_TOKEN_RESET) {
                return $this->sendError(
                    ErrorType::CODE_4015,
                    ErrorType::STATUS_4015
                );
            }

            $user = User::where("email", $passwordReset->email)->firstOrFail();
            $user->update(['password' => $password]);
            $passwordReset->delete();

            DB::commit();

            return $this->sendSuccess();
        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->sendError(
                ErrorType::CODE_5000,
                ErrorType::STATUS_5000,
                $exception->getMessage()
            );
        }
    }
}
