<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@trucking.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@trucking.com',
                'password' => Hash::make('password'),
                'phone' => '+1234567890',
            ]
        );

        // Assign role if spatie permission is available
        if (class_exists(\Spatie\Permission\Models\Role::class)) {
            $admin->assignRole('Admin');
        }
    }
}
