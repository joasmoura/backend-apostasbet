<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;

    protected $connection = "mysql";
    protected $table = 'niveis';
    protected $fillable = ['nivel_nome','nivel_titulo'];

    public function permissoes() {
        return $this->belongsToMany(Permissao::class);
    }

    public function usuarios() {
        return $this->belongsToMany(User::class);
    }

    public function pesquisarNivel($form,$qtd) {
        $niveis = $this->where(function($query)use($form){
           if(isset($form['nivel_titulo'])):
               $query->where('nivel_titulo','LIKE',"%{$form['nivel_titulo']}%");
           endif;
        })->paginate($qtd);

        return $niveis;
    }
}
