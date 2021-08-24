<?php
namespace App\Http\Middleware\Tenant;
use Closure;
use App\Tenant\ManagerTenant;

class TenantFileSystems {

    public function handle($request, Closure $next){
        if(auth()->check()){
            $this->setFilesystemRoot();
        }
    }

    public function setFilesystemRoot(){
        $tenant = app(ManagerTenant::class)->getTenant();

        config()->set(
            'filesystems.disks.igrejas.root',
            config('filesystems.disks.igrejas.root')."/{$tenant->uuid}"
        );
    }
}
