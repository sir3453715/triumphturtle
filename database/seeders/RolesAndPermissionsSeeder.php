<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //清除Role與Permission的cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //讀取Config檔案
        $roles = Config::get('data-presets.roles');
        $permissions = Config::get('data-presets.permissions');

        //建立Roles
        foreach ($roles as $role) {
            $_role = Role::create([
                'name' => $role['name'],
                'display_name' => $role['displayName']
            ]);
        }

        //建立Permissions
        foreach ($permissions as $permission) {
            $_permission = Permission::create([
                'name' => $permission['name'],
                'display_name' => $permission['displayName']
            ]);
            if(!empty($permission['assignTo'])) {
                foreach ($permission['assignTo'] as $roleName) {
                    $_permission->assignRole($roleName);
                }
            }
        }

    }
}
