<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::create(['name'=>'Super Admin']);
        Job::create(['name'=>'Admin']);
        Job::create(['name'=>'Asset']);
        Job::create(['name'=>'Teknisi']);
        Job::create(['name'=>'NOC']);
        Job::create(['name'=>'Marketing']);
    }
}
