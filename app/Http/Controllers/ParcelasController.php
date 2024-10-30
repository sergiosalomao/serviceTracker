<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Cobrancas;
use App\Models\Financeiro\Movimentos;
use App\Models\Parcelas;
use App\Models\Vendas;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ParcelasController extends Controller
{
    public function index()
    {
        $dados = Parcelas::all();
        return view('parcelas.index')->with(compact('dados'));
    }

    public function create( Request $request)
    {
        $cobrancas = Parcelas::find($request->id);

        return view('parcelas.create', ['dados' => $cobrancas]);
    }

    public function edit(Parcelas $parcelas, Request $request)
    {
      
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $parcelas = Parcelas::find($request->id);

        return view('parcelas.edit', ['dados' => $parcelas]);
    }

    public function editaparcela(Parcelas $parcelas, Request $request)
    {
      
      
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $parcelas = Parcelas::find($request->id);

    

        return view('parcelas.editaparcela', ['dados' => $parcelas]);
    }

    public function update(Parcelas $parcelas, Request $request)
    {
     
        $datapagamento = converte_data($request->data_pagamento);
        $data = collect([]);
        $data = $data->merge([
            "data_pagamento"       => $datapagamento,
            /*  "vencimento"       => $request->vencimento, */
            "valor_pago"       => strtr($request->valor_pago, ',', '.'),
            "obs"       => trim($request->obs),
            "status"       => trim($request->status),
        ]);
        Parcelas::find($request->id)->update($data->all());
        #verifica o total pago das parcelas
        $parcelas =   Parcelas::where('cobranca_id', '=', $request->cobranca_id)->get();
        $valorPago = 0;
        $valorTotal = 0;
        foreach ($parcelas as $item) {
            $valorPago = $valorPago + $item['valor_pago'];
            $valorTotal = $valorTotal + $item['saldo_devedor'];
        }

        #se o valor pago de todas as parcelas for igual ou maior que o total a pagar ele muda status da cobrança para pago
        if ($valorPago >= $valorTotal) {
            $data = collect([]);
            $data = $data->merge([
                "status"       => 'PAGA',
            ]);
            Cobrancas::find($request->cobranca_id)->update($data->all());
            $cobranca = Cobrancas::find($request->cobranca_id);

            Vendas::find($cobranca->venda_id)->update($data->all());
        }

        #se o valor pago de todas as parcelas for menor que o total a pagar ele muda status da cobrança para aberta
        if ($valorPago < $valorTotal) {
            $data = collect([]);
            $data = $data->merge([
                "status"       => 'ABERTA',
            ]);
            Cobrancas::find($request->cobranca_id)->update($data->all());
            $cobranca = Cobrancas::find($request->cobranca_id);

            Vendas::find($cobranca->venda_id)->update($data->all());
        }


        if ($request->status == 'PAGA') {
            //Adiciona movimento
            $cobrancas = Cobrancas::find($request->cobranca_id);
            $cliente = Clientes::find($cobrancas->cliente_id);
            $movimentos = new Movimentos();
          
            $data_pagamento = Carbon::createFromFormat('Y-m-d H:i:s', $datapagamento);
            $data_pagamento->format('Y-m-d h:i:s');
            $movimentos->data = $data_pagamento;
          
            $centro_id = ($request['centro_id'] == null) ? 1 : $request['centro_id'];
            $conta_id = ($request['conta_id'] == null) ? 1 : $request['conta_id'];
            $movimentos->tipo = 'CREDITO';
            $movimentos->centro_id = $centro_id;
            $movimentos->conta_id = $conta_id;
            $movimentos->fluxo_id = 1; //vendas (credito)
            $movimentos->valor = floatval($request->valor_pago);
            $movimentos->descricao = "PAGAMENTO DE PARCELA | $cliente->nome";
            $movimentos->venda_id = $cobranca->venda_id;
            $movimentos->parcela_id = $request->id;

            $movimentos->save();
            //end adiciona movimento
        }
        $dados = Parcelas::paginate(env('APP_PAGINATE'));
        return redirect()->route('cobrancas.detalhes', ['id' => $request->cobranca_id]);
    }

    public function atualizaparcela(Parcelas $parcelas, Request $request)
    {
     
    
        $datapagamento = converte_data($request->data_pagamento);

        $data = collect([]);
        $data = $data->merge([
            "data_pagamento"       => $datapagamento,
            /*   "vencimento"       => $request->vencimento, */
            "valor_pago"       => strtr($request->valor_pago, ',', '.'),
            "obs"       => trim($request->obs),
            "status"       => trim($request->status),
        ]);

        Parcelas::find($request->id)->update($data->all());

        //verifica o total pago das parcelas
        $parcelas =   Parcelas::where('cobranca_id', '=', $request->cobranca_id)->get();
       
        $valorPago = 0;
        $valorTotal = 0;
        foreach ($parcelas as $item) {
            $valorPago = $valorPago + $item['valor_pago'];
            $valorTotal = $valorTotal + $item['saldo_devedor'];
        }

        //se o valor pago de todas as parcelas for igual ou maior que o total a pagar ele muda status da cobrança para pago
        if ($valorPago >= $valorTotal) {
            $data = collect([]);
            $data = $data->merge([
                "status"       => 'PAGA',
            ]);
            Cobrancas::find($request->cobranca_id)->update($data->all());
            $cobranca = Cobrancas::find($request->cobranca_id);

            Vendas::find($cobranca->venda_id)->update($data->all());
        }
        #se o valor pago de todas as parcelas for menor que o total a pagar ele muda status da cobrança para aberta
        if ($valorPago < $valorTotal) {
            $data = collect([]);
            $data = $data->merge([
                "status"       => 'ABERTA',
            ]);
            Cobrancas::find($request->cobranca_id)->update($data->all());
            $cobranca = Cobrancas::find($request->cobranca_id);

            Vendas::find($cobranca->venda_id)->update($data->all());
        }

        if ($request->entrada > 0) {
            //Adiciona movimento
            $cobrancas = Cobrancas::find($request->cobranca_id);
            $cliente = Clientes::find($cobrancas->cliente_id);
            $movimentos = new Movimentos();
            // $dt = Carbon::now();
            // $dt->format('Y-m-d h:i:s');

            $data_pagamento = Carbon::createFromFormat('Y-m-d H:i:s', $datapagamento);
            $data_pagamento->format('Y-m-d h:i:s');
            $movimentos->data = $data_pagamento;

            $centro_id = ($request['centro_id'] == null) ? 1 : $request['centro_id'];
            $conta_id = ($request['conta_id'] == null) ? 1 : $request['conta_id'];
            $movimentos->centro_id = $centro_id;
            $movimentos->conta_id = $conta_id;

            $movimentos->tipo = 'CREDITO';
            $movimentos->fluxo_id = 1; //vendas (credito)
            $movimentos->valor = floatval($request->valor_pago);
            $movimentos->descricao = "PAGAMENTO ENTRADA | $cliente->nome";
            $movimentos->venda_id = $cobranca->venda_id;
            $movimentos->save();
            #end adiciona movimento
        }


        if ($request->status == 'PAGA') {
            //Adiciona movimento
            $cobrancas = Cobrancas::find($request->cobranca_id);
            $cliente = Clientes::find($cobrancas->cliente_id);
            $movimentos = new Movimentos();

            $data_pagamento = Carbon::createFromFormat('Y-m-d H:i:s', $datapagamento);
            $data_pagamento->format('Y-m-d h:i:s');
            $movimentos->data = $data_pagamento;

            $centro_id = ($request['centro_id'] == null) ? 1 : $request['centro_id'];
            $conta_id = ($request['conta_id'] == null) ? 1 : $request['conta_id'];
            $movimentos->centro_id = $centro_id;
            $movimentos->conta_id = $conta_id;

            $movimentos->tipo = 'CREDITO';
            $movimentos->fluxo_id = 1; //vendas (credito)
            $movimentos->valor = floatval($request->valor_pago);
            $movimentos->descricao = "Referente a venda ID: [$cobrancas->venda_id] | $cliente->nome";
            $movimentos->venda_id = $cobranca->venda_id;
            $movimentos->parcela_id = $request->id;
            $movimentos->save();
            //end adiciona movimento
        }

        $dados = Parcelas::paginate(env('APP_PAGINATE'));

        return redirect()->route('cobrancas.parcelas');
    }

    public function store(Request $request)
    {
        $cobranca_id = ($request->id);
        $vencimento = converte_data($request->vencimento);
       
        $parcelas = new Parcelas();
        $vencimento = Carbon::createFromFormat('Y-m-d H:i:s', $vencimento);
        $vencimento->format('Y-m-d h:i:s');

        $cobrancas = Cobrancas::find($request->id);
        $parcelas->cliente_id = $cobrancas->cliente_id;
        $parcelas->vencimento = $vencimento;
        $parcelas->cobranca_id = $cobranca_id;
        $parcelas->valor = floatval($request->valor);
        $parcelas->obs = ($request->obs != null)? $request->obs : 'Parcela Avulsa';
        $parcelas->status = 'ABERTA';
        $parcelas->save();
        $dados = Parcelas::paginate(env('APP_PAGINATE'));
        return redirect()->route('cobrancas.detalhes', ['id' => $cobranca_id, 'cobranca_id' => $cobrancas->cliente_id]); 
    }

    public function destroy(Request $request)
    {
        $parcela =  Parcelas::find($request->id);
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $parcelas = Parcelas::find($request->id)->delete();
        $dados = Parcelas::paginate(env('APP_PAGINATE'));
        return redirect()->route('cobrancas.detalhes', ['id' => $parcela->cobranca_id]);
    }

    public function cancelar(Request $request)
    {
        $data = collect([]);
        $data = $data->merge([
            "status"       => 'ABERTA',
            "valor_pago"       => 0,
            "data_pagamento"       => '',

        ]);

        Parcelas::find($request->id)->update($data->all());

        #verifica o total pago das parcelas
        $parcelas =   Parcelas::where('cobranca_id', '=', $request->cobranca_id)->get();
        $valorPago = 0;
        $valorTotal = 0;
        foreach ($parcelas as $item) {
            $valorPago = $valorPago + $item['valor_pago'];
            $valorTotal = $valorTotal + $item['saldo_devedor'];
        }

        #se o valor pago de todas as parcelas for igual ou maior que o total a pagar ele muda status da cobrança para pago
        if ($valorPago >= $valorTotal) {
            $data = collect([]);
            $data = $data->merge([
                "status"       => 'PAGA',
            ]);
            Cobrancas::find($request->cobranca_id)->update($data->all());
            $cobranca = Cobrancas::find($request->cobranca_id);

            Vendas::find($cobranca->venda_id)->update($data->all());
        }
        #se o valor pago de todas as parcelas for menor que o total a pagar ele muda status da cobrança para aberta
        if ($valorPago < $valorTotal) {
            $data = collect([]);
            $data = $data->merge([
                "status"       => 'ABERTA',
            ]);
            Cobrancas::find($request->cobranca_id)->update($data->all());
            $cobranca = Cobrancas::find($request->cobranca_id);

            Vendas::find($cobranca->venda_id)->update($data->all());
        }

        #cancela movimento
        $data = collect([]);
        $data = $data->merge([
            "status"       => 'CANCELADA',

        ]);

        $movimento = Movimentos::where('parcela_id', $request->id)->update($data->all());
        #end CANCEla movimento

        return redirect()->route('cobrancas.parcelas', ['id' => $request->cobranca_id]);
    }

    public function cancelarDetalhes(Request $request)
    {
        $data = collect([]);
        $data = $data->merge([
            "status"       => 'ABERTA',
            "valor_pago"       => 0,
            "data_pagamento"       => '',

        ]);

        Parcelas::find($request->id)->update($data->all());

        #verifica o total pago das parcelas
        $parcelas =   Parcelas::where('cobranca_id', '=', $request->cobranca_id)->get();
        $valorPago = 0;
        $valorTotal = 0;
        foreach ($parcelas as $item) {
            $valorPago = $valorPago + $item['valor_pago'];
            $valorTotal = $valorTotal + $item['saldo_devedor'];
        }

        #se o valor pago de todas as parcelas for igual ou maior que o total a pagar ele muda status da cobrança para pago
        if ($valorPago >= $valorTotal) {
            $data = collect([]);
            $data = $data->merge([
                "status"       => 'PAGA',
            ]);
            Cobrancas::find($request->cobranca_id)->update($data->all());
            $cobranca = Cobrancas::find($request->cobranca_id);

            Vendas::find($cobranca->venda_id)->update($data->all());
        }
        #se o valor pago de todas as parcelas for menor que o total a pagar ele muda status da cobrança para aberta
        if ($valorPago < $valorTotal) {
            $data = collect([]);
            $data = $data->merge([
                "status"       => 'ABERTA',
            ]);
            Cobrancas::find($request->cobranca_id)->update($data->all());
            $cobranca = Cobrancas::find($request->cobranca_id);

            Vendas::find($cobranca->venda_id)->update($data->all());
        }



        #deleta movimento
        if (!$request->id) throw new \Exception("Erro ao cancelar", 1);
        Movimentos::where('parcela_id', $request->id)->delete();

        return redirect()->route('cobrancas.detalhes', ['id' => $request->cobranca_id]);
    }


    public function pesquisa(Request $request)
    {
    
        $clientes = Clientes::all();
        $de =  null;
        $ate = null;
        if ($request->dtini && $request->dtfim) {
            $de = Carbon::createFromFormat('Y-m-d', $request->dtini)->startOfDay();;
            $ate = Carbon::createFromFormat('Y-m-d', $request->dtfim)->endOfDay();;
        }
          
        $query = Parcelas::query();
        $query = ($request->status != null) ? $query->where('status',$request->status ) : $query;
        $query = ($request->cliente_id != null) ? $query->where('cliente_id', $request->cliente_id) : $query;
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('vencimento', [$de, $ate]) : $query;
        $query = $query->orderBy('id', 'desc');
        $valor = $query->sum('valor');
        
        $query = Parcelas::query();
        $query = ($request->status != null) ? $query->where('status',$request->status ) : $query;
        $query = ($request->cliente_id != null) ? $query->where('cliente_id', $request->cliente_id) : $query;
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('vencimento', [$de, $ate]) : $query;
        $query = $query->orderBy('id', 'desc');
        $pago = $query->sum('valor_pago');
     
        $aberto = $valor - $pago;
       
        $query = Parcelas::query();
        $query = ($request->status != null) ? $query->where('status',$request->status) : $query;
        $query = ($request->cliente_id != null) ? $query->where('cliente_id', $request->cliente_id) : $query;
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('vencimento', [$de, $ate]) : $query;
        $query = $query->orderBy('vencimento', 'asc');
        $dados = $query->get();
        return view('cobrancas.parcelas', ['dados' => $dados, 'valor' => $valor,'pago' => $pago,'aberto' => $aberto,'clientes'=>$clientes,'filtros'=>$request]);
    }
}
