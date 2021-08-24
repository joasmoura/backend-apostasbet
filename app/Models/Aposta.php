<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aposta extends Model
{
    use HasFactory;
    protected $connection = "tenant";
    protected $table = 'apostas';
    protected $fillable = ['horario_id','codigo','user_id','total','status','tel_apostador'];

    public function itens(){
        return $this->hasMany(ItensAposta::class,'aposta_id','id');
    }

    public function cambista(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function horario(){
        return $this->hasOne(Horarios_Extracao::class,'id','horario_id');
    }

    public function comissao_aposta(){
        return $this->hasMany(ComissoesAposta::class,'aposta_id','id');
    }

    public function comissao_gerente(){
        return $this->hasMany(ComissoesGerente::class,'aposta_id','id');
    }

}
