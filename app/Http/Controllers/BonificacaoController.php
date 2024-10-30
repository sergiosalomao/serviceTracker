<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Clientes;
use App\Models\Cobrancas;
use App\Models\Estoque;
use App\Models\Fornecedores;
use App\Models\Marcas;
use App\Models\Parcelas;
use App\Models\Produtos;
use Exception;
use Illuminate\Http\Request;
use Spatie\FlareClient\Http\Client;

class BonificacaoController extends Controller
{
    public function index()
    {
        #regra: Quem pagou mais e a venda deve estar paga.
        $clientes = Clientes::all();

        $listaClientes = [];

        foreach ($clientes as $cliente) {
            $totalParcelas = Parcelas::where('cliente_id', $cliente->id)->where('status', 'PAGA')->sum('valor_pago');
            array_push($listaClientes, ['total_pago'=> $totalParcelas,'cliente' => $cliente,'pontos'=>$totalParcelas/100]);
        }

        arsort($listaClientes);
        $dados = $listaClientes;
        return view('bonificacao.index')->with(compact('dados'));
    }
}
