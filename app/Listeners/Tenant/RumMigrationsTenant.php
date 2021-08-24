<?php

namespace App\Listeners\Tenant;

use App\Event\Tenant\DatabaseCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;
class RumMigrationsTenant
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DatabaseCreated  $event
     * @return void
     */
    public function handle(DatabaseCreated $event)
    {
        $empresa = $event->getEmpresa();
        $migration = Artisan::call('tenant:migrations',[
            'id' => $empresa->id,
        ]);
        
        return $migration === 0;
    }
}
