<?php

namespace App\Rules\Tenant;

use Illuminate\Contracts\Validation\Rule;
use App\Tenant\ManagerTenant;
use Illuminate\Support\Facades\DB;

class TenantUnique implements Rule
{
    
    private $tabela,$coluna,$colunaValor;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($tabela,$colunaValor = null, $coluna = 'id')
    {
        $this->tabela = $tabela;
        $this->coluna = $coluna;
        $this->colunaValor = $colunaValor;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $tenant = app(ManagerTenant::class)->getTenantIdentfy();
        $result = DB::connection('mysql')->table($this->tabela)
                ->where($attribute.$value)
                ->where('empresa_id',$tenant)
                ->first();
        
        if($result && $result->{$this->coluna}== $this->colunaValor):
            return true;
        endif;
        
        return is_null($result);
                
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Já existe um cadastro com os dados informados!';
    }
}
