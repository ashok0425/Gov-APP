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

        // The nav rides at the foot of several mobile screens; fill the badge
        // in here rather than threading it through each controller action.
        // It counts the posts published in the last 24 hours: anything older
        // has been seen, and a badge that never clears is noise.
        View::composer('mobile.partials.bottom-nav', function ($view) {
            $view->with('noticeCount', Blog::where('status', 1)
                ->where('created_at', '>=', now()->subDay())
                ->count());
        });

        // The header banner is a Cms upload, shown on every screen that opens
        // with the banner strip.
        View::composer('mobile.partials.app-banner', function ($view) {
            $view->with('headerBanner', optional(Cms::settings())->header_banner);
        });
    }
}
