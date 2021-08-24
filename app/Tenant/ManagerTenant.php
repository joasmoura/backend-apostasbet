<?php

namespace App\Tenant;

use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
class ManagerTenant {

    private $empresa;

    public function getTenantIdentfy() {
        return auth()->user()->empresa->id;
    }

    public function getTenant(): Empresa{
        return auth()->user()->empresa;
    }

    public function setConenection(Empresa $empresa) {
        DB::purge('tenant');

        config()->set('database.connections.tenant.host',$empresa->db_servidor);
        config()->set('database.connections.tenant.database',$empresa->db_base);
        config()->set('database.connections.tenant.username',$empresa->db_usuario);
        config()->set('database.connections.tenant.password',$empresa->db_senha);

        DB::reconnect('tenant');

        Schema::connection('tenant')->getConnection()->reconnect();
    }

    public function setBase(Empresa $empresa) {
        $this->empresa = $empresa;
    }


}
