<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // مشاركة معرف بيكسل ميتا مع القوالب لربط الموقع بالكامل
        View::composer([
            'layouts.app',
            'admin.layouts.head',
            'admin.auth.login',
            'admin.layouts.error',
        ], function ($view) {
            $metaPixelId = \App\Models\PageContent::where('key', 'meta_pixel_id')->value('content');
            $view->with('metaPixelId', $metaPixelId ? trim($metaPixelId) : null);
        });
    }
}
