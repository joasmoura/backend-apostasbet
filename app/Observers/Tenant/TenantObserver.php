<?php

namespace App\Observers\Tenant;
use App\Tenant\ManagerTenant;
use Illuminate\Database\Eloquent\Model;
/**
 * Description of TenantObserver
 *
 * @author Joás
 */
class TenantObserver {
    public function creating(Model $model) {
        $tenant = app(ManagerTenant::class)->getTenantIdentfy();
        $model->setAttribute('empresa_id', $tenant);
    }
}
