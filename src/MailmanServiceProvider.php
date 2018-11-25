<?php

namespace Jstoone\Mailman;

use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Jstoone\Mailman\Http\Middleware\Authorize;

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

        $this->app->make('events')->listen(MessageSent::class, DeliverToInbox::class);

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
}
