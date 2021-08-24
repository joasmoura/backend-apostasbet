<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,HasFactory, Notifiable;
    protected $connection = "mysql";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','sobrenome','empresa_id', 'email', 'password',
        'username',
        'perfil',
        'comissao_faturamento',
        'comissao_lucro',
        'regiao_id',
        'limite_credito',
        'comissao_id',
        'supervisor_id',
        'gerente_id',
        'telefone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function empresa() {
        return $this->belongsTo(Empresa::class);
    }

    public function niveis() {
        return $this->belongsToMany(Nivel::class);
    }

    public function pesquisarUsuarios($form,$qtd) {
        $igreja = auth()->user()->empresa;

//        $sadmin = $igreja->usuarios()->with(['niveis' => function($query){
//            $query->where('nivel_nome','sadmin');
//        }])->first();


        $usuarios = $igreja->usuarios()->where(function($query)use($form){
           if(isset($form['nome'])):
               $query->where('name','LIKE',"%{$form['nome']}%");
           endif;

//           if(auth()->user()->niveis()->first()->nivel_nome != 'sadmin' && $sadmin->id):
//               $query->whereNotIn('id',[$sadmin->id]);
//           endif;

        })->paginate($qtd);
        return $usuarios;
    }

    public function hasPermission(Permissao $permissao) {
        return $this->hasAnyNiveis($permissao->niveis);
    }

    public function hasAnyNiveis($niveis) {
        if(is_array($niveis) || is_object($niveis)):
                return !! $niveis->intersect($this->niveis)->count();
        endif;

        return $this->niveis->contains('nivel_nome',$niveis);
    }

    public function regioes(){
        return $this->belongsToMany(Regiao::class);
    }

    public function regiao(){
        return $this->hasOne(Regiao::class,'id','regiao_id');
    }

    public function comissao(){
        return $this->hasOne(Comissao::class,'id','comissao_id');
    }

    public function gerente(){
        return $this->hasOne(User::class,'id','gerente_id');
    }

    public function apostas(){
        return $this->hasMany(Aposta::class,'user_id','id');
    }

    public function movimentacoes(){
        return $this->hasMany(Movimentacao::class,'user_id','id');
    }

    public function cambistas_gerente(){
        return $this->hasMany(User::class, 'gerente_id', 'id');
    }

    public function cambistas_supervisor(){
        return $this->hasMany(User::class, 'supervisor_id', 'id');
    }

    public function supervisores_gerente(){
        return $this->hasMany(User::class, 'gerente_id', 'id');
    }

}
