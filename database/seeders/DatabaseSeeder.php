<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Clear cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Run the admin user seeder
        $this->call([
            AdminUserSeeder::class,
        ]);
    }
}
