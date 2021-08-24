<?php

namespace App\Providers;

use App\Models\Permissao;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        // if(\Illuminate\Support\Facades\Schema::hasTable('permissoes')){
        //     $permissoes = Permissao::with('niveis')->get();
        //     foreach ($permissoes as $permissao):
        //         $gate->define($permissao->perm_nome,function(User $usuario) use ($permissao){
        //            return $usuario->hasPermission($permissao);
        //         });
        //     endforeach;

        //     $gate->before(function(User $usuario,$ability){
        //         if($usuario->hasAnyNiveis('sadmin')){
        //             return true;
        //         }
        //     });
        // }
    }
}
