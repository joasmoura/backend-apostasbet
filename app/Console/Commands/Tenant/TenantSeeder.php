<?php

namespace App\Console\Commands\Tenant;

use Illuminate\Support\Facades\Artisan;
use App\Models\Empresa;
use Illuminate\Console\Command;
use App\Tenant\ManagerTenant;

class TenantSeeder extends Command
{
     private $tenant;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:seed {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executando seeds das empresas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ManagerTenant $tenant)
    {
        parent::__construct();
        $this->tenant = $tenant;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
   public function handle()
    {
        if($id = $this->argument('id')):
            $empresa = Empresa::find($id);

            if($empresa):
                return $this->execCommand($empresa);
            endif;
        endif;
    }

    public function execCommand(Empresa $empresa) {
        $this->tenant->setConenection($empresa);
        $command = Artisan::call('db:seed',[
            '--class' => 'TenantsTableSeeders',
        ]);

        if($command === 0):
            $this->info('Seeder rodou com sucesso ');
        endif;
    }
}
