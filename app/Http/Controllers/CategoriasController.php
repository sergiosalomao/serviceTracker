<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Clientes;
use Exception;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function index()
    {
        return view('categorias.index', ['dados' => Categorias::paginate(env('APP_PAGINATE'))]);
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function edit(Categorias $categoria, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $dados = Categorias::find($request->id);
        return view('categorias.edit')->with(compact('dados'));
    }

    public function update(Categorias $categoria, Request $request)
    {
        try {
            $data = collect([]);
            $data = $data->merge([
                "categoria"       => $request->categoria,

            ]);
            Categorias::find($request->id)->update($data->all());
        } catch (Exception $e) {
            session()->flash('message-warning', 'Occorreu um Erro');
        }
        $dados = Categorias::get();
        return redirect()->route('categorias.index')->with(compact('dados'))->with('message-success', 'Dados Atualizados!');
    }

    public function store(Categorias $categoria, Request $request)
    {
        try {
            $categoria->categoria = $request['categoria'];
            $categoria->save();
        } catch (Exception $e) {
            session()->flash('message-warning', 'Occorreu um Erro');
        }
        $dados = Categorias::get();
        return redirect()->route('categorias.index')->with(compact('dados'))->with('message-success', 'Dados Salvos!');
    }

    public function destroy(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        try {
            $categoria = Categorias::find($request->id)->delete();
        } catch (Exception $e) {
            session()->flash('message-warning', 'Occorreu um Erro');
        }
        $dados = Categorias::get();
        return redirect()->route('categorias.index')->with(compact('dados'))->with('message-success', 'Dados Excluidos!');
    }

    public function pesquisa(Request $request)
    {
        $query = Categorias::query();
        $query = ($request->pesquisa != null) ? $query->where('categoria', 'LIKE', '%' . $request->pesquisa . '%') : $query;
        /*     $query = ($request->cliente_id != null) ? $query->where('cliente_id', $request->cliente_id) : $query;
            $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('vencimento', [$de, $ate]) : $query; */
        $query = $query->orderBy('id', 'desc');
        $dados = $query->paginate(env('APP_PAGINATE'));
        return view('categorias.index', ['dados' => $dados]);
    }
}
