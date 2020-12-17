<?php

namespace App\Services\Mail;

interface MailServiceInterface
{
    public function sendEmail($mailTo, $code, $keywordData = null);

    public function sendMultiMail($mailsTo, $code, $keywordData = null);
}
