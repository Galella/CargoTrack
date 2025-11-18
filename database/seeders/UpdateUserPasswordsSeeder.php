<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserPasswordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            'admin@trucking.com',
            'manager@trucking.com',
            'operator@trucking.com',
            'driver@trucking.com'
        ];

        foreach($users as $email) {
            $user = User::where('email', $email)->first();
            if($user) {
                $user->password = Hash::make('password');
                $user->save();
            }
        }
    }
}
