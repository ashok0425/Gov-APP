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
            'product:view',
            'product:create',
            'product:edit',
            'product:delete',
            'products:pricing',
            'product:sales',
            'product:purchase',
            'orders:view',
            'orders:create',
            'orders:edit',
            'orders:delete',
            'orders:label',
            'customer:view',
            'customer:create',
            'customer:edit',
            'customer:delete',
            'kyc:view',
            'kyc:create',
            'kyc:edit',
            'kyc:delete',
            'category:view',
            'category:create',
            'category:edit',
            'category:delete',
            'subcategory:view',
            'subcategory:create',
            'subcategory:edit',
            'subcategory:delete',
             ];

             foreach ($permissions as $key => $permission) {
                Permission::create([
                    'name'=>$permission,
                    'guard_name'=>'admin'
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
