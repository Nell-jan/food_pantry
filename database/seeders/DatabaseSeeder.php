<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CategorySeeder::class,
            FoodItemSeeder::class,
        ]);

        $this->command->info('🎉 All seeders completed successfully!');
        $this->command->info('');
        $this->command->info('🚀 You can now:');
        $this->command->info('1. Start the server: php artisan serve');
        $this->command->info('2. Visit: http://localhost:8000');
        $this->command->info('3. Login with admin@pantry.com / password');
        $this->command->info('');
    }
}