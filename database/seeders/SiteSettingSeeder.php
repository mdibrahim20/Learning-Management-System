<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::create([
            'logo' => 'upload/logo/1778954829126984.png',
            'phone' => '+1 234 567 8900',
            'email' => 'support@lms.com',
            'address' => '123 Learning Street, Education City, EC 12345',
            'facebook' => 'https://facebook.com',
            'twitter' => 'https://twitter.com',
            'copyright' => 'Copyright (c) 2026 LMS Project. All Rights Reserved.',
        ]);
    }
}
