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
     */
    public function boot(): void
    {
        $this->views();
        $this->configurations();

        $this->app->booted(function () {
            $this->routes();
            $this->events();
        });
    }

    /**
     * Register bindings in the container.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/mailman.php',
            'mailman'
        );

        config()->set('sheets.collections', [
            'mailman' => [
                'disk'        => config('mailman.disk'),
                'sheet_class' => MailSheet::class,
                'content_parser' => MailSheetParser::class,
            ],
        ]);
    }

    protected function views(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'nova-mailman');

        $this->loadViewsFrom(Storage::path('mailman'), 'nova-mailman-mails');
    }

    protected function configurations(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/mailman.php' => config_path('mailman.php'),
        ], 'config');
    }

    protected function routes(): void
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::bind('mail', function ($value) {
            return sheets()->get($value) ?? abort(404);
        });

        Route::middleware(['nova', 'bindings',  Authorize::class])
                ->prefix('nova-vendor/jstoone/nova-mailman')
                ->group(__DIR__ . '/../routes/api.php');
    }

    protected function events(): void
    {
        $this->app->make('events')->listen(MessageSent::class, DeliverToInbox::class);
    }
}
