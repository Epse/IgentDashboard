<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddSurveyPermissions extends Migration
{
    public function up()
    {
        Permission::create(['name' => 'view survey results']);
        Role::findByName('admin')->givePermissionTo('view survey results');
        Role::findByName('analyst')->givePermissionTo('view survey results');
    }

    public function down()
    {
        Permission::findByName('view survey results')->delete();
    }
}
