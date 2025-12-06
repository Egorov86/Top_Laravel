<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class VerifyMailSendJob implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly User $user)
    {
    }

    public function handle(): void
    {
        $user = $this->user;

        $signedUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $url = '<a href="' . $signedUrl . '">' . $signedUrl . '</a>';
        Mail::raw("Verify your email: $url", function ($message) use ($user) {
            $message->to($user->email)->subject('Email Verification');
        });
    }
}
