<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * An employee's pins used to be the deepest pick on each branch, with the
 * post form reaching them through their ancestors. Now a pin is exactly
 * what was ticked, and the form shows only pinned nodes — so every pin's
 * ancestors have to be pinned too, or it would be unreachable.
 */
return new class extends Migration
{
    public function up()
    {
        $parents = DB::table('categories')->pluck('parent_id', 'id');
        $pins = DB::table('category_user')->get();
        $rows = [];

        foreach ($pins as $pin) {
            $node = $parents->get($pin->category_id);
            $depth = 0;

            while ($node && $depth++ < 4) {
                $rows[$pin->user_id.':'.$node] = ['user_id' => $pin->user_id, 'category_id' => $node];
                $node = $parents->get($node);
            }
        }

        foreach ($rows as $row) {
            DB::table('category_user')->insertOrIgnore($row);
        }
    }

    public function down()
    {
        // The added ancestors are indistinguishable from real picks; leave them.
    }
};
