<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddFeedbackPermissions extends Migration
{
    public function up()
    {
        Permission::create(['name' => 'view feedback']);
        Permission::create(['name' => 'manage feedback']);

        $admin = Role::findByName('admin');
        $analyst = Role::findByName('analyst');

        $admin->givePermissionTo('view feedback', 'manage feedback');
        $analyst->givePermissionTo('view feedback');
    }

    public function down()
    {
        Permission::findByName('view feedback')->delete();
        Permission::findByName('manage feedback')->delete();
    }
}
