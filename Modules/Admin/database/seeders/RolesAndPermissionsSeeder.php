<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates roles and permissions for the admin guard.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions for each resource/entity
        $permissions = [
            // User management permissions
            'view_user',
            'view_any_user',
            'create_user',
            'update_user',
            'delete_user',
            'delete_any_user',
            'restore_user',
            'restore_any_user',
            'force_delete_user',
            'force_delete_any_user',
            'replicate_user',
            'reorder_user',

            // Page permissions
            'page_Dashboard',

            // Widget permissions
            'widget_StatsOverviewWidget',
            'widget_UserRegistrationChart',
            'widget_LatestUsersWidget',
        ];

        // Create all permissions for the admin guard
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'admin',
            ]);
        }

        // Create Super Admin role — has all permissions via Gate::before
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'admin',
        ]);

        // Create Admin role — full user management
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'admin',
        ]);
        $adminRole->syncPermissions([
            'view_user',
            'view_any_user',
            'create_user',
            'update_user',
            'delete_user',
            'delete_any_user',
            'page_Dashboard',
            'widget_StatsOverviewWidget',
            'widget_UserRegistrationChart',
            'widget_LatestUsersWidget',
        ]);

        // Create Editor role — view and edit only
        $editorRole = Role::firstOrCreate([
            'name' => 'editor',
            'guard_name' => 'admin',
        ]);
        $editorRole->syncPermissions([
            'view_user',
            'view_any_user',
            'update_user',
            'page_Dashboard',
            'widget_StatsOverviewWidget',
            'widget_UserRegistrationChart',
            'widget_LatestUsersWidget',
        ]);
    }
}
