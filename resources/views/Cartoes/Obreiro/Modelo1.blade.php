@extends('Cartoes.BaseModelo1')

@section('frente')
    <div class="nomeFuncao">
        <h3>{{$obreiro->funcao->nome}}</h3>
    </div>

    <div class="boxFrente">
        <div class="dados">

            <div class="form">
                <span class="tituloInput">NOME</span>
                <div class="col-12 input">
                    {{$discipulo->disc_nome}}
                </div>
            </div>

        </div>

        <div class="boxFoto">
            foto
        </div>
    </div>
@stop

@section('verso')
@stop

@section('styles')
<style>
    .dadosIgreja{
        color:{{(!empty($style['corNomeIgreja']) ? $style['corNomeIgreja'] : '#000')}};
    }

    .boxFrente .dados{
        float:left;
        width:70%;
        background: #f2f2f2;
    }

    .boxFrente .boxFoto{
        float:left;
        background: #333;
    }

    .nomeFuncao{
        font-size:10px;
        color:{{(!empty($style['corTextoDados']) ? $style['corTextoDados'] : '#999')}};
        text-align:center;
        margin:0;
        padding:0;
    }

    @if($opcao->urlImagem($style['srcImagem']))
        .conteudo{
            background-image:url({{$opcao->urlImagem($style['srcImagem'])}});
            background-size:100%;
        }
    @endif
</style>
@stop
