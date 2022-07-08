<?php

namespace Database\Seeders;

use App\Enums\CmnEnum;
use App\Models\PermissionsAndRoles\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['title' => 'admin', 'display_title' => 'Admin'],
            ['title' => 'user', 'display_title' => 'User']
        ];

        foreach ($roles as $roleKey => $roleRow) {
            $role = Role::create($roleRow);
            $role->permissions()->attach(CmnEnum::PERMISSIONS[$roleKey]);
        }

    }
}
