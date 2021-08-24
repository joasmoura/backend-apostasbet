<?php

namespace App\Listeners;

use App\Events\AdesaoEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdesaoEventListener {

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AdesaoEvent  $event
     * @return void
     */
    public function handle($event) {
        
        $igreja = auth()->user()->empresa;
        $usuario = auth()->user()->niveis;
        
        $data = $igreja->adesoes->max('updated_at');
        $adesoes = $igreja->adesoes->where('updated_at',$data);
        
        if (empty($igreja->igr_nome) || empty($igreja->igr_cnpj) || empty($igreja->igr_endereco) ||
        empty($igreja->igr_numero) || empty($igreja->igr_bairro) || empty($igreja->igr_cep) ||
        empty($igreja->igr_complemento) || empty($igreja->igr_cidade) || empty($igreja->igr_uf) ||
        empty($igreja->igr_pais) || empty($igreja->igr_codcelular) || empty($igreja->igr_celular)):
            
            if($usuario->contains('nivel_nome','adm') || $usuario->contains('nivel_nome','sadmin') || $usuario->contains('nivel_nome','secretaria')):
                echo redirect()->route('igreja.index')->with('error','<div class="alert alert- alert-danger-bordered alert-lg square fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                            <i class="la la-exclamation-circle  mr-2"></i>
                                            <strong>Antes de seguir utilizando o sistema, faz-se necessário preencher alguns dados de sua Igreja</strong>
                                            <p class="pl-5">Antes de salvar certifique-se de que está tudo correto!</p>
                                        </div>');
            
            else:
                echo redirect()->route('painel.alerta');
            endif;
        elseif(!$adesoes->first() || $adesoes->first() && $adesoes->first()->ad_status == 'canceled' || $adesoes->first()->ad_status == 'ended'):
                if($usuario->contains('nivel_nome','adm') || $usuario->contains('nivel_nome','sadmin') || $usuario->contains('nivel_nome','secretaria')):
                    echo redirect()->route('planos.index')->with('error','<div class="alert alert- alert-danger-bordered alert-lg square fade show" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                                <i class="la la-exclamation-circle  mr-2"></i>
                                                <strong>Antes de seguir utilizando o sistema, faz-se necessário escolher o plano para sua Igreja</strong>
                                            </div>');
                else:
                    echo redirect()->route('painel.alerta');
                endif;
            elseif($adesoes->first() && $adesoes->first()->ad_status == 'unpaid'):
                if($usuario->contains('nivel_nome','adm') || $usuario->contains('nivel_nome','sadmin') || $usuario->contains('nivel_nome','secretaria')): 
                    if($adesoes->first()->ad_metodoPagamento == 'credit_card'): 
                        echo redirect('painel/adesao/index#trocarCartcao')->with('error','<div class="alert alert- alert-danger-bordered alert-lg square fade show" role="alert">
                                
                                <i class="la la-exclamation-circle  mr-2"></i>
                                <strong>Não conseguimos realizar a cobrança no seu cartão, por favor, altere o cartão para tentarmos realizar a operação!</strong>
                            </div>');
                    else:
                        echo redirect()->route('adesao.index')->with('error','<div class="alert alert-danger-bordered alert-lg square fade show" role="alert">
                                
                                <i class="la la-exclamation-circle  mr-2 text-white"></i>
                                <strong class="text-white">Após de algumas tentativas não identificamos o pagamento do boleto até o momento, por favor, efetue o pagamento e entre em contato com o suporte enviando confirmação!</strong>
                            </div>');
                    endif;
                else:
                     echo redirect()->route('painel.alerta');
                endif;
        endif;
           
        
    }

}
