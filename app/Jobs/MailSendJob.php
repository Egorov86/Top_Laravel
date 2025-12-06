<?php

namespace App\Jobs;

use App\Mail\WelcomeRegisterMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class MailSendJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly User $user,
    )
    {
    }

    public function handle(): void
    {
        Mail::to($this->user->email)
            ->send(new WelcomeRegisterMail($this->user));
    }
}
