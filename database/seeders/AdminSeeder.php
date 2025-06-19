<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@pantry.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@pantry.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+1234567890',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create staff user
        User::updateOrCreate(
            ['email' => 'staff@pantry.com'],
            [
                'name' => 'Staff Member',
                'email' => 'staff@pantry.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '+1234567891',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create volunteer user
        User::updateOrCreate(
            ['email' => 'volunteer@pantry.com'],
            [
                'name' => 'Volunteer User',
                'email' => 'volunteer@pantry.com',
                'password' => Hash::make('password'),
                'role' => 'volunteer',
                'phone' => '+1234567892',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create additional test users
        User::updateOrCreate(
            ['email' => 'john.doe@pantry.com'],
            [
                'name' => 'John Doe',
                'email' => 'john.doe@pantry.com',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '+1555123456',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'jane.smith@pantry.com'],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@pantry.com',
                'password' => Hash::make('password'),
                'role' => 'volunteer',
                'phone' => '+1555654321',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create an inactive user for testing
        User::updateOrCreate(
            ['email' => 'inactive@pantry.com'],
            [
                'name' => 'Inactive User',
                'email' => 'inactive@pantry.com',
                'password' => Hash::make('password'),
                'role' => 'volunteer',
                'phone' => '+1555999999',
                'is_active' => false,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Admin and test users created successfully!');
        $this->command->info('');
        $this->command->info('🔐 Login Credentials:');
        $this->command->info('👑 Admin: admin@pantry.com / password');
        $this->command->info('👨‍💼 Staff: staff@pantry.com / password');
        $this->command->info('🙋‍♂️ Volunteer: volunteer@pantry.com / password');
        $this->command->info('');
    }
}