<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'manage system settings',
            'manage users',
            'manage roles',
            'manage academic records',
            'manage faculty records',
            'manage student records',
            'manage registrar records',
            'view reports',
            'view audit logs',
        ];

        foreach($permissions as $permission){
            Permission::findOrCreate($permission, 'web');
        }

        $superAdmin = Role::findOrCreate('Super Admin', 'web');
        $registrarAdmin = Role::findOrCreate('Registrar Admin', 'web');
        $registrarStaff = Role::findOrCreate('Registrar Staff', 'web');
        $faculty = Role::findOrCreate('Faculty', 'web');

        $superAdmin->syncPermissions(
            Permission::where('guard_name', 'web')->get()
        );

        $registrarAdmin->syncPermissions([
            'manage users',
            'manage academic records',
            'manage faculty records',
            'manage student records',
            'manage registrar records',
            'view reports',
        ]);

        $registrarStaff->syncPermissions([
            'manage academic records',
            'manage student records',
            'manage registrar records',
            'view reports',
        ]);

        $faculty->syncPermissions([
            'manage faculty records',
            'view reports',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
