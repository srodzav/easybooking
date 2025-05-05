<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'sebastian@sebastianrdz.com',
                'password' => bcrypt('password'),
                'phone' => '1234567890',
                'role' => 1
            ],
            [
                'name' => 'User',
                'email' => 'jocelyn@sebastianrdz.com',
                'password' => bcrypt('password'),
                'phone' => '0987654321',
                'role' => 0
            ],
            [
                'name' => 'User 01',
                'email' => 'test@sebastianrdz.com',
                'password' => bcrypt('password'),
                'phone' => '0987654321',
                'role' => 0
            ],
        ];
        foreach ($users as $user) {
            User::create($user);
        }
    }
}
