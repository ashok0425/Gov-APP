<?php

use App\Models\Business;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $businesses = Business::all();

        foreach ($businesses as $business) {
            $is_array = is_array($business->category_ids);
            if($is_array&&count($business->category_ids)>1){
            $syncData = [];
            foreach ($business->category_ids as $index => $id) {
                $syncData[$id] = ['position' => $index + 1];
            }

            $business->categories()->sync($syncData);
        }
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
