<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::apiResource('mail', \Jstoone\Mailman\Http\Controllers\MailmanController::class)
    ->only(['index', 'show', 'destroy'])
    ->names([
        'index'    => 'nova-mailman.index',
        'show'     => 'nova-mailman.show',
        'destroy'  => 'nova-mailman.destroy',
    ]);
