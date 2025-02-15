<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permissions for customers, transfers, and profile
        $permissions = [
            'customers',
            'transfers',
            'crypto-rates',
        ];

        foreach ($permissions as $permission) {
            $this->createAutoAllPermissions($permission);
        }

        // Add profile permission only for Customer role
        $this->createAutoAllPermissions('profile');

        // Permissions assigned to roles
        $adminPermissions = $permissions;  
        $customerPermissions = ['transfers', 'profile'];  

        // Assign permissions to admin
        $admin = Role::findByName('admin');
        foreach ($adminPermissions as $permission) {
            $this->giveAutoAllPermissions($admin, $permission);
        }

        // Assign permissions to customer, including profile
        $customer = Role::findByName('customer');
        foreach ($customerPermissions as $permission) {
            $this->giveAutoAllPermissions($customer, $permission);
        }
    }

    /**
     * Create permissions for each type of action (CRUD) for a given entity.
     *
     * @param string $permission
     */
    private function createAutoAllPermissions($permission)
    {
        Permission::firstOrCreate(['name' => $permission]);
        Permission::firstOrCreate(['name' => $permission . '.create']);
        Permission::firstOrCreate(['name' => $permission . '.edit']);
        Permission::firstOrCreate(['name' => $permission . '.show']);
        Permission::firstOrCreate(['name' => $permission . '.delete']);
    }

    /**
     * Assign all CRUD permissions for a given entity to a role.
     *
     * @param \Spatie\Permission\Models\Role $role
     * @param string $permission
     */
    private function giveAutoAllPermissions($role, $permission)
    {
        $role->givePermissionTo($permission);
        $role->givePermissionTo($permission . '.show');
        $role->givePermissionTo($permission . '.create');
        $role->givePermissionTo($permission . '.edit');
        $role->givePermissionTo($permission . '.delete');
    }
}
