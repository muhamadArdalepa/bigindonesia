<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OdpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $odps = [
            [
                'odc_id' => 1,
                'name' => 'ODP-20101',
                'coordinate' => '-0.010477,109.360246',
                'splitter' => 8,
                'address' => 'VILLA MANDIRI',
                'desc' => '',
            ],
            [
                'odc_id' => 1,
                'name' => 'ODP-20102',
                'coordinate' => '-0.010400,109.3603067',
                'splitter' => 8,
                'address' => 'DEPAN KANTOR',
                'desc' => '',
            ],
            [
                'odc_id' => 1,
                'name' => 'ODP-20101',
                'coordinate' => '-0.010400,109.3603067',
                'splitter' => 8,
                'address' => 'DEPAN KANTOR',
                'desc' => '',
            ],
            [
                'odc_id' => 1,
                'name' => 'ODP-20101',
                'coordinate' => '-0.010400,109.3603067',
                'splitter' => 8,
                'address' => 'DEPAN KANTOR',
                'desc' => '',
            ],
        ];
    }
}
