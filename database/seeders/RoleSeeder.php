<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for trucking management
        $permissions = [
            // Container permissions
            'view containers',
            'create containers',
            'edit containers',
            'delete containers',

            // Train permissions
            'view trains',
            'create trains',
            'edit trains',
            'delete trains',

            // DEPO permissions
            'view depo',
            'create depo',
            'edit depo',
            'delete depo',

            // Trucking permissions
            'view trucking',
            'create trucking',
            'edit trucking',
            'delete trucking',

            // Report permissions
            'view reports',
            'generate reports',

            // User management permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all());

        $managerRole = Role::firstOrCreate(['name' => 'Manager']);
        $managerRole->givePermissionTo([
            'view containers', 'create containers', 'edit containers',
            'view trains', 'create trains', 'edit trains',
            'view depo', 'create depo', 'edit depo',
            'view trucking', 'create trucking', 'edit trucking',
            'view reports', 'generate reports',
        ]);

        $operatorRole = Role::firstOrCreate(['name' => 'Operator']);
        $operatorRole->givePermissionTo([
            'view containers', 'create containers', 'edit containers',
            'view trains', 'create trains',
            'view depo', 'create depo',
            'view trucking', 'create trucking',
        ]);

        $driverRole = Role::firstOrCreate(['name' => 'Driver']);
        $driverRole->givePermissionTo([
            'view containers',
        ]);
    }
}
