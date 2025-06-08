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
            'ward:view',
            'ward:edit',
            'ward:delete',
            'ward:reorder',
            'ward:category',

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
