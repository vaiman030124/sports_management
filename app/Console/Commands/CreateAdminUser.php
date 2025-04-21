<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create-user';
    protected $description = 'Create a new admin user';

    public function handle()
    {
        $name = $this->ask('Enter admin name');
        $email = $this->ask('Enter admin email');
        $password = $this->secret('Enter admin password');
        $confirmPassword = $this->secret('Confirm admin password');
        $role = $this->choice('Select admin role', ['admin', 'super_admin'], 0);

        if ($password !== $confirmPassword) {
            $this->error('Passwords do not match!');
            return;
        }

        AdminUser::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
            'permissions' => null,
            'status' => true
        ]);

        $this->info('Admin user created successfully!');
    }
}
