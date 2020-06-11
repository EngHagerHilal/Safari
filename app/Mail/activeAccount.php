<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class activeAccount extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;
    public function __construct( $user)
    {
        $this->user=$user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('safari@safari.com')->subject($this->user->email_title)
            ->view('mails.active_account')
            ->with(
                [
                    'username' => $this->user->name,
                    'url' => $this->user->url,
                    'email_title' => $this->user->email_title,
                    'email_message' => $this->user->email_message,
                ]);
    }
}
