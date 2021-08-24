<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Empresa extends Model
{
    use HasFactory;
    protected $connection = "mysql";

    public static function boot () {
        parent::boot();
        self::creating(function($model){
            $model->uuid = (string) Uuid::generate(4);
        });
    }

    protected $fillable = [
        'igr_nome','igr_endereco','igr_complemento','igr_numero',
        'igr_bairro','igr_uf','igr_pais','igr_cidade','igr_cnpj',
        'igr_cep','igr_logo','igr_telefone',
        'igr_celular','igr_nome_responsavel',
        'igr_sobrenome_responsavel','igr_email_responsavel',
        'db_servidor','db_base','db_usuario','db_senha','db_host'];

    public function usuarios() {
        return $this->hasMany(User::class);
    }

    public function adesoes() {
        return $this->hasMany(Adesao::class);
    }

    public function getImagemAttribute(){
        return (!empty($this->igr_logo) ? (Storage::disk('companies')->exists(auth()->user()->empresa->uuid.'/'.$this->igr_logo) ? Storage::url('igrejas/'.auth()->user()->empresa->uuid.'/'.$this->igr_logo) : ''): '');
    }

    public function estado(){
        return $this->hasOne(Estado::class,'id','igr_uf');
    }

    public function cidade(){
        return $this->hasOne(Cidade::class,'id','igr_cidade');
    }
}
