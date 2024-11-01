<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Cobrancas;
use App\Models\Estoque;
use App\Models\Financeiro\FormasPagamento;
use App\Models\Financeiro\Movimentos;
use App\Models\ItensSolicitacoes;
use App\Models\Parcelas;
use App\Models\Servicos;
use App\Models\Solicitacoes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Decimal;

class SolicitacoesController extends Controller
{
    public function index()
    {
        $clientes = Clientes::all();

        $total = Solicitacoes::where('status', '!=', 'CANCELADA')->sum('valor');
        $desconto = 0; //Solicitacoes::where('status', '!=', 'CANCELADA')->sum('desconto');
        $entradas = 0; //Solicitacoes::where('status', '!=', 'CANCELADA')->sum('entrada');
        $saldo_devedor = 0; //Solicitacoes::where('status', '!=', 'CANCELADA')->sum(DB::raw('valor - desconto-entrada'));
        $pago = 0; //Parcelas::where('status', 'PAGA')->sum('valor_pago');

        $dados = Solicitacoes::where('status', '!=', 'CANCELADA')->orderby('data_solicitacao', 'desc')->orderBy('status', 'asc')->paginate(env('APP_PAGINATE'));
        return view('solicitacoes.index', ['clientes' => $clientes, 'dados' => $dados, 'total' => $total, 'pago' => $pago, 'descontos' => $desconto, 'devedor' => $saldo_devedor, 'entradas' => $entradas]);
    }

    public function create()
    {
        $servicos = Servicos::all();
        $clientes = Clientes::all();
        $itenssolicitacoes = ItensSolicitacoes::all();
        return view('solicitacoes.create')->with(compact('servicos', 'itenssolicitacoes', 'clientes'));
    }

    public function edit(Solicitacoes $solicitacoes, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $solicitacoes = Solicitacoes::find($request->id);
        $formaspagamento = FormasPagamento::all();
        return view('solicitacoes.edit', ['dados' => $solicitacoes, 'formaspagamento' => $formaspagamento]);
    }

    public function update(Solicitacoes $solicitacoes, Request $request)
    {
//dd($request);
        $datainicio =  converte_data($request->data_solicitacao);

        $solicitacao = Solicitacoes::find($request->id);
        $dataSolicitacao = collect([]);

        $dataSolicitacao = $dataSolicitacao->merge([
            "data_solicitacao"       => $datainicio,
            "valor"       => (floatval($request->valor)),
            "entrada"       => (floatval($request->entrada)),
            "desconto"       => (floatval($request->desconto)),
            "status"       => $request['status'],
        ]);
        Solicitacoes::find($request->id)->update($dataSolicitacao->all());

        $dados = Solicitacoes::all();
        return redirect()->route('solicitacoes.index')->with(compact('dados'));
    }


    public function store(Solicitacoes $solicitacoes, Request $request)
    {
        $dt_inicio = Carbon::now();
        $dt_inicio->format('Y-m-d h:i:s');
        if (!$request->cliente_id)
            return redirect()->route('solicitacoes.create')->with('message', ['tipo' => 'error', 'texto' => 'Cliente não informado']);

        $solicitacoes->cliente_id = $request['cliente_id'];
        $solicitacoes->data_solicitacao = $dt_inicio;
        $solicitacoes->save();
        $dados = Solicitacoes::paginate(env('APP_PAGINATE'));

        return redirect()->route('carrinho.index', ['id' => $solicitacoes['id']])->with(compact('dados'));
    }

    public function destroy(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $solicitacoes = Solicitacoes::find($request->id)->delete();
        $dados = Solicitacoes::paginate(env('APP_PAGINATE'));
        return redirect()->route('solicitacoes.index')->with(compact('dados'));
    }

    public function carrinho()
    {
        $dados = Solicitacoes::paginate(env('APP_PAGINATE'));
        return view('solicitacoes.index')->with(compact('dados'));
    }

    public function pagamento(Solicitacoes $solicitacoes, Request $request)
    {

        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $solicitacoes = Solicitacoes::find($request->id);
        $valor = $request->valor;
        return view('solicitacoes.pagamento', ['dados' => $solicitacoes, 'valor' => $valor]);
    }

    public function cancela(Solicitacoes $solicitacoes, Request $request)
    {

        /* Exclui itens do carrinho */
        if (!$request->id) throw new \Exception("Erro ao cancelar", 1);
        ItensSolicitacoes::where('solicitacao_id', '=', $request->id)->delete();

        //atualiza status de solicitacao
        $dataSolicitacao = collect([]);
        $dataSolicitacao = $dataSolicitacao->merge([
            "status"       => 'CANCELADA',
        ]);
        Solicitacoes::find($request->id)->update($dataSolicitacao->all());


        $dados = Solicitacoes::paginate(env('APP_PAGINATE'));
        return redirect()->route('solicitacoes.index')->with(compact('dados'));
    }

    public function finalizar(Solicitacoes $solicitacoes, Request $request)
    {
        $dt = Carbon::now();
        $dt->format('Y-m-d h:i:s');
        //atualiza status de solicitacao
        $dataSolicitacao = collect([]);
        $dataSolicitacao = $dataSolicitacao->merge([
            "status"       => 'CONCLUIDA',
            "data_final"       => $dt,
        ]);
        Solicitacoes::find($request->id)->update($dataSolicitacao->all());


        $dados = Solicitacoes::paginate(env('APP_PAGINATE'));
        return redirect()->route('solicitacoes.index')->with(compact('dados'));
    }


    public function pesquisa(Request $request)
    {
        $clientes = Clientes::all();

        #Total
        $query = Solicitacoes::query();
        $query = ($request->codigo != null) ? $query->where('id', $request->codigo) : $query;
        $query = ($request->mes != null) ? $query->whereMonth('data_solicitacao', $request->mes) : $query;
        $query = ($request->status != null) ? $query->where('status', $request->status) : $query;
        $query = ($request->pesquisa != null) ? $query->where('cliente_id', $request->pesquisa) : $query;
        $query->where('status', '!=', 'CANCELADA');
        $total = $query->sum('valor');

        #Desconto
        $query = Solicitacoes::query();
        $query = ($request->codigo != null) ? $query->where('id', $request->codigo) : $query;
        $query = ($request->mes != null) ? $query->whereMonth('data_solicitacao', $request->mes) : $query;
        $query = ($request->status != null) ? $query->where('status', $request->status) : $query;
        $query = ($request->pesquisa != null) ? $query->where('cliente_id', $request->pesquisa) : $query;
        $query->where('status', '!=', 'CANCELADA');
        $desconto = 0; //$query->sum('desconto');

        #Entrada
        $query = Solicitacoes::query();
        $query = ($request->codigo != null) ? $query->where('id', $request->codigo) : $query;
        $query = ($request->mes != null) ? $query->whereMonth('data_solicitacao', $request->mes) : $query;
        $query = ($request->status != null) ? $query->where('status', $request->status) : $query;
        $query = ($request->pesquisa != null) ? $query->where('cliente_id', $request->pesquisa) : $query;
        $query->where('status', '!=', 'CANCELADA');
        $entradas = 0; //$query->sum('entrada');

        #saldo Devedor
        $query = Solicitacoes::query();
        $query = ($request->codigo != null) ? $query->where('id', $request->codigo) : $query;
        $query = ($request->mes != null) ? $query->whereMonth('data_solicitacao', $request->mes) : $query;
        $query = ($request->status != null) ? $query->where('status', $request->status) : $query;
        $query = ($request->pesquisa != null) ? $query->where('cliente_id', $request->pesquisa) : $query;
        $query->where('status', '!=', 'CANCELADA');
        $saldo_devedor = 0; //$query->sum(DB::raw('valor - desconto - entrada'));


        $query = Solicitacoes::query();
        $query = ($request->codigo != null) ? $query->where('id', $request->codigo) : $query;
        $query = ($request->mes != null) ? $query->whereMonth('data_solicitacao', $request->mes) : $query;
        $query = ($request->status != null) ? $query->where('status', $request->status) : $query;
        $query = ($request->pesquisa != null) ? $query->where('cliente_id', $request->pesquisa) : $query;
        $query->where('status', '!=', 'CANCELADA');
        $query = $query->orderBy('data_solicitacao', 'desc');
        $dados = $query->paginate(env('APP_PAGINATE'));

        $pago = 0; //


        return view('solicitacoes.index', ['clientes' => $clientes, 'dados' => $dados, 'total' => $total, 'pago' => $pago, 'descontos' => $desconto, 'devedor' => $saldo_devedor, 'entradas' => $entradas]);
    }
}
