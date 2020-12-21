<?php

namespace App\Http\Controllers\Api;

use App\Enums\ErrorType;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Mail\MailServiceInterface;
use Illuminate\Http\Request;

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
}
