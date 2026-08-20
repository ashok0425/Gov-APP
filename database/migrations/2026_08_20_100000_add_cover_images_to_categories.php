<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A category at any level can carry a set of cover images, shown as a
     * carousel at the top of its screen in the app. The switch and the
     * images are separate so an editor can stage pictures before showing
     * them — or hide the carousel without losing them.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Off by default: the carousel only appears once an editor ticks
            // "Show cover carousel" on the category.
            $table->boolean('show_cover')->default(0)->after('status');
        });

        Schema::create('category_images', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            // Named like every other image column so the mobile carousel
            // partial can render these rows unchanged.
            $table->string('thumbnail');
            $table->integer('position')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_images');

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('show_cover');
        });
    }
};
