<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

use function Symfony\Component\Clock\now;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole   = Role::where('name', 'admin')->firstOrFail();
        $managerRole = Role::where('name', 'manager')->firstOrFail();

        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'      => 'System Admin',
                'password'  => Hash::make('Admin@123'),
                'email_verified_at' => now(),
                'role_id'   => $adminRole->id,
                'is_active' => true,
            ]
        );

        // Manager User
        User::updateOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name'      => 'System Manager',
                'password'  => Hash::make('Manager@123'),
                'email_verified_at' => now(),
                'role_id'   => $managerRole->id,
                'is_active' => true,
            ]
        );
    }
}
