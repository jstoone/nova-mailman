<?php

namespace Jstoone\Mailman;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Jstoone\Mailman\Http\Middleware\Authorize;
use Jstoone\Mailman\Mailer\MailProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class MailmanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-mailman');

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/jstoone/nova-mailman')
                ->group(__DIR__ . '/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (config('mail.driver') === 'mailman') {
            $this->app->register(MailProvider::class);
        }
    }
}
