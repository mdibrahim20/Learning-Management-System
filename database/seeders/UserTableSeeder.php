<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('111'),
            'role' => 'admin',
            'status' => '1',
            'phone' => '+1 234 567 8901',
            'address' => '123 Admin Street',
        ]);
        $admin->assignRole('Admin');

        // Create Instructor
        $instructor = User::create([
            'name' => 'Instructor',
            'username' => 'instructor',
            'email' => 'instructor@gmail.com',
            'password' => Hash::make('111'),
            'role' => 'instructor',
            'status' => '1',
            'phone' => '+1 234 567 8902',
            'address' => '456 Instructor Avenue',
        ]);
        $instructor->assignRole('Instructor');

        // Create User
        $user = User::create([
            'name' => 'User',
            'username' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('111'),
            'role' => 'user',
            'status' => '1',
            'phone' => '+1 234 567 8903',
            'address' => '789 User Lane',
        ]);
        $user->assignRole('User');
    }
}
