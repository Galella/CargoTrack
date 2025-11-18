<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@trucking.com',
        ], [
            'name' => 'Admin User',
            'email' => 'admin@trucking.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
        ]);
        $admin->assignRole('Admin');

        // Create manager user
        $manager = User::firstOrCreate([
            'email' => 'manager@trucking.com',
        ], [
            'name' => 'Manager User',
            'email' => 'manager@trucking.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567891',
        ]);
        $manager->assignRole('Manager');

        // Create operator user
        $operator = User::firstOrCreate([
            'email' => 'operator@trucking.com',
        ], [
            'name' => 'Operator User',
            'email' => 'operator@trucking.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567892',
        ]);
        $operator->assignRole('Operator');

        // Create driver user
        $driver = User::firstOrCreate([
            'email' => 'driver@trucking.com',
        ], [
            'name' => 'Driver User',
            'email' => 'driver@trucking.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567893',
        ]);
        $driver->assignRole('Driver');
    }
}
