<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;

/**
 * Saving a record should put you back where you were looking — page four of a
 * filtered list, not the top of page one. The list links carry their own URL
 * into the edit screen as "back", the form posts it on as "redirect_to", and
 * this hands it back on the way out.
 */
trait ReturnsToList
{
    /**
     * The URL to return to after a save: the list that sent us here when it
     * said so, and the plain list otherwise.
     */
    protected function returnUrl(Request $request, $fallbackRoute, $parameters = [])
    {
        $target = $request->input('redirect_to') ?: $request->query('back');

        // Only ever back into this application — a posted URL is user input.
        // The bare root is no answer either: with no referer to go on that is
        // where url()->previous() lands, and it is not a list.
        if ($target && str_starts_with($target, url('/')) && rtrim($target, '/') !== rtrim(url('/'), '/')) {
            return $target;
        }

        return route($fallbackRoute, $parameters);
    }
}
