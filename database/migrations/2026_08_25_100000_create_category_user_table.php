<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * An employee can be pinned to any number of menu nodes — categories,
     * subcategories, children or grandchildren. From then on they only see
     * and file posts under those nodes. No rows leaves the employee
     * unrestricted.
     */
    public function up()
    {
        Schema::create('category_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->primary(['user_id', 'category_id']);
            $table->index('category_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_user');
    }
};
