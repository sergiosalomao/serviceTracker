<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Cobranca;
use App\Models\Cobrancas;
use App\Models\Estoque;
use App\Models\Financeiro\FormasPagamento;
use App\Models\Financeiro\Movimentos;
use App\Models\ItensSolicitacoes;
use App\Models\Pagamento;
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
        $dados = Solicitacoes::where('status', '!=', 'teste')->orderby('data_solicitacao', 'asc')->orderBy('id', 'asc')->orderBy('status', 'asc')->paginate(env('APP_PAGINATE'));
        $dashboard = $this->atualizaDashboard();
        return view('solicitacoes.index', ['clientes' => $clientes, 'dados' => $dados,'dashboard'=>$dashboard]);
    }

    public function atualizaDashboard(){
        $solicitacoes = Solicitacoes::all();
        $dashboard['totalsolicitacoes'] = count($solicitacoes);

        $solicitacoes = Solicitacoes::where('status','AGUARDANDO APROVAÇÃO')->get();
        $dashboard['aguardando'] = count($solicitacoes);

        $solicitacoes = Solicitacoes::where('status','EM ANDAMENTO')->get();
        $dashboard['andamento'] = count($solicitacoes);

        $solicitacoes = Solicitacoes::where('status','CONCLUIDA')->get();
        $dashboard['concluida'] = count($solicitacoes);

        $solicitacoes = Solicitacoes::where('status','CANCELADA')->get();
        $dashboard['cancelada'] = count($solicitacoes);





        $servicosConcluidos = Solicitacoes::where('status', 'CONCLUIDA')->get();
        $totalDuracao = 0;
        $quantidadeServicos = $servicosConcluidos->count();
        foreach ($servicosConcluidos as $servico) {
            $dataInicio = Carbon::parse($servico->data_solicitacao);
            $dataConclusao = Carbon::parse($servico->data_final);
            $duracao = $dataInicio->diffInHours($dataConclusao);
            $totalDuracao += $duracao;
        }
      
        
        if ($quantidadeServicos > 0) {
            $tempoMedioEntrega = $totalDuracao / $quantidadeServicos;
        } else {
            $tempoMedioEntrega = 0; // Evita divisão por zero
        }
        
        $dashboard['media'] = $tempoMedioEntrega;  
        


       
        return $dashboard;
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

    public function update(Solicitacoes $solicitacoes, Request $request, Cobranca $cobranca)
    {
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
        $this->calcularDataPrevista($request->id);
        // apaga todos os pagamentos
        $cobrancas = Cobranca::where('solicitacao_id', $request->id)->first();

        // apaga todas as cobrancas
        if ($cobrancas)
            Cobranca::where('id', $cobrancas->id)->delete();



        //gera cobranca
        $cobranca = new Cobranca();
        $cobranca->solicitacao_id = $request->id;
        $cobranca->valor_total = $request->valor;
        $cobranca->entrada = $request->entrada;
        $cobranca->desconto = $request->desconto;
        $cobranca->data_vencimento = $datainicio;
        $cobranca->forma_pagamento = $request->forma_pagamento;
        $cobranca->parcelas = $request->parcelas; // Número de parcelas
        $cobranca->save();


        // Gerar as parcelas
        $valor = floatval($request->valor);
        $entrada = floatval($request->entrada);
        $desconto = floatval($request->desconto);
        $valorPorParcela = ($valor - ($entrada + $desconto)) / $request->parcelas;
        for ($i = 1; $i <= $request->parcelas; $i++) {
            Pagamento::create([
                'cobranca_id' => $cobranca->id,
                'valor' => $valorPorParcela,
                'data_vencimento' => now()->addMonths($i), // Ajustar a data de vencimento de cada parcela
                'status' => 'PENDENTE'
            ]);
        }

        $dados = Solicitacoes::all();
        return redirect()->route('solicitacoes.index')->with(compact('dados'))->with('message-success', 'Solicitação Criada com sucesso!');;
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
        $this->calcularDataPrevista();


        $dados = Solicitacoes::paginate(env('APP_PAGINATE'));
        return redirect()->route('carrinho.index', ['id' => $solicitacoes['id']])->with(compact('dados'));;
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
        $formaspagamento = FormasPagamento::all();
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $solicitacoes = Solicitacoes::find($request->id);
        $valor = $request->valor;
        return view('solicitacoes.pagamento', ['dados' => $solicitacoes, 'valor' => $valor,'formaspagamento'=>$formaspagamento]);
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


        //atualiza status da cobranca
        $dataSolicitacao = collect([]);
        $dataSolicitacao = $dataSolicitacao->merge([
            "status"       => 'CANCELADA',
        ]);
        Cobranca::where('solicitacao_id', $request->id)->update($dataSolicitacao->all());

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
        $query = Solicitacoes::query();
        $query = ($request->codigo != null) ? $query->where('id', $request->codigo) : $query;
        $query = ($request->mes != null) ? $query->whereMonth('data_solicitacao', $request->mes) : $query;
        $query = ($request->status != null) ? $query->where('status', $request->status) : $query;
        $query = ($request->pesquisa != null) ? $query->where('cliente_id', $request->pesquisa) : $query;
        $query->where('status', '!=', 'CANCELADA');
        $query = $query->orderBy('data_solicitacao', 'desc');
        $dados = $query->paginate(env('APP_PAGINATE'));

        $dashboard = $this->atualizaDashboard();
        return view('solicitacoes.index', ['clientes' => $clientes, 'dados' => $dados,'dashboard'=>$dashboard]);

    }

   

    private function calcularDataPrevista()
    {
        // Obter todas as solicitações em andamento
        $solicitacoes = Solicitacoes::where('status', 'EM ANDAMENTO')->get();

        foreach ($solicitacoes as $solicitacao) {
            // Inicializar o tempo total em minutos
            $tempoTotal = 0;

            // Obter todos os itens da solicitação
            $itensSolicitacao = ItensSolicitacoes::where('solicitacao_id', $solicitacao->id)->get();

            // Somar o tempo estimado de cada item
            foreach ($itensSolicitacao as $item) {
                $tempoTotal += ($item['servico']['tempo_estimado'] * $item->qtd);
            }

            // Verificar a última solicitação anterior
            $ultimaSolicitacao = Solicitacoes::where('id', '<', $solicitacao->id)
                ->orderBy('id', 'desc')
                ->first();

            // Definir a data de referência
            if ($ultimaSolicitacao && $ultimaSolicitacao->data_prevista) {
                // Usar a data prevista da última solicitação como referência e converter para Carbon
                $dataReferencia = Carbon::parse($ultimaSolicitacao->data_prevista);
            } else {
                // Se não houver, usar a data atual
                $dataReferencia = Carbon::now();
            }

            // Calcular a nova data prevista
            $dataPrevista = $dataReferencia->addMinutes($tempoTotal); // Adiciona o tempo total em minutos

            // Atualizar a data prevista na solicitação
            $solicitacao->data_prevista = $dataPrevista;
            $solicitacao->save();
        }
    }
}
