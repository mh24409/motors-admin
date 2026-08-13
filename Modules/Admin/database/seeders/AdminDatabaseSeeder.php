<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Models\Admin;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates initial admin roles, permissions, and a Super Admin account.
     *
     * ⚠️ DEVELOPMENT CREDENTIALS — Change in production!
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
