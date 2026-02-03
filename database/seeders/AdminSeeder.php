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
        // Create default admin using the stored procedure
        $fullName = "Gian Glen Vincent Garcia";
        $address = "Tagum City";
        $sampleEmail = "admin@usep.edu.ph";
        $samplePassword = "admin123";
        $hashedPassword = Hash::make($samplePassword);
        $status = "alumni";

        // Insert admin directly (since stored procedure might not be available during seeding)
        DB::table('admins')->insert([
            'full_name' => $fullName,
            'address' => $address,
            'email' => $sampleEmail,
            'password' => $hashedPassword,
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Default admin account created successfully.');
        $this->command->info('Email: admin@usep.edu.ph');
        $this->command->info('Password: admin123');
    }
}
