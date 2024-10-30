<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\Financeiro\Fluxos;
use Exception;
use Illuminate\Http\Request;

class FluxosController extends Controller
{
    public function index()
    {
        return view('financeiro.fluxos.index', ['dados' => Fluxos::paginate(env('APP_PAGINATE'))]);
    }

    public function create()
    {
        $fluxos  = Fluxos::all();
        return view('financeiro.fluxos.create', ['dados' => $fluxos]);
    }

    public function edit(Fluxos $fluxos, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $fluxos = Fluxos::find($request->id);

        return view('financeiro.fluxos.edit', ['dados' => $fluxos]);
    }

    public function update(Fluxos $fluxos, Request $request)
    {
        try {
            $data = collect([]);
            $data = $data->merge([
                "tipo"          => trim($request->tipo),
                "fluxo"          => trim($request->fluxo),
            ]);
            Fluxos::find($request->id)->update($data->all());
            $dados = Fluxos::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            return redirect()->back()->with('message-danger', 'Ocorreu um erro!');
        }
        
        return redirect()->back()->with(compact('dados'))->with('message-success', 'Dados Atualizados!');
    }

    public function store(Fluxos $fluxos, Request $request)
    {
        try {
            $fluxos->tipo = $request['tipo'];
            $fluxos->fluxo = $request['fluxo'];
            $fluxos->save();
            $dados = Fluxos::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            return redirect()->back()->with('message-danger', 'Ocorreu um erro!');
        }
        
        return redirect()->back()->with(compact('dados'))->with('message-success', 'Dados Salvos!');
    }

    public function destroy(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        try {
            $fluxos = Fluxos::find($request->id)->delete();
            $dados = Fluxos::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            return redirect()->back()->with('message-danger', 'Ocorreu um erro!');
        }
        
        return redirect()->back()->with(compact('dados'))->with('message-success', 'Dados Atualizados!');
    }

    public function retornaTipo($fluxoId)
    {
        $fluxo = Fluxos::where('id', $fluxoId)->get();
        return $fluxo[0]->tipo;
    }
}
