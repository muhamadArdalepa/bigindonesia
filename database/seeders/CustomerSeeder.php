<?php

namespace Database\Seeders;

use App\Models\Odp;
use App\Models\Modem;
use App\Models\Packet;
use App\Models\Server;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        foreach (Server::all() as $server) {
            for ($i = 1; $i <= 200; $i++) {
                $modem = Modem::create([
                    'odp_id' => Odp::all()->random()->id,
                    'distance' => 100,
                    'sn' => 'ZTE' . strtoupper(str()->random()),
                    'ssid' => str()->random(),
                    'password' => str()->random(),
                    'port' => random_int(1, 16)
                ]);
                Customer::create([
                    'name' => fake()->firstName. ' ' .fake()->lastName(), 
                    'phone' => fake()->numerify('08###########'), 
                    'email' => fake()->email,
                    'nik' => fake()->numerify('################'),
                    'number' => $server->code. str_pad($i, 4, "0", STR_PAD_LEFT),
                    'region_id' => 2,
                    'server_id' => $server->id,
                    'modem_id' => $modem->id,
                    'packet_id' => Packet::where('server_id',$server->id)->get()->random()->id,
                    'va'=> str_pad($server->id, 2, "0", STR_PAD_LEFT) . str_pad($i, 4, "0", STR_PAD_LEFT),
                    'address'=> fake()->address,
                    'coordinate'=> '1,1',
                    'ktp_picture'=>'customers/ktp/4/niqJwCqigjwkxNXzSqtr34a5wJI409mv.jpeg',
                    'house_picture'=>'customers/house/A/gvR3JXziW6XBQFlLnyVQebdHOnTl6ekG.jpeg',
                    'status'=>1,
                    'has_report'=>false,
                ]);
            }
        }
        DB::commit();
    }
}
