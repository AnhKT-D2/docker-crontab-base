<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailContent extends Mailable
{
    use Queueable, SerializesModels;

    private $keywordData;
    private $mailTemplate;

    public function __construct($keywordData, $mailTemplate)
    {
        $this->keywordData = $keywordData;
        $this->mailTemplate = $mailTemplate;
    }

    /**
     * Build the mail.
     *
     * @return $this
     */
    public function build()
    {
        $inputs = $this->mailTemplate;
        $mailBody = $inputs['content'];

        foreach ($this->keywordData as $key => $value) {
            $mailBody = str_replace('[[' . $key . ']]', $value, $mailBody);
        }
        $email = $this->subject($inputs['title'])->html($mailBody);
        if ($inputs['attachment_path']) {
            return $email->attach($inputs['attachment_path']);
        }

        return $email;
    }
}
