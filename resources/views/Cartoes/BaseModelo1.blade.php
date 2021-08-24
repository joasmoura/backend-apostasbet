<style>
    .conteudo{border:0.5px solid #f2f2f2; width:100%;display: grid; margin-bottom: 10px;}
    .conteudo .frente{float:left; width:48%; padding:2px; border-right: 1px solid #999;}
    .conteudo .verso{float:left; width:48%; padding:2px;}

    .header{width:100%}
    .header .boxLogo{float:left; width:60px;}
    .header .dadosIgreja{float:left; text-align: center; padding-top:15px;}
    .header .dadosIgreja .nomeIgreja{font-size:7px;  font-weight: bold; padding:0; margin:0;}
    .header .dadosIgreja .enderecamento{font-size:7px;  padding:0; margin:0;}
    .header .dadosIgreja .cidadeTel{font-size:7px;  padding:0; margin:0;}

    .col-6{float:left; width:50%;}
    .col-12{float:left; width:100%;}
    .input{
        backgroud:{{(isset($style) && !empty($style['corFundoDados']) ? $style['corFundoDados'] : 'transparent' )}}
    }
</style>

@yield('styles')

<div class="conteudo">
    <div class="frente">
        <div class="header">
            <div class="boxLogo">
                @if($igreja->igr_logo)
                    <img class="logo" src="{{$igreja->imagem}}" width="50px"/>
                @endif
            </div>

            <div class="dadosIgreja">
                <p class="nomeIgreja">{{(isset($igreja) && !empty($igreja->igr_nome) ? strtoupper($igreja->igr_nome) : 'Nome da Igreja' )}}</p>
                <p class="enderecamento">
                    {{(isset($igreja) && !empty($igreja->igr_endereco) ? strtoupper($igreja->igr_endereco) : 'Endereço' )}},
                    {{(isset($igreja) && !empty($igreja->igr_numero) ? strtoupper($igreja->igr_numero) : '1234' )}},
                    {{(isset($igreja) && !empty($igreja->igr_bairro) ? 'BAIRRO '.strtoupper($igreja->igr_bairro) : '1234' )}},
                    {{(isset($igreja) && !empty($igreja->igr_cep) ? 'CEP '.strtoupper($igreja->igr_cep) : '000.000-00' )}}
                </p>
                <p class="cidadeTel">
                    {{(isset($igreja) && $igreja->cidade ? strtoupper($igreja->cidade->cd_nome) : '' )}}-
                    {{(isset($igreja) && $igreja->estado ? strtoupper($igreja->estado->uf_uf) : '' )}},
                    {{(isset($igreja) && $igreja->igr_celular ? strtoupper($igreja->igr_celular) : '' )}}
                </p>
            </div>
        </div>

        @yield('frente')
    </div>

    <div class="verso">
        @yield('verso')
    </div>
</div>
