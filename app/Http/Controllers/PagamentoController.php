<?php
namespace App\Http\Controllers;

use App\Models\Pagamento;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    public function index(Request $request)
    {
        $dados = Pagamento::where('cobranca_id',$request->cobranca_id)->get();
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
        $dados = Pagamento::where('cobranca_id',$request->cobranca_id)->get();
        return view('pagamentos.index', compact('dados'));
    }

    public function cancelar(Request $request)
    {
        $pagamento = Pagamento::findOrFail($request->id);
        $pagamento->status = 'PENDENTE'; 
        $pagamento->data_pagamento = null; 
        $pagamento->save();
        $dados = Pagamento::where('cobranca_id',$request->cobranca_id)->get();
        return view('pagamentos.index', compact('dados'))->with('success', 'Pagamento cancelado com sucesso!');;
       
    }
}
