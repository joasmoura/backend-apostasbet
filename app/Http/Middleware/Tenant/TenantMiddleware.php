<?php

namespace App\Http\Middleware\Tenant;

use App\Tenant\ManagerTenant;
use Closure;

class TenantMiddleware{

    public function handle($request, Closure $next){
        if(auth()->check()){
            $tenant = $this->getTenant();
            if(!$tenant):
                return 'erro';
            else:
                app(ManagerTenant::class)->setConenection($tenant);
                $this->setSessionEmpresa($tenant);
            endif;
        }
        return $next($request);
    }

    public function getTenant() {
        return app(ManagerTenant::class)->getTenant();
    }

    public function setSessionEmpresa($data) {
        session()->put('empresa',$data);
    }

}
