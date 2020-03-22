<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddBasicPermissions extends Migration
{
    public function up()
    {
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage surveys']);
        Permission::create(['name' => 'view data']);

        $admin = Role::create(['name' => 'admin']);
        $analyst = Role::create(['name' => 'analyst']);

        $admin->syncPermissions('manage users', 'manage surveys', 'view data');
        $analyst->syncPermissions('manage surveys', 'view data');
    }

    public function down()
    {
        Role::findByName('admin')->delete();
        Role::findByName('analyst')->delete();

        Permission::findByName('manage users')->delete();
        Permission::findByName('manage surveys')->delete();
        Permission::findByName('view data')->delete();
    }
}
