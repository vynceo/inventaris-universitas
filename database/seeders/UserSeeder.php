<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin Inventaris',
            'email'    => 'admin@inventaris.test',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Staff Inventaris',
            'email'    => 'staff@inventaris.test',
            'password' => Hash::make('password'),
            'role'     => 'staff',
        ]);
    }
}
