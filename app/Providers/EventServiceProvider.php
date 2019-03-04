<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
//use Illuminate\Auth\Events\Registered;
//use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Modules\Access\Events\UserCreating' => [
            'App\Modules\Access\Listeners\updateApiToken',
        ], 'App\Modules\Generic\Events\SettingUpdated' => [
            'App\Modules\Generic\Listeners\updateSettingWithCache',
        ],
//        Registered::class => [
//            SendEmailVerificationNotification::class,
//        ],
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
