<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailBlade extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @return void
     */
    private $keywordData;
    private $mailTemplate;

    public function __construct($keywordData, $mailTemplate)
    {
        $this->keywordData = $keywordData;
        $this->mailTemplate = $mailTemplate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $inputs = $this->mailTemplate;
        $email = $this->view($inputs['blade_path'])->subject($inputs['title'])->with($this->keywordData);

        if ($inputs['attachment_path']) {
            return $email->attach($inputs['attachment_path']);
        }

        return $email;
    }
}
