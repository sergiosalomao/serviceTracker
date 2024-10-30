<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pacientes;
use App\Models\Profissionais;
use App\Models\User;
use App\Models\Usuarios;
use Doctrine\Common\Lexer\Token as LexerToken;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\TokenGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Str;
use Laravel\Sanctum\Events\TokenAuthenticated;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Laravel\Passport\HasApiTokens;
use PhpParser\Parser\Tokens;

class AuthController extends Controller
{

    public function auth(Request $request)
    {
        return view("auth.login");
    }

    public function login(Request $request)
    {

        if (Auth::attempt(['cpf' => $request->cpf, 'password' => $request->password])) {
            $user = $request->user();

            $usuario = User::where('cpf', $request->cpf)->get()->last();

            //  $profissional = Profissionais::with('especialidade')->where('cpf', $request->cpf)->get()->last();

            /*   if (isset($profissional->id))
                $user['profissional_id'] = $profissional->id; */
            if (isset($usuario->id))
                $user['usuario'] = $usuario->id;

            $token = $user->api_token;


            //    $token = $user->createToken($request->cpf)->accessToken; // gera um novo token
            $data =  [
                'message' => 'Usuario Logado.',
                'access_token' => $token,
                'token_type' => 'API_TOKEN',
                'user' => $user,
                'profissional' => $usuario,
            ];
            //   return response()->json($data, 200);
            return view('home');
        } else
            $data =  [
                'message' => 'Senha invalida ou usuario nao encontrado.',

            ];
        return response()->json($data, 200);
    }

    public function me()
    {
        return response()->json(Auth::guard()->user(), 200);
    }


    public function register(Request $request)
    {
        $user = User::create([
            'cpf'    => $request->cpf,
            'name'    => $request->name,
            'email'    => $request->email,
            'tipo'    => $request->tipo,
            'status'    => 'ATIVO',
            'password' => bcrypt($request->password),
            'api_token' => Str::random(60),
        ]);
        $token = $user->api_token;
        $data =  [
            'message' => 'Usuario Registrado.',
            'access_token' => $token,
            'token_type' => 'API_TOKEN',
            'user' => $user,
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $param = $request->all();
        try {
            $dados = User::findOrFail($id);
            $dados->update($param);
        } catch (Exception $e) {
            return response('Erro:' . $e->getMessage(), 500);
        }
        return response()->json(['Dados atualizados', 'Dados' => $dados], 200);
    }


    public function atualizaToken($request)
    {
        try {
            $data = collect([]);
            $data = $data->merge([
                'api_token' => Str::random(60),
            ]);
            User::find($request->id)->update($data->all());
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao deslogar'], 500);
        }
        return response()->json(['message' => 'Usuario deslogado'], 200);
    }


    public function logout(Request $request)
    {
        return $this->atualizaToken($request);
    }
}
