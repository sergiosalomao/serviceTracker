<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\Financeiro\FormasPagamento;
use Exception;
use Illuminate\Http\Request;

class FormasPagamentoController extends Controller
{
    public function index()
    {
        return view('financeiro.formas-pagamento.index', ['dados' => FormasPagamento::paginate(env('APP_PAGINATE'))]);
    }

    public function create()
    {
        $formaspagamento  = FormasPagamento::all();
        return view('financeiro.formas-pagamento.create', ['dados' => $formaspagamento]);
    }

    public function edit(FormasPagamento $formaspagamento, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $formaspagamento = FormasPagamento::find($request->id);
        return view('financeiro.formas-pagamento.edit', ['dados' => $formaspagamento]);
    }

    public function update(FormasPagamento $formaspagamento, Request $request)
    {
        try {
            $data = collect([]);
            $data = $data->merge([
                "forma"          => trim($request->forma),
            ]);
            FormasPagamento::find($request->id)->update($data->all());
            $formaspagamento = FormasPagamento::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            $formaspagamento = FormasPagamento::find($request->id)->update($data->all());
            return view('financeiro.formas-pagamento.edit', ['dados' => $formaspagamento])->with('message', ['tipo' => 'error', 'texto' => 'Erro ao gravar']);
        }
        return view('financeiro.formas-pagamento.index', ['dados' => $formaspagamento])->with('message', ['tipo' => 'success', 'texto' => 'Registro alterado com sucesso!']);;
    }

    public function store(FormasPagamento $formaspagamento, Request $request)
    {
        try {
            $formaspagamento->forma = $request['forma'];
            $formaspagamento->save();
            $formaspagamento = FormasPagamento::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            return view('financeiro.formas-pagamento.create')->with('message', ['tipo' => 'error', 'texto' => 'Erro ao gravar']);
        }
        return view('financeiro.formas-pagamento.index', ['dados' => $formaspagamento])->with('message', ['tipo' => 'success', 'texto' => 'Registro salvo com sucesso!']);;
    }

    public function destroy(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        try {
            $formaspagamento = FormasPagamento::find($request->id)->delete();
            $formaspagamento = FormasPagamento::paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            report($e);
            $formaspagamento = FormasPagamento::paginate(env('APP_PAGINATE'));
            return view('financeiro.formas-pagamento.index', ['dados' => $formaspagamento])->with('message', ['tipo' => 'error', 'texto' => 'Este registro tem relacionamento']);;
        }
        return view('financeiro.formas-pagamento.index', ['dados' => $formaspagamento])->with('message', ['tipo' => 'success', 'texto' => 'Registro excluído com sucesso!']);;
    }
}
