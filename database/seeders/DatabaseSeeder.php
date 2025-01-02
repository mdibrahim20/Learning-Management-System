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
        // Seed in proper order to handle foreign key dependencies
        $this->call([
            RolePermissionSeeder::class,
            UserTableSeeder::class,
            SiteSettingSeeder::class,
            SmtpSettingSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            BlogCategorySeeder::class,
            BulkLmsSeeder::class,
        ]);
    }
}
