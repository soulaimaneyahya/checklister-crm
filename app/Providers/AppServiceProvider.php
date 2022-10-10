<?php

namespace App\Providers;

use App\Http\View\Composers\MenuComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        // the key is too long for long indexes, so we can skip overriding it to 191
        Schema::defaultStringLength(191);
        // pagination
        Paginator::useBootstrap();
        // view composer, pass data to views globally
        View::composer('partials.sidebar', MenuComposer::class);
        // components aliases
        Blade::aliasComponent('components.badge', 'badge');
        Blade::aliasComponent('components.page', 'page');
        Blade::aliasComponent('components.menu', 'menu');
    }
}
