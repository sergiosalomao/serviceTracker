<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use App\Models\Cobranca;
use App\Models\Pagamento;
use App\Models\Solicitacoes;

class CobrancaController extends Controller
{
    // Método para criar uma nova cobrança
    public function store(Request $request)
    {
        // Recuperar a solicitação com base no ID
        $solicitacao = Solicitacoes::find($request->solicitacao_id);

        // Criar uma nova cobrança
        $cobranca = new Cobranca();
        $cobranca->solicitacao_id = $solicitacao->id;
        $cobranca->valor_total = $request->valor_total;
        $cobranca->entrada = $request->entrada;
        $cobranca->desconto = $request->desconto;
        $cobranca->data_vencimento = $request->data_vencimento;
        $cobranca->parcelas = $request->parcelas; // Número de parcelas

        $cobranca->save();

        // Gerar as parcelas, se necessário
        $valorPorParcela = $request->valor_total / $request->parcelas;
        for ($i = 1; $i <= $request->parcelas; $i++) {
            Pagamento::create([
                'cobranca_id' => $cobranca->id,
                'valor' => $valorPorParcela,
                'data_vencimento' => now()->addMonths($i), // Ajustar a data de vencimento de cada parcela
                'status' => 'PENDENTE'
            ]);
        }

        return response()->json(['mensagem' => 'Cobrança criada com sucesso!']);
    }


    public function index(Request $request)
    {
        // Recupera todas as cobranças do banco
        $dados = Cobranca::where('status', '!=', 'TESTE')->orderby('data_vencimento', 'desc')->orderBy('id', 'desc')->orderBy('status', 'desc')->paginate(env('APP_PAGINATE'));
        $clientes = Clientes::all();

        // Retorna a view com as cobranças
        return view('cobrancas.index', compact('dados', 'clientes'));
    }
}
