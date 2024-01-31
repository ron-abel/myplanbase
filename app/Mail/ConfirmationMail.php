<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user, $contractor;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $contractor)
    {
        $this->user = $user;
        $this->contractor = $contractor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link = "https://" . $this->contractor->sub_domain . "." . config("app.domain") . "/admin/login";

        return $this->view('contractor.confirmation_email', ["full_name" => $this->user['full_name'], "link" => $link]);
    }
}
