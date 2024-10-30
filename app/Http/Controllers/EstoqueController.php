<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Estoque;
use App\Models\Fornecedores;
use App\Models\Produtos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstoqueController extends Controller
{
    public function index()
    {
        $total = Estoque::where('status', 'SIM')->sum('qtd');
        $dados = Estoque::select('produto_id')->groupBy('produto_id')->get();
        $categorias = Categorias::All();
        $fornecedores = Fornecedores::All();
        return view('estoque.index')->with(compact('dados', 'total', 'categorias', 'fornecedores'));
    }
    public function historico()
    {
        $dados = Estoque::orderBy('id', 'desc')->get();
        return view('estoque.historico')->with(compact('dados'));
    }

    public function create()
    {
        $fornecedores = Fornecedores::where('status', 'ATIVO')->get();
        //pega todos os produtos que ainda nao estao no estoque e que estejam ativos.
        //   $produtos = Produtos::where('status','=' ,'ATIVO')->doesntHave('estoque')->get();
        $produtos = Produtos::where('status', 'SIM')->get();

        return view('estoque.create')->with(compact('produtos', 'fornecedores'));
    }

    public function edit(Estoque $estoque, Request $request)
    {
        $produtos = Produtos::where('status', '=', 'ATIVO')->get();
        $fornecedores = Fornecedores::where('status', '=', 'ATIVO')->get();
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $dados = Estoque::find($request->id);
        return view('estoque.edit')->with(compact('produtos', 'fornecedores', 'dados'));
    }

    public function update(Estoque $estoque, Request $request)
    {
        $produto = Produtos::with('categoria', 'marca')->where('id', '=', $request->produto_id)->get()->last();

        $qtd = ($request->tipo == 'SAIDA') ? -$request->qtd : $request->qtd;
        $compra_id = (isset($request->compra_id)) ? $request->compra_id : null;

        $data = collect([]);
        $data = $data->merge([
            "produto_id"       => $request->produto_id,
            "tipo" => $request->tipo,
            "qtd" => $qtd,
            "compra_id" => $compra_id,
            "status"       => $request->status,
            "historico" => 'MOVIMENTO',
        ]);
        Estoque::find($request->id)->update($data->all());
        $dados = Estoque::get();
        return redirect()->route('estoque.index')->with(compact('dados'))->with('message-success', 'Registro Atualizado!');
    }

    public function store(Estoque $estoque, Request $request)
    {
        try {
            $qtd = ($request->tipo == 'SAIDA') ? -$request->qtd : $request->qtd;

            $produto = Produtos::find($request->produto_id);
            $estoque->tipo = $request['tipo'];
            $estoque->qtd = $qtd;
            $estoque->produto_id = $request['produto_id'];
            $estoque->status = $request['status'];
            $estoque->historico = 'MOVIMENTO';
            $estoque->save();

            $dados = Estoque::get();
        } catch (Exception $e) {
            return redirect()->route('estoque.index')->with('message-danger', 'Ocorreu um erro!');
        }
        return redirect()->route('estoque.index')->with(compact('dados'))->with('message-success', 'Registro Salvo!');
    }

    public function destroy(Request $request)
    {
        if (!$request->id) throw new \Exception("ID não informado!", 1);
        $estoque = Estoque::find($request->id)->delete();
        $dados = Estoque::get();
        return redirect()->route('estoque.index')->with(compact('dados'))->with('message-success', 'Registro Excluido!');
    }


    public function pesquisa(Request $request)
    {
        $fornecedores = Fornecedores::All();
        $categorias = Categorias::All();

        if ($request->tipo == 'DESCRICAO') {
            $query = Produtos::query();
            $query = ($request->tipo == 'DESCRICAO') ? $query->where('descricao', 'LIKE', '%' . $request->pesquisa . '%') : $query;
            $query = ($request->disponivel != 'TODOS') ? $query->where('status',  $request->disponivel) : $query;
            $dados = $query->get();

            $encontrados = [];
            foreach ($dados as $dado) {
                array_push($encontrados, $dado->id);
            }

            $lista = [];
            foreach ($encontrados as $dado) {

                $dados = Estoque::where('produto_id', $dado)->get();

                $soma = 0;
                foreach ($dados as $item) {
                    $soma = $soma + $item->qtd;
                }

                if ($soma >= 1) {
                    array_push($lista, $dado);
                }
            }

            $produtos =  ($request->em_estoque == 'SIM') ? $lista : $encontrados;
              
            $query = Estoque::query();
            $query = ($request->tipo == 'DESCRICAO') ? $query->whereIn('produto_id', $produtos) : $query;
            $query = $query->select('produto_id')->groupBy('produto_id');
            $dados = $query->get();
            // dd($dados);

            #total
            $query = Estoque::query();
            $query = ($request->tipo == 'DESCRICAO') ? $query->whereIn('produto_id', $produtos) : $query;
            $total = $query->sum('qtd');
        }

        if ($request->tipo == 'CODIGO') {
            $produto = Produtos::where('codigo', '=', $request->pesquisa)->first();
            $produto = (isset($produto->id)) ? $produto->id : null;
            $query = Estoque::query();
            $query = ($request->pesquisa != null) ? $query->where('produto_id', '=', $produto) : $query;
            $query = $query->select('produto_id')->groupBy('produto_id');
            $dados = $query->get();

            #total
            $query = Estoque::query();
            $query = ($request->pesquisa != null) ? $query->where('produto_id', '=', $produto) : $query;
            $query =  $query->where('status', 'SIM');
            $total = $query->sum('qtd');



        }

        if ($request->tipo == 'CATEGORIA') {
            $query = Produtos::query();
            $query = ($request->tipo == 'CATEGORIA') ? $query->where('categoria_id', 'LIKE', '%' . $request->categoria . '%') : $query;
            $dados = $query->get();
            $encontrados = [];
            foreach ($dados as $dado) {
                array_push($encontrados, $dado->id);
            }


            $lista = [];
            foreach ($encontrados as $dado) {
                $dados = Estoque::where('produto_id', $dado)->get();
                $soma = 0;
                foreach ($dados as $item) {
                    $soma = $soma + $item->qtd;
                }

                if ($soma >= 1) {
                    array_push($lista, $dado);
                }
            }

            $produtos =  ($request->em_estoque == 'SIM') ? $lista : $encontrados;


            $query = Estoque::query();
            $query = ($request->tipo == 'CATEGORIA') ? $query->whereIn('produto_id', $produtos) : $query;
            $query = $query->select('produto_id')->groupBy('produto_id');
            $dados = $query->get();

            #total
            $query = Estoque::query();
            $query = ($request->tipo == 'CATEGORIA') ? $query->whereIn('produto_id', $produtos) : $query;
            $query =  $query->where('status', 'SIM');
            $total = $query->sum('qtd');
        }

        if ($request->tipo == 'FORNECEDOR') {
            $query = Produtos::query();
            $query = ($request->tipo == 'FORNECEDOR') ? $query->where('fornecedor_id', 'LIKE', '%' . $request->fornecedor . '%') : $query;
            $dados = $query->get();
            $encontrados = [];
            foreach ($dados as $dado) {
                array_push($encontrados, $dado->id);
            }

            $lista = [];
            foreach ($encontrados as $dado) {
                $dados = Estoque::where('produto_id', $dado)->get();
                $soma = 0;
                foreach ($dados as $item) {
                    $soma = $soma + $item->qtd;
                }

                if ($soma >= 1) {
                    array_push($lista, $dado);
                }
            }

            $produtos =  ($request->em_estoque == 'SIM') ? $lista : $encontrados;
           

            $query = Estoque::query();
            $query = ($request->tipo == 'FORNECEDOR') ? $query->whereIn('produto_id', $produtos) : $query;
            $query = $query->select('produto_id')->groupBy('produto_id');
            $dados = $query->get();

            #total
            $query = Estoque::query();
            $query = ($request->tipo == 'FORNECEDOR') ? $query->whereIn('produto_id', $produtos) : $query;
            $query =  $query->where('status', 'SIM');
            $total = $query->sum('qtd');
        }

        return view('estoque.index', ['dados' => $dados, 'total' => $total, 'categorias' => $categorias, 'fornecedores' => $fornecedores]);
    }

    public function pesquisahistorico(Request $request)
    {
        if ($request->tipo == 'DESCRICAO') {
            $query = Produtos::query();
            $query = ($request->tipo == 'DESCRICAO') ? $query->where('descricao', 'LIKE', '%' . $request->pesquisa . '%') : $query;
            $dados = $query->get();
            $encontrados = [];
            foreach ($dados as $dado) {
                array_push($encontrados, $dado->id);
            }

            $query = Estoque::query();
            $query = ($request->tipo == 'DESCRICAO') ? $query->whereIn('produto_id', $encontrados) : $query;
            $dados = $query->get();
            return view('estoque.historico', ['dados' => $dados]);
        }
        if ($request->tipo == 'CODIGO') {
            $produto = Produtos::where('codigo', '=', $request->pesquisa)->first();
            $produto = (isset($produto->id)) ? $produto->id : null;
            $query = Estoque::query();
            $query = ($request->pesquisa != null) ? $query->where('produto_id', '=', $produto) : $query;
            $dados = $query->get();
            return view('estoque.historico', ['dados' => $dados]);
        }
    }

    public function totalprodutoid(Request $request)
    {
        $produto_id = ($request->pesquisa);
        #calcula o total de produtos disponiveis
        $produtosEncontrados = Estoque::where('produto_id', '=', $produto_id)->get();
        $total = 0;
        foreach ($produtosEncontrados as $produto) {
            $total = $total + $produto->qtd;
        }
        return $total;
    }
}
