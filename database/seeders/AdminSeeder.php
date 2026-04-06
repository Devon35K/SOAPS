<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        $fullName = "System Administrator";
        $address = "USeP Tagum-Mabini Campus";
        $email = "admin@usep.edu.ph";
        $password = "admin123";
        $status = "undergraduate";

        // Check if admin already exists
        $exists = DB::table('users')->where('email', $email)->first();

        if (!$exists) {
            DB::table('users')->insert([
                'student_id' => 'ADMIN001',
                'full_name' => $fullName,
                'address' => $address,
                'email' => $email,
                'password' => Hash::make($password),
                'status' => $status,
                'role' => 'admin',
                'approved' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info('Default admin account created successfully.');
            $this->command->info('Email: admin@usep.edu.ph');
            $this->command->info('Password: admin123');
        } else {
            $this->command->info('Admin account already exists.');
        }
    }
}
