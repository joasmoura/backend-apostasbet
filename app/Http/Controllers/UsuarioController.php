<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login($base, Request $request){
        $dados = $request->all();

        if(Auth::attempt(['username' => $dados['username'], 'password' => $dados['password']])){
            $user = auth()->user();

            return response()->json([
                'status' => true,
                'usuario' => $user,
                'authenticationToken' => $user->createToken($dados['username'])->accessToken
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'status' => false
            ],Response::HTTP_OK);
        }
    }

    public function limite(){
        $usuario = auth()->user();
        $limite = $usuario->limite_credito;

        return $limite;
    }

    public function index()
    {
        //
    }

    public function gerentes(){
        $usuario = auth()->user();
        $gerentes = User::with('regiao')->where('empresa_id',$usuario->empresa_id)->where('perfil','gerente')->paginate(10);
        return $gerentes;
    }

    public function gerentes_select(){
        $usuario = auth()->user();
        $gerentes = User::with('regiao')->where('empresa_id',$usuario->empresa_id)->where('perfil','gerente')->get();
        return $gerentes;
    }

    public function supervisores(){
        $usuario = auth()->user();

        if($usuario->perfil == 'gerente'){
            $supervisores = $usuario->supervisores_gerente()->with('regiao')->where('perfil','supervisor')->paginate(10);
        }else{
            $supervisores = User::with('regiao')->where('empresa_id',$usuario->empresa_id)->where('perfil','supervisor')->paginate(10);
        }
        return $supervisores;
    }

    public function supervisores_select(){
        $usuario = auth()->user();
        $gerentes = User::with('regiao')->where('empresa_id',$usuario->empresa_id)->where('perfil','supervisor')->get();
        return $gerentes;
    }

    public function cambistas(){
        $usuario = auth()->user();

        if($usuario->perfil == 'gerente'){
            $cambistas = $usuario->cambistas_gerente()->with('comissao','gerente')->where('perfil','cambista')->paginate(10);
        }elseif($usuario->perfil == 'supervisor'){
            $cambistas = $usuario->cambistas_supervisor()->with('comissao','gerente')->where('perfil','cambista')->paginate(10);
        }else{
            $cambistas = User::with('comissao','gerente')->where('empresa_id',$usuario->empresa_id)->where('perfil','cambista')->paginate(10);
        }
        return $cambistas;
    }

    public function cambistas_select(){
        $usuario = auth()->user();
        $cambista = User::with('comissao','gerente')->where('empresa_id',$usuario->empresa_id)->where('perfil','cambista')->get();
        return $cambista;
    }

    public function selectCambistas(){
        $usuario = auth()->user();
        $cambista = User::where('perfil','cambista')->where('empresa_id',$usuario->empresa_id)->get();
        return $cambista;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empresa = Empresa::where('db_host',$request->getHost())->first();
        $salvo = User::create([
            'name' => $request->nome,
            'perfil' => $request->perfil,
            'comissao_faturamento' => (isset($request->comissao_faturamento) ? $request->comissao_faturamento : null),
            'comissao_lucro' => (isset($request->comissao_lucro) ? $request->comissao_lucro : null),
            'regiao_id' => (isset($request->regiao) ? $request->regiao : null),
            'limite_credito' => (isset($request->limite_credito) ? $request->limite_credito : null),
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => ($request->email ? $request->email : null),
            'comissao_id' => (isset($request->comissao_id) ? $request->comissao_id : null),
            'supervisor_id' => (isset($request->supervisor_id) ? $request->supervisor_id : null),
            'gerente_id' => (isset($request->gerente_id) ? $request->gerente_id : null),
            'percentual_premio' => ($request->percentual_premio ? $request->percentual_premio : null),
            'telefone' => ($request->telefone ? $request->telefone : null),
            'empresa_id' => $empresa->id
        ]);

        if($salvo){
            if($request->regiaoSelecionada){
                $salvo->regioes()->attach($request->regiaoSelecionada);
            }

            return response()->json([
                'status' => true,
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'status' => false,
            ],Response::HTTP_OK);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('regioes')->find($id);
        if($user){
            return response()->json([
                'status' => true,
                'usuario' => $user
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'status' => false,
            ],Response::HTTP_OK);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $usuario = User::with('regioes')->find($id);

        if($usuario){
            $usuario->name = $request->nome;
            $usuario->perfil = $request->perfil;
            $usuario->comissao_faturamento = (isset($request->comissao_faturamento) ? $request->comissao_faturamento : null);
            $usuario->comissao_lucro = (isset($request->comissao_lucro) ? $request->comissao_lucro : null);
            $usuario->regiao_id = (isset($request->regiao) ? $request->regiao : null);
            $usuario->limite_credito = (isset($request->limite_credito) ? $request->limite_credito : null);
            $usuario->username = $request->username;

            if(!empty($request->password)){
                $usuario->password = Hash::make($request->password);
            }
            $usuario->email = ($request->email ? $request->email : null);
            $usuario->comissao_id = (isset($request->comissao_id) ? $request->comissao_id : null);
            $usuario->supervisor_id = (isset($request->supervisor_id) ? $request->supervisor_id : null);
            $usuario->gerente_id = (isset($request->gerente_id) ? $request->gerente_id : null);
            $usuario->percentual_premio = ($request->percentual_premio ? $request->percentual_premio : null);
            $usuario->telefone = ($request->telefone ? $request->telefone : null);

            $salvo = $usuario->save();

            if($salvo){

                if($request->regiaoSelecionada){
                    $usuario->regioes()->detach();
                    $usuario->regioes()->attach($request->regiaoSelecionada);
                }else{
                    $usuario->regioes()->detach();
                }

                return response()->json([
                    'status' => true,
                ],Response::HTTP_OK);
            }else{
                return response()->json([
                    'status' => false,
                ],Response::HTTP_OK);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
