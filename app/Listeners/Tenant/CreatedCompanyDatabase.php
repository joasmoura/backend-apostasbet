<?php

namespace App\Listeners\Tenant;

use App\Event\Tenant\CompanyCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Tenant\Database\DatabaseManager;
use App\Event\Tenant\DatabaseCreated;

class CreatedCompanyDatabase
{

    private $database;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(DatabaseManager $database)
    {
        $this->database = $database;
    }

    /**
     * Handle the event.
     *
     * @param  CompanyCreated  $event
     * @return void
     */
    public function handle(CompanyCreated $event)
    {
        $empresa = $event->getEmpresa();
        if(!$this->database->createDatabase($empresa)):
            throw new Exception('Erro ao criar base de dados');
        endif;

        event(new DatabaseCreated($empresa));
    }
}
