<?php

namespace App\Console\Commands;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ReinstallRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:reinstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reinstall roles and permissions from data preset';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $roles = Role::all();
        $users = User::all();
        $oldUsersAndRoles = [];
        foreach ($users as $user) {
            /** @var \App\User $user */
            /** @var \Spatie\Permission\Models\Role $role */
            foreach ($user->roles as $role) {
                if(!isset($oldUsersAndRoles[$role->name])) {
                    $oldUsersAndRoles[$role->name] = [];
                }
                $oldUsersAndRoles[$role->name][] = $user;
            }
            $user->syncRoles([]);

        }
        foreach ($roles as $role) {
            /** @var \Spatie\Permission\Models\Role $role */
            $role->syncPermissions([]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        Permission::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $seeder = app(RolesAndPermissionsSeeder::class);
        $seeder->run();


        foreach ($oldUsersAndRoles as $role => $users) {
            foreach ($users as $user) {
                $user->assignRole($role);
            }
        }

        $this->info('Roles and permissions reinstalled');
    }
}
