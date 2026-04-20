<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@techperpus.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Petugas Satu',
            'email' => 'staff@techperpus.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'staff',
        ]);

        \App\Models\User::create([
            'name' => 'Member Satu',
            'email' => 'member@techperpus.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'member',
        ]);
    }
}
