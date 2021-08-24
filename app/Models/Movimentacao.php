<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    use HasFactory;
    protected $connection = "tenant";
    protected $table = 'movimentacoes';
    protected $fillable = ['user_id','descricao','tipo','data','valor'];

    public function usuario(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
