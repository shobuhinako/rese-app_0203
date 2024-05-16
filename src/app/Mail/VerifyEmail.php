<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $userId = $this->user->id;
        $hash = sha1($this->user->email);

        return $this->view('emails.verify-email')
                    ->subject('本人確認メール')
                    ->with([
                        'userName' => $this->user->name,
                        'userId' => $userId,
                        'hash' => $hash,
                        'verificationLink' => $this->verificationLink($userId, $hash),
                        'loginUrl' => url('/login'),
                    ]);
    }

    protected function verificationLink($userId, $hash)
    {
        return route('verification.verify', [
            'id' => $userId,
            'hash' => $hash,
        ]);
    }
}
