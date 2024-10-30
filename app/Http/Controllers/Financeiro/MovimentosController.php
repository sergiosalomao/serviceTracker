<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\Financeiro\Centros;
use App\Models\Financeiro\Contas;
use App\Models\Financeiro\Fluxos;
use App\Models\Financeiro\FormasPagamento;
use App\Models\Financeiro\Movimentos;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MovimentosController extends Controller
{
    public function index(Request $request)
    {
        $de = Carbon::today()->startOfDay();
        $ate = Carbon::today()->endOfDay();

        $contas = Contas::all();
        $dados = Movimentos::with('centro', 'conta', 'fluxo', 'user')
            ->whereBetween('data', [$de, $ate])
            ->Where('status', null)
            ->Where('conta_id', '=', 1)
            ->orderBy('data', 'asc')->get();
        $totalformaspagamento = $this->totalPorFormaPagamento($dados);
        $dados = $this->calculaSaldo($dados, $de->format('Y-m-d'));

        $saldo = $dados['saldo'];
        $saldoAnterior = $dados['saldo'];

        $dados = $dados['dados'];
        return view('financeiro.movimentos.index')->with(compact('dados', 'saldo', 'saldoAnterior', 'de', 'ate', 'totalformaspagamento', 'contas'));
    }

    public function create()
    {
        $centros = Centros::all();
        $contas = Contas::all();
        $fluxos = Fluxos::all();
        $usuarios = User::all();
        $dados = Movimentos::Where('status', null)->orderBy('id', 'asc')->paginate(env('APP_PAGINATE'));
        return view('financeiro.movimentos.create')->with(compact('dados', 'centros', 'contas', 'fluxos', 'usuarios'));
    }

    public function edit(Movimentos $movimentos, Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $dados = Movimentos::find($request->id);
        $centros = Centros::all();
        $contas = Contas::all();
        $fluxos = Fluxos::all();
        $usuarios = User::all();

        return view('financeiro.movimentos.edit')->with(compact('dados', 'centros', 'contas', 'fluxos', 'usuarios'));
    }

    public function update(Movimentos $movimentos, Request $request)
    {
       
        $fluxos = new FluxosController();
        $tipoFluxo = $fluxos->retornaTipo($request->fluxo_id);

        if ($request->tipo <> $tipoFluxo) {
            return redirect()->back()->with(['dados' => $movimentos]);
        }
        try {
            $data = collect([]);
            $data = $data->merge([
                "data"          =>  Carbon::createFromFormat('d/m/Y', $request->data),
                "centro_id"          => $request->centro_id,
                "conta_id"          => $request->conta_id,
                "fluxo_id"          => $request->fluxo_id,
                "valor"          => floatval($request->valor),
                "descricao"          => $request->descricao,
               
                "tipo"          => $tipoFluxo,
            ]);

            Movimentos::find($request->id)->update($data->all());
            $movimentos = Movimentos::Where('status', null)->orderBy('id', 'asc')->paginate(env('APP_PAGINATE'));
            $movimentos = $this->calculaSaldo($movimentos, $request->data, $request->conta_id);
        } catch (Exception $e) {;
            return redirect()->back()->with(['dados' => $movimentos]);
        }

        return redirect()->route(('movimentos.index'))->with(['dados' => $movimentos]);
    }

    public function store(Movimentos $movimentos, Request $request)
    {
        $centro_id = ($request['centro_id'] == null) ? 1 : $request['centro_id'];
        $conta_id = ($request['conta_id'] == null) ? 1 : $request['conta_id'];

      
        $fluxos = new FluxosController();
        if ($request->fluxo_id <> null)
            $tipoFluxo = $fluxos->retornaTipo($request->fluxo_id);

        try {
            $movimentos->data = Carbon::createFromFormat('Y-m-d', $request['data']);
            $movimentos->tipo = $tipoFluxo;
            $movimentos->centro_id = $centro_id;
            $movimentos->conta_id = $conta_id;
            $movimentos->fluxo_id = $request['fluxo_id'];
         
            $movimentos->valor = floatval($request['valor']);
            $movimentos->descricao = $request['descricao'];
            $movimentos->save();
            $movimentos = Movimentos::Where('status', null)->orderBy('id', 'desc')->paginate(env('APP_PAGINATE'));
            $movimentos = $this->calculaSaldo($movimentos, $request['data'], $request->conta_id);
        } catch (Exception $e) {;

            return redirect()->back()->with(['dados' => $movimentos]);
        }

        return redirect()->route(('movimentos.index'))->with(['dados' => $movimentos]);
    }

    public function destroy(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);

        try {
            $movimentos = Movimentos::find($request->id)->delete();
            $movimentos = Movimentos::Where('status', null)->orderBy('id', 'desc')->paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            report($e);
            $movimentos = Movimentos::Where('status', null)->orderBy('id', 'desc')->paginate(env('APP_PAGINATE'));
            return redirect()->back()->with(['dados' => $movimentos]);
        }

        return redirect()->back()->with(['dados' => $movimentos]);
    }


    public function pesquisa(Request $request)
    {
     
        $contas = Contas::all();

        $de = ($request->dtini != null) ? Carbon::createFromFormat('Y-m-d', $request->dtini)->startOfDay() : Carbon::today()->endOfDay();;
        $ate = ($request->dtfim != null) ? Carbon::createFromFormat('Y-m-d', $request->dtfim)->endOfDay() : Carbon::today()->endOfDay();;
        
        $query = Movimentos::query();
        $query = ($request->lancamento != null) ? $query->where('descricao', 'LIKE', '%' . $request->pesquisa . '%') : $query;
        $query = ($request->conta_id != null) ? $query->where('conta_id', $request->conta_id) : $query;
        $query = ($request->codigo != null) ? $query->where('id', $request->codigo) : $query;
        $query = ($request->tipo != null) ? $query->where('tipo', $request->tipo) : $query;
        $query = ($request->dtini != null && $request->dtfim != null ) ? $query->WhereBetween('data', [$de, $ate]):$query;
        $query = $query->Where('status', null);
        $query = $query->orderBy('data', 'ASC');
        $movimentos = $query->get();



        $totalformaspagamento = $this->totalPorFormaPagamento($movimentos);

        if ($de == null)
            $de = Carbon::now()->startOfDay();

        $dados = $this->calculaSaldo($movimentos, $de->format('Y-m-d'), $request->conta_id);

      
        $saldoAnterior = $dados['saldoAnterior'];
        $saldo = $dados['saldo'];
        $dados = $dados['dados'];
        if ($request->fluxo)
            return view('financeiro.movimentos.fluxocaixa')->with(compact('dados', 'saldo', 'de', 'ate', 'totalformaspagamento', 'contas'));
        if ($request->fluxoconsolidado)
            return view('financeiro.movimentos.fluxocaixaconsolidado')->with(compact('dados', 'saldo', 'de', 'ate', 'totalformaspagamento', 'contas'));
        if ($request->lancamento)
            return view('financeiro.movimentos.lancamentos')->with(compact('dados', 'saldo', 'saldoAnterior', 'de', 'ate', 'totalformaspagamento', 'contas'));
        if ($request->caixa)
            return view('financeiro.movimentos.index')->with(compact('dados', 'saldo', 'saldoAnterior', 'de', 'ate', 'totalformaspagamento', 'contas'));
    }

    public function adicionaMovimento($dados)
    {
        $movimentos = new Movimentos();
        
        /* se tiver cupom */
        $cupom = (!empty($dados->codigo_desconto)) ? ' - CUPOM : ' . $dados->codigo_desconto : null;
        $valor = floatval($dados['servico']->valor) - floatval($dados->desconto);
        try {
            $movimentos->data = $dados->created_at;
            $movimentos->tipo = 'CREDITO';
            $movimentos->centro_id = 1;
            $movimentos->conta_id = 1;

            if ($dados->forma_pagamento_id != 1)
                $movimentos->conta_id = 2;

            //nova regra diz que se for carteira vai pro banco tambem
            if ($dados->forma_pagamento_id == 1)
                $movimentos->conta_id = 2;

            if ($dados->forma_pagamento_id == 5)
                $movimentos->conta_id = 3;


            $movimentos->fluxo_id = 1;
           
            $movimentos->valor = floatval($valor);

            $movimentos->descricao = $dados['servico']->descricao;
            if ($dados->desconto)
                $movimentos->descricao = $dados['servico']->descricao . " [DESCONTO DE " . "R$ " . number_format($dados->desconto, 2, ',', '.') . $cupom . "]";
            $movimentos->forma_pagamento_id = $dados->forma_pagamento_id;
          
            $movimentos->save();

            $movimentos = Movimentos::Where('status', null)->orderBy('id', 'desc')->paginate(env('APP_PAGINATE'));
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function cancelaMovimento($dados)
    {
       
        try {
            $data = collect([]);
            $data = $data->merge([
           
                "status"          => 'CANCELADO',
            ]);
            $movimento = Movimentos::where('lavagem_id', $dados->id)->get();

            $movimentos = Movimentos::find($movimento[0]->id)->update($data->all());
        } catch (Exception $e) {
          dd($e);
        }
    }

    public function fluxoCaixa(Request $request)
    {
        $de = Carbon::today()->startOfDay();
        $ate = Carbon::today()->endOfDay();
        $contas = Contas::all();

        $fluxos = Fluxos::all();
        $dados = Movimentos::with('centro', 'conta', 'fluxo', 'user')
            ->whereBetween('data', [$de, $ate])
            ->Where('status', null)
            ->orderBy('fluxo_id')
            ->get();

        return view('financeiro.movimentos.fluxocaixa')->with(compact('dados', 'fluxos', 'de', 'ate', 'contas'));
    }

    public function fluxoConsolidado(Request $request)
    {
        $de = Carbon::today()->startOfDay();
        $ate = Carbon::today()->endOfDay();
        $contas = Contas::all();

        $fluxos = Fluxos::all();
        $dados = Movimentos::with('centro', 'conta', 'fluxo', 'user')
            ->whereBetween('data', [$de, $ate])
            ->where('status', null)
            ->orderBy('fluxo_id')
            ->get();

        return view('financeiro.movimentos.fluxocaixaconsolidado')->with(compact('dados', 'fluxos', 'de', 'ate', 'contas'));
    }

    public function lancamentos(Request $request)
    {
        $contas = Contas::all();

        $dados = Movimentos::Where('status', null)
        ->orderBy('data', 'asc')
        ->paginate(env('APP_PAGINATE'));
        return view('financeiro.movimentos.lancamentos')->with(compact('dados', 'contas'));
    }

    public function calculaSaldoAnterior($data = null, $conta_id)
    {
      
        if ($data == null) {
            $data = Carbon::createFromFormat('Y-m-d')->today();;
            $data =  $data->format('Y-m-d');
        }
        
        $de = Carbon::createFromFormat('Y-m-d', '2000-01-01');
        $ate = Carbon::createFromFormat('Y-m-d', $data)->subDay()->endOfDay();
        
        $dados = Movimentos::with(['centro', 'conta', 'fluxo', 'user'])
        ->whereBetween('data', [$de, $ate])
        ->Where('conta_id', $conta_id)
        ->where('status', null) 
        ->orderBy('data', 'asc')
        ->get();
 
          
        $saldo = 0;
        $saldoAnterior = 0;
        foreach ($dados as $key => $value) {
            $valor = ($value->tipo == 'DEBITO') ? -$value->valor : $value->valor;
            $saldo = floatval($saldoAnterior) + floatval($valor);
            $dados[$key]['saldo'] = $saldo;
            $saldoAnterior = floatval($saldoAnterior) + floatval($valor);
        }
        //se so tiver um registro ele diz que o anterior é zero
      //  $total_counts = Movimentos::count();
      //  if ($total_counts == 1) $saldoAnterior = 0;

      // $primeiro_registro = Movimentos::first();
     //  $primeiro_registro = $primeiro_registro->tipo = 'CREDITO'? $primeiro_registro->valor: -$primeiro_registro->valor;
   
        return  $saldoAnterior;
    }

    public function calculaSaldo($dados, $dataFinal, $conta_id = 1)
    {
        $saldoAnt = $this->calculaSaldoAnterior($dataFinal, $conta_id);
       
        $saldo = 0;
        $saldoAnterior = 0;
        $saldoAnterior =  floatval($saldoAnt);

        foreach ($dados as $key => $value) {
            $valor = ($value->tipo == 'DEBITO') ? -$value->valor : $value->valor;
            $saldo = floatval($saldoAnterior) + floatval($valor);
      //      $saldo =  floatval($valor);
            $dados[$key]['saldo'] = $saldo;
            $saldoAnterior = floatval($saldoAnterior) + floatval($valor);
        }
    

        $dados = ['dados' => $dados, 'saldo' => floatval($saldo), 'saldoAnterior' => floatval($saldoAnt)];
        return  $dados;
    }

    public function totalPorFormaPagamento($dados)
    {
        $total = null;
        try {
            $saldo = 0;
            $saldoAnterior = 0;
            $formasPagamento = FormasPagamento::all();
            foreach ($formasPagamento as $keyForma => $valueForma) {
                $saldo = 0;
                $saldoAnterior = 0;
                foreach ($dados as $key => $value) {
                    if ($value->forma_pagamento_id == $valueForma->id) {
                        $valor = ($value->tipo == 'DEBITO') ? -$value->valor : $value->valor;
                        $saldo = $saldoAnterior + $valor;

                        $total[$valueForma->forma] = $saldo;

                        $saldoAnterior = $saldoAnterior + $valor;
                    }
                }
            }
        } catch (Exception $e) {
        }

        return  $total;
    }

    public function gerarPDF(Request $request)
    {
        $de =  null;
        $ate = null;
        //pesquisa caixa
        if ($request->caixa || $request->fluxo) {
            try {
                $de = Carbon::createFromFormat('Y-m-d', $request->dtini)->startOfDay();;
                $ate = Carbon::createFromFormat('Y-m-d', $request->dtfim)->endOfDay();;
                $movimentos = Movimentos::with(['centro', 'conta', 'fluxo', 'user'])
                    ->whereBetween('data', [$de, $ate])
                    ->Where('conta_id', $request->conta_id)
                    ->where('status', null)
                    ->orderBy('id', 'asc')
                    ->get();
            } catch (Exception $e) {
                $movimentos = Movimentos::with(['centro', 'conta', 'fluxo', 'user'])
                    ->Where('conta_id', $request->conta_id)
                    ->orderBy('data', 'asc')
                    ->get();
            }
        }

        //pesquisa descricao
        if ($request->lancamento) {
            $movimentos = Movimentos::with(['centro', 'conta', 'fluxo', 'user'])
                ->where('descricao', 'like', '%' . $request->pesquisa . '%')
                ->Where('conta_id', $request->conta_id)
                ->where('status', null)
                ->orderBy('data', 'asc')
                ->get();
        }

        $totalformaspagamento = $this->totalPorFormaPagamento($movimentos);
        $dados = $this->calculaSaldo($movimentos,  $de->format('Y-m-d'), $request->conta_id);
        $saldo = $dados['saldo'];
        $dados = $dados['dados'];

        $titulo = "titulo";
        $subtitulo = "subtitulo";
        $data = [
            'title' => $titulo,
            'description' => $subtitulo,
            'de' => $de,
            'ate' => $ate,
            'totalformaspagamento' => $totalformaspagamento,
            'saldo' => $saldo,
            'dados' => $dados,
        ];
        $pdf = PDF::loadView('financeiro.movimentos.relatorio', $data)
            ->setPaper('A4', 'landscape')

            ->setOption('footer-right', 'Page [page] of [toPage]     ')
            ->setOption('footer-left', '     Printed: [date]')
            ->setOption('footer-font-size', 8)
            ->setOption('footer-font-name', 'Arial')
            ->setOption('margin-top', 10)
            ->setOption('margin-left', 5)
            ->setOption('margin-right', 5)
            ->setOption('lowquality', false)
            ->setOption('dpi', 350)
            ->setOption('image-quality', 100);

        $output = $pdf->output();
        return  file_put_contents(public_path() . '/relatorios/relatorio-caixa.pdf', $output);
    }
}
