<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Organizations sit above the menu tree: the app's home grid shows them
     * first, and each one holds its own main categories. Existing categories
     * are gathered under a default organization so the app keeps working the
     * moment this lands.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name');
            $table->string('thumbnail')->nullable();
            $table->boolean('status')->default(1);
            // Tile order on the app's home grid, low first.
            $table->integer('position')->default(0);
            $table->timestamps();
        });

        Schema::table('categories', function (Blueprint $table) {
            // Only main categories carry one — the levels below belong to
            // whatever organization their root does.
            $table->foreignId('organization_id')
                ->nullable()
                ->after('parent_id')
                ->constrained()
                ->nullOnDelete();
        });

        $organization = DB::table('organizations')->insertGetId([
            'name' => 'बारबर्दिया नगरपालिका',
            'status' => 1,
            'position' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categories')
            ->whereNull('parent_id')
            ->update(['organization_id' => $organization]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropConstrainedForeignId('organization_id');
        });

        Schema::dropIfExists('organizations');
    }
};
