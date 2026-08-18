<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Notifications get a table of their own. The app's सूचना tab used to list
 * whatever posts happened to be filed today, which made a notice something
 * you published by accident; now it is its own record with its own screen in
 * the admin.
 *
 * The table is "notices", not "notifications" — Laravel keeps that name for
 * its own database-channel notifications, and this is not that.
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('thumbnail')->nullable();
            // An outside page the notice points at, if it has one.
            $table->string('link')->nullable();
            // When it counts as sent. Blank means "as soon as it was saved".
            $table->dateTime('published_at')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->index(['status', 'published_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('notices');
    }
};
