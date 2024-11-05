<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BonificacaoController;
use App\Http\Controllers\CampanhaController;
use App\Http\Controllers\CarnesController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\CobrancaController;
use App\Http\Controllers\CobrancasComprasController;
use App\Http\Controllers\CobrancasController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\CuponsController;
use App\Http\Controllers\DevolucaoController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\Financeiro\CentroCustoController;
use App\Http\Controllers\Financeiro\ContasController;
use App\Http\Controllers\Financeiro\FluxosController;
use App\Http\Controllers\Financeiro\FormasPagamentoController;
use App\Http\Controllers\Financeiro\MovimentosController;
use App\Http\Controllers\FornecedoresController;
use App\Http\Controllers\FotosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\ParcelasController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\ItensSolicitacoesController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\ServicosController;
use App\Http\Controllers\SolicitacoesController;
use App\Http\Controllers\VendasController;
use App\Models\CobrancasCompras;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/auth', [AuthController::class, 'auth'])->name('auth');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/', function () {
    return view('index');
});


Route::middleware('auth')->group(function () {
    Route::get('/sistema', [HomeController::class, 'index'])->name('home');



    Route::group(['prefix' => 'clientes'], function () {
        Route::get('/', [ClientesController::class, 'index'])->name('clientes.index');
        Route::get('/create', [ClientesController::class, 'create'])->name('clientes.create');
        Route::get('/edit/{id}', [ClientesController::class, 'edit'])->name('clientes.edit');
        Route::get('/detalhes/{id}', [ClientesController::class, 'detalhes'])->name('clientes.detalhes');
        Route::get('/delete/{id}', [ClientesController::class, 'destroy'])->name('clientes.destroy');
        Route::post('/update', [ClientesController::class, 'update'])->name('clientes.update');
        Route::post('/store', [ClientesController::class, 'store'])->name('clientes.store');
        Route::post('/storerapido', [ClientesController::class, 'storeRapido'])->name('clientes.storerapido');
        Route::post('/pesquisa', [ClientesController::class, 'pesquisa'])->name('clientes.pesquisa');
        Route::get('/historico/{id}', [ClientesController::class, 'historico'])->name('clientes.historico');

    });


    Route::group(['prefix' => 'fornecedores'], function () {
        Route::get('/', [FornecedoresController::class, 'index'])->name('fornecedores.index');
        Route::get('/create', [FornecedoresController::class, 'create'])->name('fornecedores.create');
        Route::get('/edit/{id}', [FornecedoresController::class, 'edit'])->name('fornecedores.edit');
        Route::get('/detalhes/{id}', [FornecedoresController::class, 'detalhes'])->name('fornecedores.detalhes');
        Route::get('/delete/{id}', [FornecedoresController::class, 'destroy'])->name('fornecedores.destroy');
        Route::post('/update', [FornecedoresController::class, 'update'])->name('fornecedores.update');
        Route::post('/store', [FornecedoresController::class, 'store'])->name('fornecedores.store');
        Route::post('/pesquisa', [FornecedoresController::class, 'pesquisa'])->name('fornecedores.pesquisa');
    });

    Route::group(['prefix' => 'marcas'], function () {
        Route::get('/', [MarcasController::class, 'index'])->name('marcas.index');
        Route::get('/create', [MarcasController::class, 'create'])->name('marcas.create');
        Route::get('/edit/{id}', [MarcasController::class, 'edit'])->name('marcas.edit');
        Route::get('/delete/{id}', [MarcasController::class, 'destroy'])->name('marcas.destroy');
        Route::post('/update', [MarcasController::class, 'update'])->name('marcas.update');
        Route::post('/store', [MarcasController::class, 'store'])->name('marcas.store');
        Route::post('/pesquisa', [MarcasController::class, 'pesquisa'])->name('marcas.pesquisa');
    });

    Route::group(['prefix' => 'categorias'], function () {
        Route::get('/', [CategoriasController::class, 'index'])->name('categorias.index');
        Route::get('/create', [CategoriasController::class, 'create'])->name('categorias.create');
        Route::get('/edit/{id}', [CategoriasController::class, 'edit'])->name('categorias.edit');
        Route::get('/delete/{id}', [CategoriasController::class, 'destroy'])->name('categorias.destroy');
        Route::post('/update', [CategoriasController::class, 'update'])->name('categorias.update');
        Route::post('/store', [CategoriasController::class, 'store'])->name('categorias.store');
        Route::post('/pesquisa', [CategoriasController::class, 'pesquisa'])->name('categorias.pesquisa');
    });



    Route::group(['prefix' => 'servicos'], function () {
        Route::get('/', [ServicosController::class, 'index'])->name('servicos.index');
        Route::get('/create', [ServicosController::class, 'create'])->name('servicos.create');
        Route::get('/edit/{id}', [ServicosController::class, 'edit'])->name('servicos.edit');
        Route::get('/delete/{id}', [ServicosController::class, 'destroy'])->name('servicos.destroy');
        Route::post('/update', [ServicosController::class, 'update'])->name('servicos.update');
        Route::post('/store', [ServicosController::class, 'store'])->name('servicos.store');
        Route::get('/pesquisa', [ServicosController::class, 'pesquisa'])->name('servicos.pesquisa');
        Route::get('/pesquisaPorId', [ServicosController::class, 'pesquisaPorId'])->name('servicos.pesquisaPorId');
        Route::get('/rastrear/{id}', [ServicosController::class, 'rastrear'])->name('servicos.rastrear');
    });


    Route::group(['prefix' => 'solicitacoes'], function () {
        Route::get('/', [SolicitacoesController::class, 'index'])->name('solicitacoes.index');
        Route::get('/create', [SolicitacoesController::class, 'create'])->name('solicitacoes.create');
        Route::get('/edit/{id}', [SolicitacoesController::class, 'edit'])->name('solicitacoes.edit');
        Route::get('/delete/{id}', [SolicitacoesController::class, 'destroy'])->name('solicitacoes.destroy');
        Route::post('/update', [SolicitacoesController::class, 'update'])->name('solicitacoes.update');
        Route::post('/alterar', [SolicitacoesController::class, 'alterar'])->name('solicitacoes.alterar');
        Route::post('/store', [SolicitacoesController::class, 'store'])->name('solicitacoes.store');
        Route::post('/pesquisa', [SolicitacoesController::class, 'pesquisa'])->name('solicitacoes.pesquisa');
        Route::get('/pagamento/{id}/{valor}', [SolicitacoesController::class, 'pagamento'])->name('solicitacoes.pagamento');
        Route::get('/cancela/{id}', [SolicitacoesController::class, 'cancela'])->name('solicitacoes.cancela');
        Route::get('/finalizar/{id}', [SolicitacoesController::class, 'finalizar'])->name('solicitacoes.finaliza');
    });

    Route::group(['prefix' => 'cobrancas'], function () {
        Route::get('/', [CobrancaController::class, 'index'])->name('cobrancas.index');
        Route::get('/create', [CobrancaController::class, 'create'])->name('cobrancas.create');
        Route::get('/edit/{id}', [CobrancaController::class, 'edit'])->name('cobrancas.edit');
        Route::get('/delete/{id}', [CobrancaController::class, 'destroy'])->name('cobrancas.destroy');
        Route::post('/update', [CobrancaController::class, 'update'])->name('cobrancas.update');
        Route::post('/alterar', [CobrancaController::class, 'alterar'])->name('cobrancas.alterar');
        Route::post('/store', [CobrancaController::class, 'store'])->name('cobrancas.store');
        Route::post('/pesquisa', [CobrancaController::class, 'pesquisa'])->name('cobrancas.pesquisa');
        Route::get('/pagamento/{id}/{valor}', [CobrancaController::class, 'pagamento'])->name('cobrancas.pagamento');
        Route::get('/cancela/{id}', [CobrancaController::class, 'cancela'])->name('cobrancas.cancela');
        Route::get('/finalizar/{id}', [CobrancaController::class, 'finalizar'])->name('cobrancas.finaliza');
    });

    Route::group(['prefix' => 'pagamentos'], function () {
        Route::get('/{cobranca_id}', [PagamentoController::class, 'index'])->name('pagamentos.index');
        Route::get('/cancelar/{cobranca_id}/{id}', [PagamentoController::class, 'cancelar'])->name('pagamentos.cancelar');
        Route::get('/baixar/{cobranca_id}/{id}', [PagamentoController::class, 'baixar'])->name('pagamentos.baixar');
    });


    Route::group(['prefix' => 'carrinho'], function () {
        Route::get('/{id}', [ItensSolicitacoesController::class, 'index'])->name('carrinho.index');
        Route::get('/create/{id}', [ItensSolicitacoesController::class, 'create'])->name('carrinho.create');
        Route::get('/edit/{id}', [ItensSolicitacoesController::class, 'edit'])->name('carrinho.edit');
        Route::get('/delete/{id}/{venda_id}', [ItensSolicitacoesController::class, 'destroy'])->name('carrinho.destroy');
        Route::post('/update', [ItensSolicitacoesController::class, 'update'])->name('carrinho.update');
        Route::post('/store', [ItensSolicitacoesController::class, 'store'])->name('carrinho.store');
        Route::post('/pesquisa', [ItensSolicitacoesController::class, 'pesquisa'])->name('carrinho.pesquisa');
        Route::get('/limpa/{id}/', [ItensSolicitacoesController::class, 'limpa'])->name('carrinho.limpa');
    });


    /* financeiro */


    Route::group(['prefix' => 'financeiro/centros'], function () {
        Route::get('/', [CentroCustoController::class, 'index'])->name('centros.index');
        Route::get('/create', [CentroCustoController::class, 'create'])->name('centros.create');
        Route::get('/edit/{id}', [CentroCustoController::class, 'edit'])->name('centros.edit');
        Route::get('/delete/{id}', [CentroCustoController::class, 'destroy'])->name('centros.destroy');
        Route::post('/update', [CentroCustoController::class, 'update'])->name('centros.update');
        Route::post('/store', [CentroCustoController::class, 'store'])->name('centros.store');
    });

    Route::group(['prefix' => 'financeiro/contas'], function () {
        Route::get('/', [ContasController::class, 'index'])->name('contas.index');
        Route::get('/create', [ContasController::class, 'create'])->name('contas.create');
        Route::get('/edit/{id}', [ContasController::class, 'edit'])->name('contas.edit');
        Route::get('/delete/{id}', [ContasController::class, 'destroy'])->name('contas.destroy');
        Route::post('/update', [ContasController::class, 'update'])->name('contas.update');
        Route::post('/store', [ContasController::class, 'store'])->name('contas.store');
    });


    Route::group(['prefix' => 'financeiro/fluxos'], function () {
        Route::get('/', [FluxosController::class, 'index'])->name('fluxos.index');
        Route::get('/create', [FluxosController::class, 'create'])->name('fluxos.create');
        Route::get('/edit/{id}', [FluxosController::class, 'edit'])->name('fluxos.edit');
        Route::get('/delete/{id}', [FluxosController::class, 'destroy'])->name('fluxos.destroy');
        Route::post('/update', [FluxosController::class, 'update'])->name('fluxos.update');
        Route::post('/store', [FluxosController::class, 'store'])->name('fluxos.store');
    });


    Route::group(['prefix' => 'financeiro/movimentos'], function () {
        Route::get('/', [MovimentosController::class, 'index'])->name('movimentos.index');
        Route::get('/create', [MovimentosController::class, 'create'])->name('movimentos.create');
        Route::get('/edit/{id}', [MovimentosController::class, 'edit'])->name('movimentos.edit');
        Route::get('/delete/{id}', [MovimentosController::class, 'destroy'])->name('movimentos.destroy');
        Route::post('/update', [MovimentosController::class, 'update'])->name('movimentos.update');
        Route::post('/store', [MovimentosController::class, 'store'])->name('movimentos.store');
        Route::post('/pesquisa', [MovimentosController::class, 'pesquisa'])->name('movimentos.pesquisa');
        Route::get('/lancamentos', [MovimentosController::class, 'lancamentos'])->name('movimentos.lancamentos');
        Route::get('/fluxo-caixa', [MovimentosController::class, 'fluxoCaixa'])->name('movimentos.fluxo-caixa');
        Route::get('/fluxo-consolidado', [MovimentosController::class, 'fluxoConsolidado'])->name('movimentos.fluxo-consolidado');
        Route::get('/pdf', [MovimentosController::class, 'gerarPDF'])->name('movimentos.gerapdf');
    });

    Route::group(['prefix' => 'financeiro/formas-pagamento'], function () {
        Route::get('/', [FormasPagamentoController::class, 'index'])->name('formas-pagamento.index');
        Route::get('/create', [FormasPagamentoController::class, 'create'])->name('formas-pagamento.create');
        Route::get('/edit/{id}', [FormasPagamentoController::class, 'edit'])->name('formas-pagamento.edit');
        Route::get('/delete/{id}', [FormasPagamentoController::class, 'destroy'])->name('formas-pagamento.destroy');
        Route::post('/update', [FormasPagamentoController::class, 'update'])->name('formas-pagamento.update');
        Route::post('/store', [FormasPagamentoController::class, 'store'])->name('formas-pagamento.store');
    });


    /* Campanhas e Cupons */


    Route::group(['prefix' => 'campanhas'], function () {
        Route::get('/', [CampanhaController::class, 'index'])->name('campanhas.index');
        Route::get('/create', [CampanhaController::class, 'create'])->name('campanhas.create');
        Route::get('/edit/{id}', [CampanhaController::class, 'edit'])->name('campanhas.edit');
        Route::get('/links/{id}', [CampanhaController::class, 'links'])->name('campanhas.links');
        Route::get('/delete/{id}', [CampanhaController::class, 'destroy'])->name('campanhas.destroy');
        Route::post('/update', [CampanhaController::class, 'update'])->name('campanhas.update');
        Route::post('/store', [CampanhaController::class, 'store'])->name('campanhas.store');
        Route::get('/atualiza-status/{id}', [CampanhaController::class, 'atualizaStatus'])->name('campanhas.atualiza-status');
        Route::get('/envia-cupom/{id?}/{cliente?}', [CampanhaController::class, 'enviaCupom'])->name('campanhas.envia-cupom');
        Route::get('/envios', [CampanhaController::class, 'envios'])->name('lembretes.index');
        Route::post('/pesquisaenvios', [CampanhaController::class, 'pesquisaenvios'])->name('campanhas.pesquisaenvios');
    });


    Route::group(['prefix' => 'cupons'], function () {
        Route::get('/{id}', [CuponsController::class, 'index'])->name('cupons.index');
        Route::get('/create', [CuponsController::class, 'create'])->name('cupons.create');
        Route::get('/edit/{id}', [CuponsController::class, 'edit'])->name('cupons.edit');
        Route::get('/delete/{id}', [CuponsController::class, 'destroy'])->name('cupons.destroy');
        Route::post('/update', [CuponsController::class, 'update'])->name('cupons.update');
        Route::post('/store', [CuponsController::class, 'store'])->name('cupons.store');
        Route::get('/atualiza-status/{id}', [CuponsController::class, 'atualizaStatus'])->name('cupons.atualiza-status');
        Route::get('/gera-qrcode/{id}', [CuponsController::class, 'geraQrcode'])->name('cupons.gera-qrcode');
    });
});
