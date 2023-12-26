<?php

namespace Database\Seeders;

use App\Models\Packet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PacketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packets = [
            [
                'name' => 'Paket Dasar 1',
                'server_id' => 1,
                'price' => 150000,
                'speed' => 3
            ],
            [
                'name' => 'Paket Dasar 2',
                'server_id' => 1,
                'price' => 200000,
                'speed' => 5
            ],
            [
                'name' => 'Silver',
                'server_id' => 1,
                'price' => 250000,
                'speed' => 7
            ],
            [
                'name' => 'Gold',
                'server_id' => 1,
                'price' => 300000,
                'speed' => 8
            ],
            [
                'name' => 'Platinum',
                'server_id' => 1,
                'price' => 350000,
                'speed' => 15
            ],
            [
                'name' => 'Paket Dasar 1',
                'server_id' => 2,
                'price' => 150000,
                'speed' => 3
            ],
            [
                'name' => 'Paket Dasar 2',
                'server_id' => 2,
                'price' => 200000,
                'speed' => 5
            ],
            [
                'name' => 'Silver',
                'server_id' => 2,
                'price' => 250000,
                'speed' => 7
            ],
            [
                'name' => 'Gold',
                'server_id' => 2,
                'price' => 300000,
                'speed' => 8
            ],
            [
                'name' => 'Platinum',
                'server_id' => 2,
                'price' => 350000,
                'speed' => 15
            ],
            [
                'name' => 'Bronze',
                'server_id' => 3,
                'price' => 150000,
                'speed' => 5
            ],
            [
                'name' => 'Silver',
                'server_id' => 3,
                'price' => 200000,
                'speed' => 8
            ],
            [
                'name' => 'Gold',
                'server_id' => 3,
                'price' => 250000,
                'speed' => 10
            ],
            [
                'name' => 'Platinum',
                'server_id' => 3,
                'price' => 300000,
                'speed' => 15
            ],
        ];
        foreach ($packets as $packet) {
            Packet::create($packet);
        }
    }
}
