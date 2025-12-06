<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ChangeRandomUserNameCommand extends Command
{
    protected $signature = 'app:change-random-user-name-command';

    protected $description = 'Command description';

    public function handle()
    {
        User::query()->get()->map(function (User $user) {
            $user->username = Str::random(10);
            $user->save();
        });
    }
}
