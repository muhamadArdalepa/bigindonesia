<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'role' => 1,
            'position' => 'Admin',
            'job_id' => 1,
            'email' => 'admin@big.com',
            'password' => '123123',
            'region_id' => 2,
            'phone' => '6281234567890',
        ]);
    }
}
