<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissao extends Model
{
    use HasFactory;

    protected $connection = "mysql";
    protected $table = 'permissoes';
    protected $fillable = ['perm_titulo','perm_nome'];

    public function niveis() {
        return $this->belongsToMany(Nivel::class);
    }

    public function pesquisarPermissao($form,$qtd) {
        $permissoes = $this->where(function($query)use($form){
           if(isset($form['perm_titulo'])):
               $query->where('perm_titulo','LIKE',"%{$form['perm_titulo']}%");
           endif;
        })->paginate($qtd);

        return $permissoes;
    }
}
