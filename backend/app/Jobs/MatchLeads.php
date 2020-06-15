<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Mail;

class MatchLeads extends Job
{
    protected $portfolio;

    public function __construct($portfolio)
    {
        $this->portfolio = $portfolio;
    }

    public function handle()
    {
        $this->portfolio->calcMean();
        $this->portfolio->calcStandardDeviation();
        $this->portfolio->calcLeadsMatch();
        Mail::send('emails.matches_complete', ['portfolio' => $this->portfolio], function ($message) {
            $message->from('leopso1990@gmail.com', 'LeoPersan');
            $message->sender('leopso1990@gmail.com', 'LeoPersan');
            $message->to('leopso1990@gmail.com', 'LeoPersan');
            $message->cc('leopso1990@gmail.com', 'LeoPersan');
            $message->bcc('leopso1990@gmail.com', 'LeoPersan');
            $message->replyTo('leopso1990@gmail.com', 'LeoPersan');
            $message->subject($this->portfolio->name . ' Completou');
            $message->priority(3);
        });
    }
}
