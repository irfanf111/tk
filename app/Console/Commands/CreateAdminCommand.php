<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin 
                            {email? : Email address of the admin} 
                            {--name= : Name of the admin} 
                            {--password= : Password for the admin account}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user or upgrade an existing user to admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        if (!$email) {
            $email = $this->ask('Enter admin email address');
        }

        // Validate email
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            $this->error('Invalid email address.');
            return 1;
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            $this->info("User with email {$email} already exists.");
            if ($user->role === 'admin' || $user->role === 'superadmin') {
                $this->info("This user is already an admin (Role: {$user->role}).");
            } else {
                if ($this->confirm('Do you want to upgrade this user to admin?')) {
                    $user->role = 'admin';
                    $user->save();
                    $this->info('User role upgraded to admin successfully.');
                }
            }

            if ($this->confirm('Do you want to change the password for this user?')) {
                $password = $this->secretPasswordPrompt();
                if ($password) {
                    $user->password = Hash::make($password);
                    $user->save();
                    $this->info('Password updated successfully.');
                }
            }

            return 0;
        }

        // Create new user
        $name = $this->option('name');
        if (!$name) {
            $name = $this->ask('Enter admin name', 'Admin');
        }

        $password = $this->option('password');
        if (!$password) {
            $password = $this->secretPasswordPrompt();
        }

        if (!$password) {
            $this->error('Password is required to create a new user.');
            return 1;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->info("Admin user '{$name}' <{$email}> created successfully.");
        return 0;
    }

    /**
     * Prompt for password securely.
     */
    private function secretPasswordPrompt(): ?string
    {
        $password = $this->secret('Enter password (min 8 characters)');
        $confirm = $this->secret('Confirm password');

        if ($password !== $confirm) {
            $this->error('Passwords do not match.');
            return null;
        }

        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters long.');
            return null;
        }

        return $password;
    }
}
