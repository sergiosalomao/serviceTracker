<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Cobrancas;
use App\Models\Financeiro\Movimentos;
use App\Models\ItensVendas;
use App\Models\Parcelas;
use App\Models\Produtos;
use App\Models\Vendas;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class RelatoriosController extends Controller
{

    public function relatorioCobrancaVendas(Request $request)
    {
        $clientes = Clientes::all();
        $de =  null;
        $ate = null;
        if ($request->dtini && $request->dtfim) {
            $de = Carbon::createFromFormat('Y-m-d', $request->dtini)->startOfDay();;
            $ate = Carbon::createFromFormat('Y-m-d', $request->dtfim)->endOfDay();;
        }

        $query = Parcelas::query();
        $query = ($request->status != null) ? $query->where('status', $request->status) : $query;
        //       $query =  $query->where('status', '!=', 'CANCELADA');
        $query = ($request->cliente_id != null) ? $query->where('cliente_id', $request->cliente_id) : $query;
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('vencimento', [$de, $ate]) : $query;
        $valor = $query->sum('valor');



        $query = Parcelas::query();
        $query = ($request->status != null) ? $query->where('status', $request->status) : $query;
        //  $query =  $query->where('status', '!=', 'CANCELADA');
        $query = ($request->cliente_id != null) ? $query->where('cliente_id', $request->cliente_id) : $query;
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('vencimento', [$de, $ate]) : $query;
        $pago = $query->sum('valor_pago');

        $aberto = $valor - $pago;


        $query = Parcelas::query();

        $query = ($request->status != null) ? $query->where('status', $request->status) : $query;
        $query = ($request->cliente_id != null) ? $query->where('cliente_id', $request->cliente_id) : $query;
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('vencimento', [$de, $ate]) : $query;
        //  $query =  $query->where('status', '!=', 'CANCELADA');
        $query = $query->orderBy('vencimento', 'asc');
        $parcelas = $query->get();
        // dd($parcelas);


        $dados = [];
        $dados['total'] = $valor;
        $dados['pago'] = $pago;

        $dados['de'] = $de != null ? formatadata($de) : null;
        $dados['ate'] = $ate != null ? formatadata($ate) : null;
        $dados['status'] = $request->status;


        $dt = Carbon::now();
        $dataatual = $dt->toTimeString();
        $nomearquivo =  'cobrancas ' . $request->status . str_replace([':', '/'], "", $dataatual);
        return $this->geraPDF($parcelas, 'cobranca_venda', 'download', $dados, $nomearquivo);
    }

    public function relatorioContaCliente(Request $request)
    {
        $de =  null;
        $ate = null;
        if ($request->dtini && $request->dtfim) {
            $de = Carbon::createFromFormat('Y-m-d', $request->dtini)->startOfDay();;
            $ate = Carbon::createFromFormat('Y-m-d', $request->dtfim)->endOfDay();;
        }
        $cliente = Clientes::find($request->id);

        $dados = [];
        #total
        $query = Cobrancas::query();
        $query = $query->where('cliente_id', $cliente->id);
        $query = ($request->status != null) ? $query->where('status', $request->status) : $query;
        $query = $query->where('status', '!=', 'CANCELADA');
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('vencimento', [$de, $ate]) : $query;
        $dados['total'] = $query->sum('valor');

        #desconto
        $query = Cobrancas::query();
        $query = $query->where('cliente_id', $cliente->id);
        $query = ($request->status != null) ? $query->where('status', $request->status) : $query;
        $query = $query->where('status', '!=', 'CANCELADA');
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('vencimento', [$de, $ate]) : $query;
        $dados['desconto'] = $query->sum('desconto');

        #entrada
        $query = Cobrancas::query();
        $query = $query->where('cliente_id', $cliente->id);
        $query = ($request->status != null) ? $query->where('status', $request->status) : $query;
        $query = $query->where('status', '!=', 'CANCELADA');
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('vencimento', [$de, $ate]) : $query;
        $dados['entradas'] = $query->sum('entrada');

        #saldo
        $query = Cobrancas::query();
        $query = $query->where('cliente_id', $cliente->id);
        $query = ($request->status != null) ? $query->where('status', $request->status) : $query;
        $query = $query->where('status', '!=', 'CANCELADA');
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('vencimento', [$de, $ate]) : $query;
        $dados['saldo_devedor'] = $query->sum(DB::raw('valor - desconto'));

        #pago
        $query = Parcelas::query();
        $query = $query->where('cliente_id', $cliente->id);
        $query = $query->where('status', 'PAGA');
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('data_pagamento', [$de, $ate]) : $query;
        $dados['pago'] = $query->sum('valor_pago');

        #dados da pesquisa
        $query = Cobrancas::query();
        $query = $query->where('cliente_id', $cliente->id);
        $query = ($request->status != null) ? $query->where('status', $request->status) : $query;
        $query = $query->where('status', '!=', 'CANCELADA');
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('vencimento', [$de, $ate]) : $query;
        $query = $query->orderby('vencimento', 'asc');
        $cobrancas = $query->get();

        #nome do arquivo
        $nomearquivo = $cliente->nome . ' consolidado';
        return $this->geraPDF($cobrancas, 'contacliente', 'visualiza', $dados, $nomearquivo);
    }

    public function relatorioContaClienteDetalhado(Request $request)
    {
        $de =  null;
        $ate = null;
        if ($request->dtini && $request->dtfim) {
            $de = Carbon::createFromFormat('Y-m-d', $request->dtini)->startOfDay();;
            $ate = Carbon::createFromFormat('Y-m-d', $request->dtfim)->endOfDay();;
        }

        $status = ($request->status == null) ? $status = 'ABERTA' : $request->status;

        $cliente = Clientes::find($request->id);

        #dados da pesquisa
        $query = Vendas::query();
        $query = $query->where('cliente_id', $cliente->id);
        $query = ($status != null) ? $query->where('status', $status) : $query;
        $query = $query->where('status', '!=', 'CANCELADA');
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('data_compra', [$de, $ate]) : $query;
        $vendas = $query->get();


        $encontrados = [];
        foreach ($vendas as $venda) {
            array_push($encontrados, $venda->id);
        }

        $query = ItensVendas::query();
        $query = $query->with(['produto', 'venda']);
        $query = $query->whereIn('venda_id', $encontrados);
        $query = $query->groupBy('venda_id');

        $itens = $query->get();



        #dados da pesquisa cobrancas
        $query = Cobrancas::query();
        $query = $query->where('cliente_id', $cliente->id);
        //  $query = ($status != null) ? $query->where('status', $status) : $query;
        $query = $query->where('status', '!=', 'CANCELADA');
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('data_compra', [$de, $ate]) : $query;
        $cobrancas = $query->get();

        $cobrancasEncontradas = [];
        foreach ($cobrancas as $cobranca) {
            array_push($cobrancasEncontradas, $cobranca->id);
        }


        //parcelas pagas 
        $query = Parcelas::query();
        $query = $query->whereIn('cobranca_id', $cobrancasEncontradas);
        $query = $query->where('status', 'PAGA');

        $query = $query->orderby('data_pagamento');
        $movimentos = $query->get();


        $nomearquivo = $cliente->nome . ' detalhado';
        return $this->geraPDF($itens, 'contaclientedetalhado', 'visualiza', $vendas, $movimentos, $nomearquivo);
    }

    public function relatorioContaClienteDetalhadoIndividual(Request $request)
    {
        $dados = [];
        $dados['total'] = Cobrancas::where('status', '!=', 'CANCELADA')->where('cliente_id', $request->id)->sum('valor');
        $dados['desconto'] = Cobrancas::where('status', '!=', 'CANCELADA')->where('cliente_id', $request->id)->sum('desconto');
        $dados['entradas'] = Cobrancas::where('status', '!=', 'CANCELADA')->where('cliente_id', $request->id)->sum('entrada');
        $dados['pago'] = Parcelas::where('status', 'PAGA')->where('cliente_id', $request->id)->sum('valor_pago');
        $dados['saldo_devedor'] = Cobrancas::where('status', '!=', 'CANCELADA')->where('cliente_id', $request->id)->sum(DB::raw('valor - desconto'));

        $cliente = Clientes::find($request->cliente_id);
        $vendas = Vendas::where('id', $request->venda_id)->get();

        $encontrados = [];
        foreach ($vendas as $venda) {
            array_push($encontrados, $venda->id);
        }

        $query = ItensVendas::query();
        $query = $query->with(['produto', 'venda']);
        $query = $query->whereIn('venda_id', $encontrados);
        $query = $query->groupBy('venda_id');

        $itens = $query->get();







        $nomearquivo = $cliente->nome . ' detalhado';
        return $this->geraPDF($itens, 'contaclientedetalhado', 'visualiza', $vendas, $nomearquivo);
    }

    public function relatorioContaClienteGeral(Request $request)
    {
        $de =  null;
        $ate = null;
        if ($request->dtini && $request->dtfim) {
            $de = Carbon::createFromFormat('Y-m-d', $request->dtini)->startOfDay();;
            $ate = Carbon::createFromFormat('Y-m-d', $request->dtfim)->endOfDay();;
        }

        //  $status = ($request->status == null) ? $status = 'ABERTA' : $request->status;

        $cliente = Clientes::find($request->id);

        #dados da pesquisa
        $query = Vendas::query();
        $query = $query->where('cliente_id', $cliente->id);
        //  $query = ($status != null) ? $query->where('status', $status) : $query;
        $query = $query->where('status', '!=', 'CANCELADA');
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('data_compra', [$de, $ate]) : $query;
        $vendas = $query->get();


        $encontrados = [];
        foreach ($vendas as $venda) {
            array_push($encontrados, $venda->id);
        }

        $query = ItensVendas::query();
        $query = $query->with(['produto', 'venda']);
        $query = $query->whereIn('venda_id', $encontrados);
        $query = $query->groupBy('venda_id');

        $itens = $query->get();

        /*      //pega pelo movimento desativei por enquanto, melhor pela parcela paga
        $query = Movimentos::query();
        $query = $query->whereIn('venda_id', $encontrados);
        $query = $query->orderby('data');
        $movimentos = $query->get(); */



        #dados da pesquisa cobrancas
        $query = Cobrancas::query();
        $query = $query->where('cliente_id', $cliente->id);
        //  $query = ($status != null) ? $query->where('status', $status) : $query;
        $query = $query->where('status', '!=', 'CANCELADA');
        $query = ($request->dtini != null && $request->dtfim != null) ? $query->WhereBetween('data_compra', [$de, $ate]) : $query;
        $cobrancas = $query->get();

        $cobrancasEncontradas = [];
        foreach ($cobrancas as $cobranca) {
            array_push($cobrancasEncontradas, $cobranca->id);
        }


        //parcelas pagas 
        $query = Parcelas::query();
        $query = $query->whereIn('cobranca_id', $cobrancasEncontradas);
        $query = $query->where('status', 'PAGA');

        $query = $query->orderby('data_pagamento');
        $movimentos = $query->get();




        $nomearquivo = $cliente->nome . ' geral';
        return $this->geraPDF($itens, 'contaclientegeral', 'visualiza', $vendas, $movimentos, $nomearquivo);
    }


    public function geraPDF($dados, $view, $opcoes, $extra, $extra2 = null, $nomearquivo = null)
    {
        $titulo = "titulo";
        $subtitulo = "subtitulo";
        $dt = Carbon::now();
        $dtdata =  $dt->toDateString();
        $dthora =  $dt->toTimeString();
        //  echo $dt->toDateString();    //21/04/2015
        //  echo $dt->toFormattedDateString();    //21 de abril de 2015
        //  echo $dt->toTimeString(); //	22:32:05
        //  echo $dt->toDateTimeString();    //21-04-2015 22:32:05
        //  echo $dt->toDayDateTimeString();    //Ter, 21 de abril de 2015, 22h32
        $data = [
            'title' => $titulo,
            'description' => $subtitulo,
            'dados' => $dados,
            'extra' => $extra,
            'movimentos' => $extra2,
            'data' => formataData($dtdata),
            'hora' => $dthora,
        ];
        $pdf = PDF::loadView('relatorios.' . $view, $data)
            ->setPaper('a4', 'portrait') //portrait //landscape
            ->setOption('footer-right', 'Page [page] of [toPage]     ')
            ->setOption('footer-left', '     Printed: [date]')
            ->setOption('footer-font-size', 8)
            ->setOption('footer-font-name', 'Arial')
            ->setOption('margin-top', 5)
            ->setOption('margin-left', 5)
            ->setOption('margin-right', 5)
            ->setOption('lowquality', false)
            ->setOption('dpi', 300)
            ->setOption('image-quality', 100)
            ->setOption("isPhpEnabled", true);
        $output = $pdf->output();

        $file =  env('APP_PUBLIC') . 'relatorios/' . str_replace(" ", "_", $nomearquivo) . '.pdf';

        $headers = array(
            'Content-Type: application/pdf',
        );

        if ($opcoes == 'visualiza')
            return  $pdf->stream($file);

        if ($opcoes == 'download') {
            $files = Storage::disk('public')->allFiles('/relatorios');
            Storage::delete($files);
            file_put_contents($file, $output);
            return $file;
            //  return response()->download($output, $file,$headers);
        }
        exit();
    }



    public function relatorioEtiqueta(Request $request)
    {
        $produto = Produtos::find($request->produto_id);

        $nomearquivo = $produto->id .  $produto->descricao . ' etiqueta';
        return $this->geraEtiquetaPDF($produto, 'etiqueta', $nomearquivo);
    }


    public function geraEtiquetaPDF($dados, $view, $nomearquivo = null)
    {
        $titulo = "titulo";
        $subtitulo = "subtitulo";
        $dt = Carbon::now();
        $dtdata =  $dt->toDateString();
        $dthora =  $dt->toTimeString();
        //  echo $dt->toDateString();    //21/04/2015
        //  echo $dt->toFormattedDateString();    //21 de abril de 2015
        //  echo $dt->toTimeString(); //	22:32:05
        //  echo $dt->toDateTimeString();    //21-04-2015 22:32:05
        //  echo $dt->toDayDateTimeString();    //Ter, 21 de abril de 2015, 22h32
        $data = [
            'title' => $titulo,
            'description' => $subtitulo,
            'dados' => $dados,
            'data' => formataData($dtdata),
            'qrcode' =>   QrCode::size(45)->format('svg')
                ->generate($dados->codigo, public_path('/images/etiqueta.svg'))
        ];



        $pdf = PDF::loadView('relatorios.' . $view, $data)
            ->setPaper('etiqueta de joias', 'landscape') //portrait //landscape


            ->setOption('lowquality', false)
            ->setOption('dpi', 203)
            ->setOption('image-quality', 100)
            ->setOption("isPhpEnabled", true);
        $output = $pdf->output();

        $file =  env('APP_PUBLIC') . 'relatorios/' . str_replace(" ", "_", $nomearquivo) . '.pdf';

        $headers = array(
            'Content-Type: application/pdf',
        );

        return  $pdf->stream($file);


        exit();
    }
}
