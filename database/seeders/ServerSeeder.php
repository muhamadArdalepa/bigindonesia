<?php

namespace Database\Seeders;

use App\Models\Server;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $servers = [
            [
                'region_id' => 2,
                'name' => '28 Oktober',
                'code' => 'P',
                'coordinate' => '-0.01042329692304121,109.36047982689807',
                'address' => 'Jalan 28 Oktober, Siantan Hulu, Kota Pontianak, Kalimantan Barat',
            ],
            [
                'region_id' => 2,
                'name' => 'RBK Raya',
                'code' => 'R',
                'coordinate' => '-0.10810810810810811,109.33352795648776',
                'address' => 'Punggur Kecil, Sungai Kakap, Kabupaten Kubu Raya, Kalimantan Barat',
            ],
            [
                'region_id' => 2,
                'name' => 'Kobar',
                'code' => 'K',
                'coordinate' => '-0.0606975,109.3015531',
                'address' => 'Pal IX, Sungai Kakap, Kabupaten Kubu Raya, Kalimantan Barat',
            ],
        ];
        foreach ($servers as $server) {
            Server::create($server);
        }
    }
}
