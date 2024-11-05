<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Parcelas;
use Exception;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function index()
    {
        $clientes = Clientes::all();
        $dados = Clientes::orderBy('nome', 'desc')->paginate(env('APP_PAGINATE'));
        return view('clientes.index', ['dados' => $dados, 'clientes' => $clientes]);
    }

    public function create()
    {
        $clientes  = Clientes::orderBy('nome')->paginate(env('APP_PAGINATE'));
        return view('clientes.create',  ['dados' => $clientes]);
    }

    public function edit(Clientes $clientes, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $clientes = Clientes::find($request->id);

        return view('clientes.edit', ['dados' => $clientes]);
    }

    public function detalhes(Clientes $clientes, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $clientes = Clientes::find($request->id);

        return view('clientes.detalhes', ['dados' => $clientes]);
    }

    public function update(Clientes $clientes, Request $request)
    {
        try {
            $data = collect([]);
            $data = $data->merge([
                "nome"      => $request->nome,
                "telefone"  => $request->telefone,
                "nascimento"  => $request->nascimento,
                "email"     => $request->email,
                "cep"  => $request->cep,
                "rua"  => $request->rua,
                "numero"  => $request->numero,
                "complemento"  => $request->complemento,
                "bairro"  => $request->bairro,
                "cidade"  => $request->cidade,
                "uf"  => $request->uf,
                "cpf_cnpj"  => $request->cpf_cnpj,
                "obs"  => $request->obs,

            ]);
            Clientes::find($request->id)->update($data->all());
            $clientes = Clientes::orderBy('nome')->paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            $dados = Clientes::find($request->id);
            return redirect()->route('clientes.edit')->with(compact('dados'))->with('message-success', 'Ocorreu um erro!');
        }
        return redirect()->route('clientes.index')->with(compact('clientes'))->with('message-success', 'Dados atualizados!');
    }

    public function store(Clientes $clientes, Request $request)
    {

        try {
            $clientes->nome = $request['nome'];
            $clientes->telefone = $request['telefone'];
            $clientes->nascimento = $request['nascimento'];
            $clientes->email = $request['email'];

            $clientes->tipo_cliente = $request['tipo_cliente'];
            $clientes->cpf_cnpj = $request['cpf_cnpj'];
            $clientes->rua = $request['rua'];
            $clientes->numero = $request['numero'];
            $clientes->bairro = $request['bairro'];
            $clientes->cep = $request['cep'];
            $clientes->cidade = $request['cidade'];
            $clientes->uf = $request['uf'];
            $clientes->obs = $request['obs'];
            $clientes->save();
            $clientes = Clientes::orderBy('nome')->paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            return redirect()->route('clientes.create')->with(compact('clientes'))->with('message-warning', 'Ocorreu um erro!');
        }
        return redirect()->route('clientes.index')->with(compact('clientes'))->with('message-success', 'Dados Salvos!');
    }

    public function storeRapido(Clientes $clientes, Request $request)
    {

        $clientes->nome = $request['nome'];
        $clientes->telefone = $request['telefone'];
        $clientes->email = $request['email'];
        $clientes->save();
        $clientes = Clientes::orderBy('id', 'desc')->paginate(env('APP_PAGINATE'));

        return redirect()->route('solicitacoes.create')->with(compact('clientes'))->with('message-success', 'Cliente Adicionado');
    }

    public function destroy(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        try {
            $clientes = Clientes::find($request->id)->delete();
            $clientes = Clientes::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            $clientes = Clientes::orderBy('nome')->paginate(env('APP_PAGINATE'));
            return redirect()->route('clientes.index')->with(compact('clientes'))->with('message-danger', 'Ocorreu um erro!');
        }
        $clientes = Clientes::orderBy('nome')->paginate(env('APP_PAGINATE'));
        return redirect()->route('clientes.index')->with(compact('clientes'))->with('message-success', 'Registro Excluido!');
    }

    public function pesquisa(Request $request)
    {
        $query = Clientes::query();
        $query = ($request->pesquisa != 'null') ? $query->where('nome', 'LIKE', '%' . $request->pesquisa . '%') : $query;
        $query = ($request->pesquisa != 'null') ? $query->Orwhere('telefone', 'LIKE', '%' . $request->pesquisa . '%') : $query;
        $query = $query->orderBy('id', 'desc');
        $dados = $query->paginate(env('APP_PAGINATE'));

        $clientes = Clientes::all();
        return view('clientes.index', ['dados' => $dados, 'clientes' => $clientes]);
    }
}
