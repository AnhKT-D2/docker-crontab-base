<?php

namespace App\Jobs;

use App\Mail\MailBlade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailBlade implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $mailsTo;
    private $keywordData;
    private $mailTemplate;
    public function __construct($mailsTo, $keywordData, $mailTemplate)
    {
        $this->mailsTo = $mailsTo;
        $this->keywordData = $keywordData;
        $this->mailTemplate = $mailTemplate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emails = [];
        foreach ($this->mailsTo as $key => $value) {
            $data = [];
            $data['email'] = $value;
            $emails[$key] = (object)$data;
        }

        Mail::to($emails)->send(new MailBlade($this->keywordData, $this->mailTemplate));
    }
}
