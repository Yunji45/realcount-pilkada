<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Faker\Factory as FakerFactory;
use Database\Factories\NikProvider;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cahced roles and permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

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
        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo('View User Management');
        $superAdminRole->givePermissionTo('Create User');
        $superAdminRole->givePermissionTo('Edit User');
        $superAdminRole->givePermissionTo('Delete User');
        $superAdminRole->givePermissionTo('Show User');

        $superAdminRole->givePermissionTo('Create Role');
        $superAdminRole->givePermissionTo('Edit Role');
        $superAdminRole->givePermissionTo('Delete Role');
        $superAdminRole->givePermissionTo('Show Role');

        $superAdminRole->givePermissionTo('Create Permission');
        $superAdminRole->givePermissionTo('Edit Permission');
        $superAdminRole->givePermissionTo('Delete Permission');
        $superAdminRole->givePermissionTo('Show Permission');

        $adminRole = Role::create(['name' => 'Admin']);

        $adminRole->givePermissionTo('View User Management');
        $adminRole->givePermissionTo('Create User');
        $adminRole->givePermissionTo('Edit User');
        $adminRole->givePermissionTo('Delete User');
        $adminRole->givePermissionTo('Show User');

        $personalRole = Role::create(['name' => 'Personal']);

        $teamRole = Role::create(['name' => 'Team']);

        $faker = FakerFactory::create();
        $faker->addProvider(new NikProvider($faker));

        //START:Super Admin
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('qwerty12'),
            'address' => "Jl. Swakarya",
            'nik' => $faker->nik,
        ]);
        $user->assignRole($superAdminRole);
        //END:Super Admin

        //START:Admin
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('qwerty12'),
            'address' => "Jl. Swakarya",
            'nik' => $faker->nik,
        ]);
        $user->assignRole($adminRole);
        //END:Admin

        //START:Personal
        $user = User::factory()->create([
            'name' => 'Personal',
            'email' => 'personal@gmail.com',
            'password' => bcrypt('qwerty12'),
            'address' => "Jl. Swakarya",
            'nik' => $faker->nik,
        ]);
        $user->assignRole($personalRole);
        //END:Personal

        //START:Team
        $user = User::factory()->create([
            'name' => 'Team',
            'email' => 'team@gmail.com',
            'password' => bcrypt('qwerty12'),
            'address' => "Jl. Swakarya",
            'nik' => $faker->nik,
        ]);
        $user->assignRole($teamRole);
        //END:Team
    }
}
