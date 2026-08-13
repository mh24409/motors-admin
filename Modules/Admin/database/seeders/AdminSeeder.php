<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * ⚠️ DEVELOPMENT CREDENTIALS — Change admin@example.com password in production!
     */
    public function run(): void
    {
        // Create Super Admin
        $superAdmin = Admin::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $superAdmin->assignRole('super_admin');

        // Create Admin
        $admin = Admin::firstOrCreate(
            ['email' => 'admin2@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $admin->assignRole('admin');

        // Create Editor
        $editor = Admin::firstOrCreate(
            ['email' => 'editor@example.com'],
            [
                'name' => 'Editor User',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );
        $editor->assignRole('editor');
    }
}
