<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class VerifyEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $user;
    protected $expireInMinutes;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $expireInMinutes)
    {
        $this->user = $user;
        $this->expireInMinutes =$expireInMinutes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url('/email/verify/'.$this->user->email_token);

        return $this->subject('Verify Email')
            ->markdown('emails.verifyemail', 
            ['user' => $this->user, 'url' => $url, 'expireInMinutes' => $this->expireInMinutes]
        );
    }
}
