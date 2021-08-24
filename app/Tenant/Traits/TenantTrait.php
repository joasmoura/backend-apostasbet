<?php

namespace App\Tenant\Traits;

use App\Scope\Tenant\TenantScope;
use App\Observers\Tenant\TenantObserver;
/**
 * Description of TenantTrait
 *
 * @author Joás
 */
class TenantTrait {
    public static function boot() {
        parent::boot();
        static::addGlobalScope(new TenantScope);
        static::observe(new TenantObserver);
    }
}
