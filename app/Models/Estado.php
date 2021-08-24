<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = "estado";

    public function cidades(){
        return $this->hasMany(Cidade::class,'cd_uf','id');
    }
}
