<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PanelEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $parameters;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->parameters['type'] == EMP_JOBSITE_APPR){
            return $this->subject('Jobsite Approved')->view('mails.emp_jobsite_approve');
        }
        if($this->parameters['type'] == USER_VERIFY){
            return $this->subject('Approve Email')->view('mails.verifyUser');
        }
       
    }
}
