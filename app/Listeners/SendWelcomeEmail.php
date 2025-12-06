<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\WelcomeRegisterMail;
use Illuminate\Support\Facades\Mail;
class SendWelcomeEmail
{
    public function handle(UserRegistered $event): void
    {
        Mail::to($event->user->email)
            ->send(new WelcomeRegisterMail($event->user));
    }
}
