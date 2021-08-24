<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComissoesAposta extends Model
{
    use HasFactory;
    protected $connection = "tenant";
    protected $table = 'comissoes_apostas';
    protected $fillable = ['gerente_id','aposta_id','valor'];

    public function aposta(){
        return $this->hasOne(Aposta::class,'id','aposta_id');
    }
}
