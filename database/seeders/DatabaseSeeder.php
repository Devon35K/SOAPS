<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Super Admin
        User::create([
            'student_id' => 'SUPER001',
            'full_name' => 'Super Administrator',
            'address' => 'USeP Tagum-Mabini Campus',
            'email' => 'superadmin@usep.edu.ph',
            'password' => Hash::make('superadmin123'),
            'status' => 'undergraduate',
            'approved' => true,
            'role' => 'super_admin',
        ]);

        // Create Admin
        User::create([
            'student_id' => 'ADMIN001',
            'full_name' => 'System Administrator',
            'address' => 'USeP Tagum-Mabini Campus',
            'email' => 'admin@usep.edu.ph',
            'password' => Hash::make('admin123'),
            'status' => 'undergraduate',
            'approved' => true,
            'role' => 'admin',
        ]);

        // Create regular student user
        User::create([
            'student_id' => 'STUDENT001',
            'full_name' => 'John Student',
            'address' => 'Sample Address, Tagum City',
            'email' => 'student@usep.edu.ph',
            'password' => Hash::make('student123'),
            'status' => 'undergraduate',
            'approved' => true,
            'role' => 'user',
        ]);
    }
}
