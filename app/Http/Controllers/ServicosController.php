<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Servicos;
use Exception;
use Illuminate\Http\Request;

class ServicosController extends Controller
{
    public function index()
    {
        $dados = Servicos::paginate(env('APP_PAGINATE'));
        return view('servicos.index')->with(compact('dados'));
    }

    public function create()
    {
        $categorias = Categorias::all();

        return view('servicos.create')->with(compact('categorias'));
    }

    public function edit(Servicos $servicos, Request $request)
    {

        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $dados = Servicos::find($request->id);
        $categorias = Categorias::all();
        return view('servicos.edit')->with(compact('categorias', 'dados'));
    }

    public function update(Servicos $servicos, Request $request)
    {
        try {
            $data = collect([]);
            $data = $data->merge([
                "categoria_id"          => trim($request->categoria_id),
                "codigo"          => trim($request->codigo),
                "descricao"       => trim($request->descricao),
                "status"       => trim($request->status),
                "tempo_estimado"       => strtr($request->tempo_estimado, ',', '.'),
                "valor"       => strtr($request->valor, ',', '.'),
            ]);

            Servicos::find($request->id)->update($data->all());
        } catch (Exception $e) {
            session()->flash('message-warning', 'Occorreu um Erro');
        }
        $dados = Servicos::get();
        return redirect()->route('servicos.index')->with(compact('dados'))->with('message-success', 'Dados atualizados!');
    }


    public function store(Servicos $servicos, Request $request)
    {
        try {
            $descricao  = ($request['descricao'] != null) ? $request['descricao'] : 'NÃO DEFINIDO';
            $servicos->codigo =  $request['codigo'];
            $servicos->categoria_id = $request['categoria_id'];
            $servicos->status = $request['status'];
            $servicos->valor = (float)str_replace(",", ".", $request['valor']);
            $servicos->tempo_estimado = $request['tempo_estimado'];
            $servicos->descricao = $descricao;
            $servicos->save();
        } catch (Exception $e) {
            session()->flash('message-warning', 'Occorreu um Erro');
        }


        $dados = Servicos::get();
        return redirect()->route('servicos.index')->with(compact('dados'))->with('message-success', 'Dados Salvos!');;;
    }

    public function destroy(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        try {

            $servicos = Servicos::find($request->id)->delete();
        } catch (Exception $e) {
            session()->flash('message-warning', 'Erro ao excluir o servico, verifique se ele tem relacionamentos');
        }
        $dados = Servicos::get();
        return redirect()->route('servicos.index')->with(compact('dados'))->with('message-success', 'Dados excluidos!');
    }


    public function pesquisa(Request $request)
    {
        $servico = Servicos::where('codigo', $request->pesquisa)->first();
        $servico_id = ($servico) ? $servico->id : null;
        $query = Servicos::query();
        $query = ($servico_id != null) ? $query->where('id', $servico_id) : $query;
        $query = ($request->pesquisa != null) ? $query->orWhere('descricao', 'LIKE', '%' . $request->pesquisa . '%') : $query;
        $query = $query->orderBy('updated_at', 'desc');
        $dados = $query->paginate(env('APP_PAGINATE'));
        return view('servicos.index', ['dados' => $dados]);
    }
}
