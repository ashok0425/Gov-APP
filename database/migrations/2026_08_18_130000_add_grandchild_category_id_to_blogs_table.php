<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * The menu grew a fourth level, so a post has a fourth column to record it.
 * A post keeps its whole filing trail — category, subcategory, child, and now
 * grandchild — which is what lets a parent's screen list everything below it.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->unsignedBigInteger('grandchild_category_id')->nullable()->after('child_category_id');
            $table->index('grandchild_category_id');
        });
    }

    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropIndex(['grandchild_category_id']);
            $table->dropColumn('grandchild_category_id');
        });
    }
};
