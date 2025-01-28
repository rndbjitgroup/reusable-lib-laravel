<?php

namespace Database\Seeders;

use App\Enums\CmnEnum;
use App\Models\PermissionsAndRoles\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
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
