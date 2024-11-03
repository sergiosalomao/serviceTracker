<?php

namespace App\Http\Controllers;

use App\Models\ItensSolicitacoes;
use App\Models\Servicos;
use Illuminate\Http\Request;

class ItensSolicitacoesController extends Controller
{
    public function index(Request $request)
    {
        $dados = ItensSolicitacoes::with(['servico'])->where('solicitacao_id', '=', $request->id)->paginate(env('APP_PAGINATE'));
        return view('carrinho.index', ['id' => $request->id])->with(compact('dados'));
    }

    public function create()
    {
        $servicos = Servicos::where('status', '=', 'SIM')->get();
        return view('carrinho.create')->with(compact('servicos'));;
    }

    public function edit(ItensSolicitacoes $itensSolicitacoes, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $itensSolicitacoes = ItensSolicitacoes::find($request->id);
        return view('carrinho.edit', ['dados' => $itensSolicitacoes]);
    }

    public function store(ItensSolicitacoes $itensSolicitacoes, Request $request)
    {
        if (!$request->servico_id || $request->qtd == null)
            return redirect()->route('carrinho.index', ['id' => $request->solicitacao_id])->with('message', ['tipo' => 'error', 'texto' => 'Serviço não informado']);
        $itensSolicitacoes->solicitacao_id = $request['solicitacao_id'];
        $itensSolicitacoes->servico_id = $request['servico_id'];
        $itensSolicitacoes->qtd = $request['qtd'];
        $itensSolicitacoes->save();

        #recalcula 
        $itens = ItensSolicitacoes::where('solicitacao_id', '=', $request['solicitacao_id'])->get();
        $totalAtualizado = 0;
        foreach ($itens as $item) {
            $totalAtualizado = $totalAtualizado + ($item['servico']['valor'] * $item->qtd);
        }


        $dados = ItensSolicitacoes::with(['servico'])->paginate(env('APP_PAGINATE'));

        return redirect()->route('carrinho.index', ['id' => $itensSolicitacoes['solicitacao_id']])->with(compact('dados'));
    }

    public function destroy(Request $request)
    {
        $item = ItensSolicitacoes::find($request->id);

        #deleta item
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $itensSolicitacoes = ItensSolicitacoes::find($request->id)->delete();

        $dados = ItensSolicitacoes::with(['servico'])->where('solicitacao_id', '=', $request->venda_id)->paginate(env('APP_PAGINATE'));
        return redirect()->route('carrinho.index', ['id' => $request->venda_id])->with(compact('dados'));
    }

    public function limpa(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $itensSolicitacoes = ItensSolicitacoes::where('solicitacao_id', '=', $request->id)->delete();
        $dados = ItensSolicitacoes::with(['servico'])->where('solicitacao_id', '=', $request->venda_id)->paginate(env('APP_PAGINATE'));
        return redirect()->route('carrinho.index', ['id' => $request->id])->with(compact('dados'));
    }
}
