<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\StaticPage;
use App\Category;
use App\Setting;


class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Schema::defaultStringLength(191);
        view()->composer('*', function ($view) {
            $nav_static_pages = StaticPage::where('page_status', 1)
                    ->where('page_show', 1)
                    ->get();
            $nav_categories = Category::where('status', 1)
                    ->whereNull('parent_id')
                    ->oldest('weight')
                    ->get();

            $befooter_homepage = StaticPage::where('page_status', 1)
                    ->where('page_show', 3)
                    ->get();
            $footer_homepage = StaticPage::where('page_status', 1)
                    ->whereIn('page_show', array(2, 3))
                    ->get();
            $app_settings = Setting::getDefaultSettings();
            $view->with([
                'nav_static_pages' => $nav_static_pages,
                'nav_categories' => $nav_categories,
                'befooter_homepage' => $befooter_homepage,
                'footer_homepage' => $footer_homepage,
                'app_settings' => $app_settings
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
