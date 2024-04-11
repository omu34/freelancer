<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Permission::create(['name' => 'approve_account']);

        // Assign permissions to roles as needed
        $adminRole = Role::findByName('admin');
        $adminRole->hasPermissionTo('approve_account');
    }
}
