<?php

namespace App\Http\Controllers;

use App\Models\Cobranca;
use App\Models\Pagamento;
use App\Models\Solicitacoes;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    public function index(Request $request)
    {
        $dados = Pagamento::where('cobranca_id', $request->cobranca_id)->get();
        return view('pagamentos.index', compact('dados'));
    }

    public function update(Request $request, $id)
    {
        $pagamento = Pagamento::findOrFail($id);
        $pagamento->update($request->all());
        return redirect()->route('pagamentos.index')->with('success', 'Pagamento atualizado com sucesso!');
    }

    public function baixar(Request $request)
    {
        $dt = Carbon::now();
        $dt->format('Y-m-d h:i:s');
        $pagamento = Pagamento::findOrFail($request->id);
        $pagamento->status = 'PAGO';
        $pagamento->data_pagamento = $dt;
        $pagamento->save();

        //verifica se todos os pagamentos dessa cobranca estao pagas se tiver muda status cobranca
        $pagamentos = Pagamento::where('cobranca_id', $pagamento->cobranca_id)->get();
        $todosPagos = $pagamentos->every(function ($pagamentos) {
            return $pagamentos->status === 'PAGO';
        });
        // Define o novo status da cobrança
        if ($todosPagos) {
            $cobranca = Cobranca::find($pagamento->cobranca_id);
            $cobranca->status = 'PAGO'; 
            $cobranca->save();
        }
        //define status solicitacao
        if ($todosPagos) {
            $solicitacoes = Solicitacoes::find($cobranca->solicitacao_id);
            $solicitacoes->status_pagamento = 'PAGO'; // Define o novo status da cobrança
            $solicitacoes->save();
        }




        $dados = Pagamento::where('cobranca_id', $request->cobranca_id)->get();
        return view('pagamentos.index', compact('dados'));
    }

    public function cancelar(Request $request)
    {
        $pagamento = Pagamento::findOrFail($request->id);
        $pagamento->status = 'PENDENTE';
        $pagamento->data_pagamento = null;
        $pagamento->save();

        //muda status da cobranc
        $cobranca = Cobranca::find($pagamento->cobranca_id);
        $cobranca->status = 'PENDENTE'; // Define o novo status da cobrança
        $cobranca->save();


        $dados = Pagamento::where('cobranca_id', $request->cobranca_id)->get();
        return view('pagamentos.index', compact('dados'))->with('success', 'Pagamento cancelado com sucesso!');;
    }
}
