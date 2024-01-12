<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_marketer = Role::create(['name' => 'Marketer']);
        $role_karyawan = Role::create(['name' => 'Karyawan']);
        $role_super_admin = Role::create(['name' => 'Super Admin']);
        $role_supervisor = Role::create(['name' => 'Supervisor']);

        $super_admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@big.com',
            'password' => '123123',
            'region_id' => 2,
            'phone' => '6281234567890',
        ]);
        $super_admin->assignRole($role_karyawan);
        $super_admin->assignRole($role_super_admin);

        $marketer = User::create([
            'name' => 'Saya Marketer',
            'email' => 'marketer@big.com',
            'password' => '123123',
            'region_id' => 2,
            'phone' => '6281234567890',
        ]);
        $marketer->assignRole($role_karyawan);
        $marketer->assignRole($role_marketer);

        $buhar = User::create([
            'name' => 'Budi Hartono',
            'email' => 'budihartono@big.com',
            'password' => '123123',
            'region_id' => 2,
            'phone' => '6281234567890',
        ]);
        $buhar->assignRole($role_supervisor);
        $buhar->assignRole($role_super_admin);
    }
}
