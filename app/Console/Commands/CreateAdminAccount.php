<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

#[Signature('app:create-admin')]
#[Description('Create the initial administrator account for order management')]
class CreateAdminAccount extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (! $this->input->isInteractive()) {
            $this->error('Run this command in an interactive terminal so the password can be entered securely.');

            return self::FAILURE;
        }

        if (User::query()->where('role', 'staff')->exists()) {
            $this->error('An administrator account already exists. Use app:make-staff to grant admin access to another existing account.');

            return self::FAILURE;
        }

        $name = trim((string) $this->ask('Administrator name'));
        $email = Str::lower(trim((string) $this->ask('Administrator email')));
        $password = (string) $this->secret('Administrator password (minimum 12 characters)');
        $passwordConfirmation = (string) $this->secret('Confirm administrator password');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(12)->letters()->mixedCase()->numbers()->symbols(),
            ],
            'password_confirmation' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        if (User::query()->where('role', 'staff')->exists()) {
            $this->error('An administrator account was created while this command was running. No account was added.');

            return self::FAILURE;
        }

        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => 'staff',
        ]);

        $this->info("Initial administrator account created for {$user->email}.");

        return self::SUCCESS;
    }
}
