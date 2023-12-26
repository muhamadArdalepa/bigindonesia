<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            'Ngabang',
            'Pontianak',
            'Sintang',
            'Mempawah',
            'Singkawang',
            'Ketapang',
            'Semarang',
        ];
        foreach ($regions as  $region) {
            Region::create([
                'name' => $region
            ]);
        }
    }
}
