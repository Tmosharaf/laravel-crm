<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        // or may be done by chaining
        $role = Role::create(['name' => 'user']);
        $role = Role::create(['name' => 'admin']);

        foreach (User::all() as $user) {
            $user->syncRoles(1);
        }


    }
}
