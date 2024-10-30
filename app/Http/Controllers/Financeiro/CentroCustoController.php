<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\Financeiro\Centros;
use Exception;
use Illuminate\Http\Request;

class CentroCustoController extends Controller
{
    public function index()
    {
        return view('financeiro.centros.index', ['dados' => Centros::paginate(env('APP_PAGINATE'))]);
    }

    public function create()
    {
        $centros  = Centros::all();
        return view('financeiro.centros.create', ['dados' => $centros]);
    }

    public function edit(Centros $centros, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $centros = Centros::find($request->id);

        return view('financeiro.centros.edit', ['dados' => $centros]);
    }

    public function update(Centros $centros, Request $request)
    {

        try {
            $data = collect([]);
            $data = $data->merge([
                "centro"          => trim($request->centro),
            ]);

            Centros::find($request->id)->update($data->all());
            $dados = Centros::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            return redirect()->back()->with('message-danger', 'Ocorreu um erro!');
        }
        return redirect()->back()->with(compact('dados'))->with('message-success', 'Dados Atualizados!');
    }

    public function store(Centros $centros, Request $request)
    {
        try {
            $centros->centro = $request['centro'];
            $centros->save();
            $dados = Centros::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            return redirect()->back()->with('message-danger', 'Ocorreu um erro!');
        }

        return redirect()->back()->with(compact('dados'))->with('message-success', 'Dados Salvos!');
    }

    public function destroy(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);

        try {
            $centros = Centros::find($request->id)->delete();
            $dados = Centros::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            return redirect()->back()->with('message-danger', 'Ocorreu um erro!');
        }
        return redirect()->back()->with(compact('dados'))->with('message-success', 'Dados Excluidos!');
    }
}
