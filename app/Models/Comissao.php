<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comissao extends Model
{
    use HasFactory;
    protected $connection = "tenant";
    protected $table = 'comissoes';
    protected $fillable = ['nome','regiao_id','valor'];
}
