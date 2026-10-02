<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:make-staff {email : The email address of an existing user account}')]
#[Description('Promote an existing user account to staff access')]
class PromoteUserToStaff extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $user = User::query()->where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error('No user account exists with that email address.');

            return self::FAILURE;
        }

        $user->update(['role' => 'staff']);
        $this->info("{$user->email} now has staff access.");

        return self::SUCCESS;
    }
}
