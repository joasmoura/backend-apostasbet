<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscipuloFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {       
        return [
            'disc_congregacao_id' => 'required_with_all:disc_nome,disc_nascimento,disc_nacionalidade,disc_estadoNaturalidade,disc_naturalidade,disc_rg,disc_mae,disc_sexo',
            'disc_mae' => 'required_with_all:disc_nome,disc_nascimento,disc_nacionalidade,disc_estadoNaturalidade,disc_naturalidade,disc_rg,disc_sexo',
            'disc_naturalidade' => 'required_with_all:disc_nome,disc_nascimento,disc_nacionalidade,disc_estadoNaturalidade,disc_rg,disc_sexo',
            'disc_estadoNaturalidade' => 'required_with_all:disc_nome,disc_nascimento,disc_nacionalidade,disc_rg,disc_sexo',
            'disc_nacionalidade' => 'required_with_all:disc_nome,disc_nascimento,disc_rg,disc_sexo',
            'disc_nascimento' => 'required_with_all:disc_rg,disc_nome,disc_sexo',
            'disc_rg' => 'required_with_all:disc_nome,disc_sexo|unique:tenant.discipulos,disc_rg',
            'disc_sexo' => 'required_with:disc_nome',
            'disc_nome' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'disc_sexo.required_with' => 'Selecione o sexo do discipulo',
            'disc_nome.required' => 'Digite o nome do discipulo!',
            'disc_rg.unique' => 'Já existe um cadastro com o RG informado.',
            'disc_rg.required_with_all' => 'Digite o número do RG!',
            'disc_nascimento.required_with_all' => 'Digite a data de nascimento do discipulo!',
            'disc_naturalidade.required_with_all' => 'Informe a cidade que o discipulo nasceu!',
            'disc_nacionalidade.required_with_all' => 'Digite a nacionalidade do discipulo!',
            'disc_estadoNaturalidade.required_with_all' => 'Informe o estado que o discipulo nasceu!',
            'disc_mae.required_with_all' => 'Digite o nome da mãe do discipulo!',
            'disc_congregacao_id.required_with_all' => 'Selecione a Congregação do discipulo!',
        ];
    }
}
