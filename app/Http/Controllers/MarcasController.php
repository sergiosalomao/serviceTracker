<?php

namespace App\Http\Controllers;

use App\Models\Marcas;
use Exception;
use Illuminate\Http\Request;

class MarcasController extends Controller
{
    public function index()
    {
        $dados = Marcas::paginate(env('APP_PAGINATE'));
        return view('marcas.index')->with(compact('dados'));
    }

    public function create()
    {
        return view('marcas.create');
    }

    public function edit(Marcas $marcas, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $marcas = Marcas::find($request->id);

        return view('marcas.edit', ['dados' => $marcas]);
    }

    public function update(Marcas $marcas, Request $request)
    {

        $data = collect([]);
        $data = $data->merge([
            "marca"       => $request->marca,
        ]);
        try {
            Marcas::find($request->id)->update($data->all());
        } catch (Exception $e) {
            return redirect()->route('marcas.index')->with(compact('marcas'))->with('message-danger', 'Ocorreu um erro!');
        }
        $dados = Marcas::paginate(env('APP_PAGINATE'));
        return redirect()->route('marcas.index')->with(compact('marcas'))->with('message-success', 'Dados Atualizados!');

    }

    public function store(Marcas $marcas, Request $request)
    {
        try {
            $marcas->marca = $request['marca'];
            $marcas->save();
        } catch (Exception $e) {
            return redirect()->route('marcas.index')->with(compact('marcas'))->with('message-danger', 'Ocorreu um erro!');
        }
        $dados = Marcas::paginate(env('APP_PAGINATE'));
        return redirect()->route('marcas.index')->with(compact('marcas'))->with('message-success', 'Dados Salvos!');
    }

    public function destroy(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        try {
            $marcas = Marcas::find($request->id)->delete();
        } catch (Exception $e) {
            return redirect()->route('marcas.index')->with(compact('marcas'))->with('message-danger', 'Ocorreu um erro!');
        }
        
        $dados = Marcas::paginate(env('APP_PAGINATE'));
        return redirect()->route('marcas.index')->with(compact('marcas'))->with('message-success', 'Dados excluidos!');
    }

    public function pesquisa(Request $request)
    {
        $query = Marcas::query();
        $query = ($request->pesquisa != null) ? $query->where('marca', 'LIKE', '%' . $request->pesquisa . '%') : $query;
        $query = $query->orderBy('updated_at', 'desc');
        $dados = $query->paginate(env('APP_PAGINATE'));
        return view('marcas.index', ['dados' => $dados]);
    }
}
