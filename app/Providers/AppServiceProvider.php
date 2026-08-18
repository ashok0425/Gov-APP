<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\Cms;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // Belt and braces alongside the InnoDB engine in config/database.php:
        // 191 characters is the longest a utf8mb4 column can be and still fit
        // an index on an older MySQL. Nothing here loses room — the long
        // fields (title, slug, short_description) are text columns already.
        Schema::defaultStringLength(191);

        // The bottom nav rides on several mobile screens; rather than thread
        // the badge count through each controller action, fill it in here when
        // the view didn't already supply one.
        View::composer('mobile.partials.bottom-nav', function ($view) {
            if (! array_key_exists('noticeCount', $view->getData())) {
                $view->with('noticeCount', Blog::whereDate('created_at', today())->count());
            }
        });

        // Palika is behind a switch in Cms, and both the nav and the app's
        // Settings screen have to agree on it.
        View::composer(['mobile.partials.bottom-nav', 'mobile.settings'], function ($view) {
            $view->with('showPalika', (bool) optional(Cms::settings())->show_palika);
        });

        // The header banner is a Cms upload, shown on every screen that opens
        // with the banner strip.
        View::composer('mobile.partials.app-banner', function ($view) {
            $view->with('headerBanner', optional(Cms::settings())->header_banner);
        });
    }
}
