<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions=[
            'user:view',
            'user:create',
            'user:edit',
            'user:delete',
            'business:view',
            'business:create',
            'business:edit',
            'business:delete',
            'category:view',
            'category:create',
            'category:edit',
            'category:delete',
            'blog:view',
            'blog:create',
            'blog:edit',
            'blog:delete',
             ];

             foreach ($permissions as $key => $permission) {
                Permission::create([
                    'name'=>$permission,
                    'guard_name'=>'web'
                ]);
             }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
