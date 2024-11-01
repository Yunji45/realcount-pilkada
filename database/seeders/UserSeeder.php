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

        Permission::create(['name' => 'View Dashboard Perorangan']);
        Permission::create(['name' => 'View Dashboard Partai']);
        Permission::create(['name' => 'View Dashboard Peta']);

        Permission::create(['name' => 'View User Management']);
        Permission::create(['name' => 'View User']);
        Permission::create(['name' => 'Create User']);
        Permission::create(['name' => 'Edit User']);
        Permission::create(['name' => 'Delete User']);
        Permission::create(['name' => 'Show User']);

        Permission::create(['name' => 'View Roles']);
        Permission::create(['name' => 'Create Role']);
        Permission::create(['name' => 'Edit Role']);
        Permission::create(['name' => 'Delete Role']);
        Permission::create(['name' => 'Show Role']);

        Permission::create(['name' => 'View Permission']);
        Permission::create(['name' => 'Create Permission']);
        Permission::create(['name' => 'Edit Permission']);
        Permission::create(['name' => 'Delete Permission']);
        Permission::create(['name' => 'Show Permission']);

        //Partai
        Permission::create(['name' => 'View Partai']);
        Permission::create(['name' => 'Create Partai']);
        Permission::create(['name' => 'Edit Partai']);
        Permission::create(['name' => 'Delete Partai']);
        Permission::create(['name' => 'Show Partai']);

        //Pemilu
        Permission::create(['name' => 'View Election']);
        Permission::create(['name' => 'Create Election']);
        Permission::create(['name' => 'Edit Election']);
        Permission::create(['name' => 'Delete Election']);
        Permission::create(['name' => 'Show Election']);

        //Kandidate
        Permission::create(['name' => 'View Candidate']);
        Permission::create(['name' => 'Create Candidate']);
        Permission::create(['name' => 'Edit Candidate']);
        Permission::create(['name' => 'Delete Candidate']);
        Permission::create(['name' => 'Show Candidate']);

        //TPS
        Permission::create(['name' => 'View TPS']);
        Permission::create(['name' => 'Create TPS']);
        Permission::create(['name' => 'Edit TPS']);
        Permission::create(['name' => 'Delete TPS']);
        Permission::create(['name' => 'Show TPS']);

        //Vote
        Permission::create(['name' => 'View Vote']);
        Permission::create(['name' => 'Create Vote']);
        Permission::create(['name' => 'Edit Vote']);
        Permission::create(['name' => 'Delete Vote']);
        Permission::create(['name' => 'Show Vote']);

        //TPS Reacount
        Permission::create(['name' => 'View TPS Realcount']);
        Permission::create(['name' => 'Create TPS Realcount']);
        Permission::create(['name' => 'Edit TPS Realcount']);
        Permission::create(['name' => 'Delete TPS Realcount']);
        Permission::create(['name' => 'Show TPS Realcount']);

        //Suara TPS Realcount
        Permission::create(['name' => 'View Vote Realcount']);
        Permission::create(['name' => 'Create Vote Realcount']);
        Permission::create(['name' => 'Edit Vote Realcount']);
        Permission::create(['name' => 'Delete Vote Realcount']);
        Permission::create(['name' => 'Show Vote Realcount']);

        //Daftar C1
        Permission::create(['name' => 'View Register Data C1']);
        Permission::create(['name' => 'Create Register Data C1']);
        Permission::create(['name' => 'Edit Register Data C1']);
        Permission::create(['name' => 'Delete Register Data C1']);
        Permission::create(['name' => 'Show Register Data C1']);

        //Daftar D1
        Permission::create(['name' => 'View Register Data D1']);
        Permission::create(['name' => 'Create Register Data D1']);
        Permission::create(['name' => 'Edit Register Data D1']);
        Permission::create(['name' => 'Delete Register Data D1']);
        Permission::create(['name' => 'Show Register Data D1']);

        //Agenda
        Permission::create(['name' => 'View Agenda']);
        Permission::create(['name' => 'Create Agenda']);
        Permission::create(['name' => 'Edit Agenda']);
        Permission::create(['name' => 'Delete Agenda']);
        Permission::create(['name' => 'Show Agenda']);

        //Article
        Permission::create(['name' => 'View Article']);
        Permission::create(['name' => 'Create Article']);
        Permission::create(['name' => 'Edit Article']);
        Permission::create(['name' => 'Delete Article']);
        Permission::create(['name' => 'Show Article']);

        //create roles and assign existing permissions
        $superAdminRole = Role::create(['name' => 'Super Admin']);

        // Super Admin: Assign all permissions
        $superAdminRole->givePermissionTo(Permission::all());

        $adminRole = Role::create(['name' => 'Admin']);

        // Admin: Assign all permissions
        $adminRole->givePermissionTo(Permission::all());

        $pimpinanRole = Role::create(['name' => 'Pimpinan']);

        $pimpinanRole->givePermissionTo('View User Management');
        $pimpinanRole->givePermissionTo('Create User');
        $pimpinanRole->givePermissionTo('Edit User');
        $pimpinanRole->givePermissionTo('Delete User');
        $pimpinanRole->givePermissionTo('Show User');

        $adminRole = Role::create(['name' => 'Admin']);

        $adminRole->givePermissionTo('View User Management');
        $adminRole->givePermissionTo('Create User');
        $adminRole->givePermissionTo('Edit User');
        $adminRole->givePermissionTo('Delete User');
        $adminRole->givePermissionTo('Show User');

        $koordinatorKecamatanRole = Role::create(['name' => 'Koordinator Kecamatan']);
        $koordinatorKelurahanRole = Role::create(['name' => 'Koordinator Kelurahan']);
        $koordinatorRWRole = Role::create(['name' => 'Koordinator RW']);

        // Pemilih, Saksi, Relawan, Simpatisan, Lain-lain: Assign limited permissions
        $pemilihRole = Role::create(['name' => 'Pemilih']);
        $saksiRole = Role::create(['name' => 'Saksi']);
        $relawanRole = Role::create(['name' => 'Relawan RDW']);
        $simpatisanRole = Role::create(['name' => 'Simpatisan']);
        $lainnyaRole = Role::create(['name' => 'Lain-lain']);

        // Assigning limited permissions for lower roles
        $pemilihRole->givePermissionTo('View Dashboard Perorangan');
        $saksiRole->givePermissionTo('View Dashboard Peta');
        $relawanRole->givePermissionTo('View TPS');
        $simpatisanRole->givePermissionTo('View Vote');
        $lainnyaRole->givePermissionTo('View Agenda');

        $faker = FakerFactory::create();
        $faker->addProvider(new NikProvider($faker));

        //START: Super Admin
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('qwerty12'),
            'address' => 'Jl. Swakarya',
            'status' => 'Aktif',
            'nik' => 'DPCGERINDRA2024',
        ]);
        $user->assignRole($superAdminRole);
        //END: Super Admin
    }
}
