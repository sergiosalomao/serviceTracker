<?php

namespace App\Http\Controllers;

use App\Models\Fornecedores;
use Exception;
use Illuminate\Http\Request;

class FornecedoresController extends Controller
{
    public function index()
    {
        $fornecedores = Fornecedores::orderBy('updated_at', 'asc')->paginate(env('APP_PAGINATE'));
        return view('fornecedores.index', ['dados' => $fornecedores]);
    }

    public function create()
    {
        $fornecedores  = Fornecedores::orderBy('nome')->paginate(env('APP_PAGINATE'));
        return view('fornecedores.create',  ['dados' => $fornecedores]);
    }

    public function edit(Fornecedores $fornecedores, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $fornecedores = Fornecedores::find($request->id);

        return view('fornecedores.edit', ['dados' => $fornecedores]);
    }

    public function detalhes(Fornecedores $fornecedores, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $fornecedores = Fornecedores::find($request->id);

        return view('fornecedores.detalhes', ['dados' => $fornecedores]);
    }

    public function update(Fornecedores $fornecedores, Request $request)
    {
        try {
            $data = collect([]);
            $data = $data->merge([
                "nome"      => $request->nome,
                "telefone"  => $request->telefone,
                "email"     => $request->email,
                "endereco"  => $request->endereco,
                "cpf_cnpj"  => $request->cpf_cnpj,
                "status"  => $request->status,
            ]);
            Fornecedores::find($request->id)->update($data->all());
            $dados = Fornecedores::orderBy('nome')->paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            return redirect()->route('fornecedores.index')->with('message-danger', 'Ocorreu um erro!');
        }
        return redirect()->route('fornecedores.index')->with(compact('dados'))->with('message-success', 'Dados Atualizados!');
    }

    public function store(Fornecedores $fornecedores, Request $request)
    {
        try {
            $fornecedores->nome = $request['nome'];
            $fornecedores->telefone = $request['telefone'];
            $fornecedores->email = $request['email'];
            $fornecedores->status = $request['status'];
            $fornecedores->cpf_cnpj = $request['cpf_cnpj'];
            $fornecedores->endereco = $request['endereco'];
            $fornecedores->save();
            $dados = Fornecedores::orderBy('nome')->paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            return redirect()->route('fornecedores.index')->with('message-danger', 'Ocorreu um erro!');
        }
        return redirect()->route('fornecedores.index')->with(compact('dados'))->with('message-success', 'Dados Salvos!');
    }

    public function destroy(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        try {
            $fornecedores = Fornecedores::find($request->id)->delete();
            $dados = Fornecedores::orderBy('nome')->paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            return redirect()->route('fornecedores.index')->with('message-danger', 'Ocorreu um erro!');
        }
        return redirect()->route('fornecedores.index')->with(compact('dados'))->with('message-success', 'Dados Excluidos!');
    }

    public function pesquisa(Request $request)
    {
        $query = Fornecedores::query();
        $query = ($request->pesquisa != null) ? $query->where('nome', 'LIKE', '%' . $request->pesquisa . '%') : $query;
        $query = $query->orderBy('updated_at', 'desc');
        $dados = $query->paginate(env('APP_PAGINATE'));
        return view('fornecedores.index', ['dados' => $dados]);
    }
}
