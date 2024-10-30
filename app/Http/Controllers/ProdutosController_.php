<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Estoque;
use App\Models\Fornecedores;
use App\Models\Marcas;
use App\Models\Produtos;
use Exception;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    public function index()
    {
        $dados = Produtos::with(['fornecedor'])->orderBy('id', 'desc')->paginate(env('APP_PAGINATE'));
        return view('produtos.index')->with(compact('dados'));
    }

    public function create()
    {
        $categorias = Categorias::all();
        $marcas = Marcas::all();
        $fornecedores = Fornecedores::where('status', '=', 'ATIVO')->get();
        return view('produtos.create')->with(compact('categorias', 'marcas', 'fornecedores'));
    }

    public function edit(Produtos $produtos, Request $request)
    {

        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $dados = Produtos::find($request->id);
        $fornecedores = Fornecedores::where('status', '=', 'ATIVO')->get();
        $categorias = Categorias::all();
        $marcas = Marcas::all();
        return view('produtos.edit')->with(compact('categorias', 'marcas', 'dados', 'fornecedores'));
    }

    public function update(Produtos $produtos, Request $request)
    {
        try {
            $data = collect([]);
            if ($request->image) {
                $imageName = time() . '.' . $request->image->extension();

                // Public Folder
                $request->image->move(public_path('images') . '/produtos/fotos/', $imageName);

                $data = $data->merge([
                    "capa"       => env('APP_LINK_IMAGES') . 'produtos/fotos/' . $imageName
                ]);
            }


            $data = $data->merge([
                "categoria_id"          => trim($request->categoria_id),
                "codigo"          => trim($request->codigo),
                "fornecedor_id"          => trim($request->fornecedor_id),
                "marca_id"          => trim($request->marca_id),
                "descricao"       => trim($request->descricao),
                "status"       => trim($request->status),
                "und"       => $request->und,
                //  "valor"        => (float)str_replace(",", ".", $request->valor),
                "qtd"       => strtr($request->qtd, ',', '.'),
                "qtd_min"       => strtr($request->qtd_min, ',', '.'),
                "qtd_max"       => strtr($request->qtd_max, ',', '.'),
                "valor_compra"       => strtr($request->valor_compra, ',', '.'),
                "valor_venda"       => strtr($request->valor_venda, ',', '.'),
                "margem_lucro" =>    ($request->valor_venda - $request->valor_compra) / $request->valor_compra * 100,
            ]);



            Produtos::find($request->id)->update($data->all());
        } catch (Exception $e) {
            session()->flash('message-warning', 'Occorreu um Erro');
        }
        $dados = Produtos::get();
        return redirect()->route('produtos.index')->with(compact('dados'))->with('message-success', 'Dados atualizados!');
    }


    public function store(Produtos $produtos, Request $request)
    {
        try {
           $valorcompra  = ($request['valor_compra'] != null) ? $request['valor_compra']: 0;
           $valorvenda  = ($request['valor_venda'] != null) ? $request['valor_venda']: 0;
           $qtdmin  = ($request['qtd_min'] != null) ? $request['qtd_min']: 1;
           $qtdmax  = ($request['qtd_max'] != null) ? $request['qtd_max']: 3;
           $und  = ($request['und'] != null) ? $request['und']: 'und';
           $descricao  = ($request['descricao'] != null) ? $request['descricao']: 'NÃO DEFINIDO';
            /* $request->validate([
                'image' => 'image|mimes:png,jpg,jpeg|max:2048'
            ]); */

            if ($request->image) {
                $imageName = time() . '.' . $request->image->extension();
                // Public Folder
                $request->image->move(public_path('images') . '/produtos/fotos/', $imageName);
                $produtos->capa = env('APP_LINK_IMAGES') . 'produtos/fotos/' . $imageName;
            }
            $produtos->und = $und;
            $produtos->codigo =  $request['codigo'];
            $produtos->qtd_min = $qtdmin;
            $produtos->qtd_max = $qtdmax;
            $produtos->valor_compra = strtr($valorcompra, ',', '.');
            $produtos->valor_venda = strtr($valorvenda, ',', '.');
            $produtos->categoria_id = $request['categoria_id'];
            $produtos->marca_id = $request['marca_id'];
            $produtos->fornecedor_id = $request['fornecedor_id'];
            $produtos->margem_lucro =($request['valor_venda'] - $request['valor_compra']) / $request['valor_compra'] * 100;
            $produtos->status = $request['status'];
            $produtos->descricao =$descricao;
            //               $produtos->valor = (float)str_replace(",", ".", $request['valor']);
            $produtos->save();
        } catch (Exception $e) {
            session()->flash('message-warning', 'Occorreu um Erro');
        }


        $dados = Produtos::get();
        return redirect()->route('produtos.index')->with(compact('dados'))->with('message-success', 'Dados Salvos!');;;
    }

    public function destroy(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        try {

            $produtos = Produtos::find($request->id)->delete();
        } catch (Exception $e) {
            session()->flash('message-warning', 'Erro ao excluir o produto, verifique se ele tem relacionamentos');
        }
        $dados = Produtos::get();
        return redirect()->route('produtos.index')->with(compact('dados'))->with('message-success', 'Dados excluidos!');
    }


    public function pesquisa(Request $request)
    {
      
        $produto = Produtos::where('codigo',$request->pesquisa)->first();
        $produto_id = ($produto) ? $produto->id : null;

        $query = Produtos::query();
        $query = ($produto_id != null) ? $query->where('id', $produto_id) : $query;
        $query = ($request->pesquisa != null) ? $query->orWhere('descricao', 'LIKE', '%' . $request->pesquisa . '%') : $query;
        $query = $query->orderBy('updated_at', 'desc');
        $dados = $query->paginate(env('APP_PAGINATE'));
      
        return view('produtos.index', ['dados' => $dados]);
    }
    public function pesquisaPorId(Request $request)
    {
      $id = ($request->id);
        $dados = Produtos::find($request);
        return $dados[0];
    }

    public function rastrear(Request $request)
    {
        $dados = Estoque::where('produto_id',$request->id)->orderBy('created_at', 'asc')->paginate(env('APP_PAGINATE'));


        return view('produtos.rastreio')->with(compact('dados'));
    }
}
