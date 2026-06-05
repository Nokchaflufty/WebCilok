<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Admin',
            'username' => 'admin',
            'email'    => 'admin@webcilok.com',
            'password' => Hash::make('admin123'),
        ]);
    }
}