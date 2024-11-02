<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'view-dashboard' => 'Access Dashboard',
            'manage-products' => 'Manage Products',
            'manage-categories' => 'Manage Categories',
            'manage-suppliers' => 'Manage Suppliers',
            'manage-customers' => 'Manage Customers',
            'manage-purchases' => 'Manage Purchases',
            'manage-sales' => 'Manage Sales',
            'access-reports' => 'Access Reports',
            'manage-users' => 'Manage Users',
            'manage-roles' => 'Manage Roles'
        ];

        foreach ($permissions as $slug => $name) {
            Permission::create([
                'name' => $name,
                'slug' => $slug,
                'description' => 'Ability to ' . Str::lower($name)
            ]);
        }

        // Create roles
        $adminRole = Role::create([
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => 'Full access to all features'
        ]);

        $cashierRole = Role::create([
            'name' => 'Cashier',
            'slug' => 'cashier',
            'description' => 'Can manage sales and customers'
        ]);

        // Assign permissions to roles
        $adminRole->permissions()->attach(Permission::all());

        $cashierRole->permissions()->attach(Permission::whereIn('slug', [
            'view-dashboard',
            'manage-sales',
            'manage-customers'
        ])->get());

        // Create admin user if not exists
        if (!User::where('email', 'admin@example.com')->exists()) {
            $admin = User::create([
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => bcrypt('password')
            ]);

            $admin->roles()->attach($adminRole);
        }
    }
}
