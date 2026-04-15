<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = ['admin', 'rolf', 'gian', 'member3'];

        foreach ($users as $name) {
            User::firstOrCreate(
                ['name' => $name],
                ['password' => Hash::make('password123')]
            );
        }
    }
}