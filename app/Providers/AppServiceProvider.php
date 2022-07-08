<?php

namespace App\Providers;

use App\CPU\helpers;
use App\Models\WebConfig;
use Illuminate\Support\Facades\View as FacadesView;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $web = WebConfig::all();
            $web_config = [
                'web_logo' => helpers::getSetting($web, 'web_logo'),
                'web_name' => helpers::getSetting($web, 'web_name'),
            ];

            FacadesView::share(['web_config' => $web_config]);
        } catch (\Exception $e) {
        }
    }
}
