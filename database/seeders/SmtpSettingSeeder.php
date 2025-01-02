<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SmtpSetting;

class SmtpSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SmtpSetting::create([
            'mailer' => 'smtp',
            'host' => 'smtp.mailtrap.io',
            'port' => '2525',
            'username' => null,
            'password' => null,
            'encryption' => 'tls',
            'from_address' => 'noreply@lms.com',
        ]);
    }
}
