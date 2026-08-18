<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Contact details now hang off a category rather than a palika. The column
     * names match the ones the businesses table used, so the mobile contact
     * card renders a category with no changes of its own.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Off by default: the floating contact button only appears once an
            // editor ticks "Show contact" on the category.
            $table->boolean('show_contact')->default(0)->after('status');
            $table->string('owner_name')->nullable()->after('show_contact');
            $table->string('address')->nullable()->after('owner_name');
            $table->string('google_map_link')->nullable()->after('address');
            $table->string('email')->nullable()->after('google_map_link');
            $table->string('phone')->nullable()->after('email');
            $table->string('whatsapp')->nullable()->after('phone');
            $table->string('messanger')->nullable()->after('whatsapp');
            $table->string('facebook')->nullable()->after('messanger');
            $table->string('other')->nullable()->after('facebook');
            // Tile order on the app's home grid, low first.
            $table->integer('position')->default(0)->after('other');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn([
                'show_contact',
                'owner_name',
                'address',
                'google_map_link',
                'email',
                'phone',
                'whatsapp',
                'messanger',
                'facebook',
                'other',
                'position',
            ]);
        });
    }
};
