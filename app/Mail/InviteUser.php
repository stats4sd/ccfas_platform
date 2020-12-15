<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InviteUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->invitation = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('lucia@stats4sd.org')
                ->view('emails.invite_user')
                ->with([
                    'name' => $this->invitation->name,
                    'password' =>  $this->password,
                    'email' => $this->invitation->email
                ]);
    }
}
