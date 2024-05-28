<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $access = [
            'Super Admin',
            'Karyawan',
            'Supervisor',
            'Marketer',
            'Teknisi',
            'PIC',
            'K3',
            'Asset',
            'NOC',
            'CS',
            'Frontliner',
            'Akuntan',
            'Programmer',
            'Manager',
            'Admin',
        ];
        foreach ($access as $a) {
            Role::create(['name'=>$a]);
        }
    }
}
