<?php

namespace App\Providers;

use YouCan\Pay\YouCanPay;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\MenuComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(YouCanPay::class, function ($app) {
            YouCanPay::setIsSandboxMode(true);

            return YouCanPay::instance()->useKeys(config('ycpay.private_key'), config('ycpay.public_key'));
        });
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
