<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\Financeiro\Contas;
use Exception;
use Illuminate\Http\Request;

class ContasController extends Controller
{
    public function index()
    {
        return view('financeiro.contas.index', ['dados' => Contas::paginate(env('APP_PAGINATE'))]);
    }

    public function create()
    {
        $contas  = Contas::all();
        return view('financeiro.contas.create', ['dados' => $contas]);
    }

    public function edit(Contas $contas, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $contas = Contas::find($request->id);

        return view('financeiro.contas.edit', ['dados' => $contas]);
    }

    public function update(Contas $contas, Request $request)
    {
        try {
            $data = collect([]);
            $data = $data->merge([
                "conta"          => trim($request->conta),
            ]);

            Contas::find($request->id)->update($data->all());
            $dados = Contas::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            return redirect()->back()->with('message-danger', 'Ocorreu um erro!');
        }

        return redirect()->back()->with(compact('dados'))->with('message-success', 'Dados Atualizados!');
    }

    public function store(Contas $contas, Request $request)
    {
        try {
            $contas->conta = $request['conta'];
            $contas->save();
            $dados = Contas::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            return redirect()->back()->with('message-danger', 'Ocorreu um erro!');
        }

        return redirect()->back()->with(compact('dados'))->with('message-success', 'Dados Salvos!');
    }

    public function destroy(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);

        try {
            $contas = Contas::find($request->id)->delete();
            $dados = Contas::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            report($e);
            $contas = Contas::paginate(env('APP_PAGINATE'));

            return redirect()->back()->with(['dados' => $contas]);
        }

        return redirect()->back()->with(compact('dados'))->with('message-success', 'Dados Excluidos!');
    }
}
