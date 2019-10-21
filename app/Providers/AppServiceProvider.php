<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    public function register()
    {
        $this->app->bind(
            'App\Services\iNewsService',
            'App\Services\NewsService'
        );

        $this->app->bind(
            'App\Services\iAgendaService',
            'App\Services\AgendaService'
        );

        $this->app->bind(
            'App\Services\iCompanyService',
            'App\Services\CompanyService'
        );

        $this->app->bind(
            'App\Services\iPageService',
            'App\Services\PageService'
        );

        $this->app->bind(
            'App\Services\iAdvertisementService',
            'App\Services\AdvertisementService'
        );

        $this->app->bind(
            'App\Services\iUserService',
            'App\Services\UserService'
        );

        $this->app->bind(
            'App\Services\iSearchService',
            'App\Services\SearchService'
        );

        $this->app->bind(
            'App\Services\iColumnService',
            'App\Services\ColumnService'
        );

        $this->app->bind(
            'App\Services\iVacatureService',
            'App\Services\VacatureService'
        );
        $this->app->bind(
            'App\Services\iVacatureFeedService',
            'App\Services\VacatureFeedService'
        );
        $this->app->bind(
            'App\Services\iPinboardService',
            'App\Services\PinboardService'
        );

        $this->app->bind('App\Enum\PinboardCategory', function ($app) {
            return new \App\Enum\PinboardCategory();
        });

        $this->app->bind(
            'App\Services\iSubscriberService',
            'App\Services\SubscriberService'
        );
    }
}
