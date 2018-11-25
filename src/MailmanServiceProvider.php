<?php

namespace Jstoone\Mailman;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Jstoone\Mailman\Http\Middleware\Authorize;
use Jstoone\Mailman\Mailer\MailProvider;

class MailmanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->views();

        $this->app->booted(function () {
            $this->routes();
        });
    }

    protected function views()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-mailman');

        $this->loadViewsFrom(Storage::path('mailman'), 'nova-mailman-mails');
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
