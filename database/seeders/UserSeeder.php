<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Elwin',
                'email' => 'elwin@gmail.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Budi',
                'email' => 'budi@gmail.com',
                'role' => 'staff',
            ],
            [
                'name' => 'Siti',
                'email' => 'siti@gmail.com',
                'role' => 'staff',
            ],
            [
                'name' => 'Andi',
                'email' => 'andi@gmail.com',
                'role' => 'manager',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'id' => Str::uuid(),
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'password' => bcrypt('123456'),
            ]);
        }
    }
}