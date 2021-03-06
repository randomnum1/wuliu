<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\QueryExecuted' => [
            'App\Listeners\QueryListener',
        ],
        'App\Events\MessageExecuted' => [
            'App\Listeners\MessageListener',
        ],
        'App\Events\PayExecuted' => [
            'App\Listeners\PayListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
