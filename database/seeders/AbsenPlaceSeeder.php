<?php

namespace Database\Seeders;

use App\Models\AbsenPlace;
use Illuminate\Database\Seeder;

class AbsenPlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AbsenPlace::create([
            'name' => '28 Oktober',
            'coordinate' => '-0.01042329692304121,109.36047982689807'
        ]);
        AbsenPlace::create([
            'name' => 'Kantor Serdam',
            'coordinate' => '-0.0740204,109.3552958'
        ]);
        AbsenPlace::create([
            'name' => 'Server Kobar',
            'coordinate' => '-0.06151883401780252,109.30153800746115'
        ]);
        AbsenPlace::create([

            'name' => 'RBK Raya',
            'coordinate' => '-0.121239,109.330320'
        ]);
    }
}
