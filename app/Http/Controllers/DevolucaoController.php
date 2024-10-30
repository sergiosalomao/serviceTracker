<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Cobrancas;
use App\Models\Estoque;
use App\Models\ItensVendas;
use App\Models\Parcelas;
use App\Models\Vendas;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevolucaoController extends Controller
{
    public function index(Request $request)
    {
        $ItensVenda = ItensVendas::where('venda_id',$request->id)->where('qtd', '>', 0)->get();
     
        $produtos = Estoque::where('status', '=', 'SIM')
        
            ->select('produto_id')->groupBy('produto_id')
            ->get();
      
        return view('vendas.devolucao', ['itens' => $ItensVenda, 'produtos' => $produtos]); 
    }

 

    public function devolucao(Request $request)
    {
        $produto_id = $request->produto_id;
        $qtd = $request->qtd;
        $venda_id = $request->venda_id;
      
        #retira do carrinho
        $this->retiraCarrinho($venda_id, $produto_id,$qtd);
      
        #adiciona no estoque
        $estoque = new Estoque();
        $estoque->produto_id = $produto_id;
        $estoque->qtd = $qtd;
        $estoque->historico = "Devolução produto ID: [$produto_id] - Venda - $venda_id";
        $estoque->status = 'SIM';
        $estoque->tipo = 'ENTRADA';
        $estoque->save();
       
        #localiza venda anterior
      //  $vendaAnterior = Vendas::find($venda_id);
        
        #pega total dos itens produtos atualizado
        $itens = ItensVendas::where('venda_id', '=', $venda_id)->get();
     
        $totalAtualizado = 0;
        foreach ($itens as $item){
          $totalAtualizado = $totalAtualizado + ($item['produto']['valor_venda'] * $item->qtd);
        }
        $vendas = new VendasController();
        $vendas->recalcularVenda($venda_id,$totalAtualizado);


       $total = Vendas::where('status', '!=', 'CANCELADA')->sum('valor');
       $desconto = Vendas::where('status', '!=', 'CANCELADA')->sum('desconto');
       $entradas = Vendas::where('status', '!=', 'CANCELADA')->sum('entrada');
       $saldo_devedor = Vendas::where('status', '!=', 'CANCELADA')->sum(DB::raw('valor - desconto'));
       $total_registros = Vendas::where('status', '!=', 'CANCELADA')->count();
       $dados = Vendas::where('status', '!=', 'CANCELADA')->orderby('id', 'desc')->paginate(env('APP_PAGINATE'));

   return redirect()->route('vendas.index', ['dados' => $dados]);
    }


    public function retiraCarrinho($venda_id,$produto_id,$qtd){
    $itens = ItensVendas::where('venda_id', '=', $venda_id)
    ->where('produto_id', '=', $produto_id)->
    first();
        if ($itens->qtd > 0){
        $data = collect([]);
        $data = $data->merge([
          "qtd"       =>$itens->qtd - $qtd,
      ]);
     $item = ItensVendas::find($itens->id)->update($data->all());
    }
     
    }

   

}
