<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Event\Tenant\CompanyCreated' => [
            'App\Listeners\Tenant\CreatedCompanyDatabase',
          ],
          'App\Event\Tenant\DatabaseCreated' =>[
              'App\Listeners\Tenant\RumMigrationsTenant',
          ],
          'Illuminate\Auth\Event\Login' =>[
              'App\Listeners\LoginListener',
          ],
          'App\Event\AdesaoEvent' => [
            'App\Listeners\AdesaoEventListener',
          ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
