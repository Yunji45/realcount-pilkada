<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cahced roles and permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'View User Management']);
        Permission::create(['name' => 'Create User']);
        Permission::create(['name' => 'Edit User']);
        Permission::create(['name' => 'Delete User']);
        Permission::create(['name' => 'Show User']);

        Permission::create(['name' => 'Create Role']);
        Permission::create(['name' => 'Edit Role']);
        Permission::create(['name' => 'Delete Role']);
        Permission::create(['name' => 'Show Role']);

        Permission::create(['name' => 'Create Permission']);
        Permission::create(['name' => 'Edit Permission']);
        Permission::create(['name' => 'Delete Permission']);
        Permission::create(['name' => 'Show Permission']);

        //create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'Admin']);

        $adminRole->givePermissionTo('View User Management');
        $adminRole->givePermissionTo('Create User');
        $adminRole->givePermissionTo('Edit User');
        $adminRole->givePermissionTo('Delete User');
        $adminRole->givePermissionTo('Show User');

        $adminRole->givePermissionTo('Create Role');
        $adminRole->givePermissionTo('Edit Role');
        $adminRole->givePermissionTo('Delete Role');
        $adminRole->givePermissionTo('Show Role');

        $adminRole->givePermissionTo('Create Permission');
        $adminRole->givePermissionTo('Edit Permission');
        $adminRole->givePermissionTo('Delete Permission');
        $adminRole->givePermissionTo('Show Permission');


        $securityRole = Role::create(['name' => 'Security']);

        //START:Admin
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('qwerty12'),
        ]);
        $user->assignRole($adminRole);
        //END:Admin
    }
}
