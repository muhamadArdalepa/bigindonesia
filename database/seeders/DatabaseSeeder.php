<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            JobSeeder::class,
            RegionSeeder::class,
            ServerSeeder::class,
            OdcSeeder::class,
            OdpSeeder::class,
            UserSeeder::class,
            PacketSeeder::class,
        ]);
    }
}
