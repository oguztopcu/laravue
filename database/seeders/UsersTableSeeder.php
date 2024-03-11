<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->insert([
            [
                'name' => 'Oguz Topcu',
                'email' => 'admin@laravue.test',
                'password' => bcrypt('admin12345'),
                'email_verified_at' => now()
            ]
        ]);
    }
}
