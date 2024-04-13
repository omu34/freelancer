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
        Permission::create(['name' => 'view_profiles']);


        $adminRole = Role::findByName('admin');
        $adminRole->hasPermissionTo('approve_account');

        $adminRole = Role::findByName('freelancer');
        $adminRole->hasPermissionTo('view_profiles');
    }
}
