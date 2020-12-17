<?php

namespace App\Services\Mail;

use App\Enums\ErrorType;
use App\Jobs\SendEmail;
use App\Jobs\SendEmailBlade;
use App\Jobs\SendEmailContent;
use App\Mail\MailBlade;
use App\Mail\MailContent;
use App\Models\MailTemplate;
use Illuminate\Support\Facades\Mail;

class MailService implements MailServiceInterface
{
    public function sendEmail($mailTo, $code, $keywordData = null)
    {
        $mailTemplate = MailTemplate::where('code', $code)->first();

        if (is_null($mailTemplate)) {
            return [
                'success' => false,
                'code' => ErrorType::CODE_4041,
                'message' => "Data not found"
            ];
        }
        $bladePath = $mailTemplate['blade_path'];

        if ($mailTo) {
            if ($bladePath) {
                try {
                    Mail::to($mailTo)->send(new MailBlade($keywordData, $mailTemplate));

                    return ["success" => true];
                } catch (\Exception $e) {
                    return ['success' => false, 'message' => $e->getMessage()];
                }
            } else {
                try {
                    Mail::to($mailTo)->send(new MailContent($keywordData, $mailTemplate));

                    return ["success" => true];
                } catch (\Exception $e) {
                    return ['success' => false, 'message' => $e->getMessage()];
                }
            }
        }
    }

    public function sendMultiMail($mailsTo, $code, $keywordData = null)
    {
        $mailTemplate = MailTemplate::where('code', $code)->first();

        if (is_null($mailTemplate)) {
            return [
                'success' => false,
                'code' => ErrorType::CODE_4041,
                'message' => "Data not found"
            ];
        }
        $bladePath = $mailTemplate['blade_path'];

        if ($mailsTo) {
            if ($bladePath) {
                try {
                    dispatch(new SendEmailBlade($mailsTo, $keywordData, $mailTemplate));

                    return ["success" => true];
                } catch (\Exception $e) {
                    return ['success' => false, 'message' => $e->getMessage()];
                }
            } else {
                try {
                    dispatch(new SendEmailContent($mailsTo, $keywordData, $mailTemplate));

                    return ["success" => true];
                } catch (\Exception $e) {
                    return ['success' => false, 'message' => $e->getMessage()];
                }
            }
        }
    }
}
