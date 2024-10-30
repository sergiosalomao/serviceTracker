@extends('home')
@section('body')
<div class="card">
    <div class="card">
        @php
        $cliente = App\Models\Clientes::find(request('cliente_id'));
        @endphp
        <div class="card-header">
            <div class="row ">
                <div class="col-sm-6 esquerda titulo fw-media uppercase">
                    Historico de Compras | <span class=" fw-small-x ">Lista
                    </span>
                </div>
                <div class="col-sm-6 direita">
                    <span>{{$cliente['nome']}}</b></span>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body ">


    </div>

    <div class="table- m-3">
        <table class="table table-condensed table-striped">
            <thead>
                <th width="1%">
                    Compras Realizadas
                </th>

                </tr>
            </thead>
            @php
            $totalGeral = 0;
            @endphp

            @foreach ($itens->groupBy(['venda_id']) as $item)
            <tr>
                <td width="100%" style="height: 30px;">
                    <span class="titulo p-" style="margin-left: 1px;">
                        VENDA: [{{ $item[0]['venda'][0]['id']}}] | DATA COMPRA: {{ formatadata($item[0]['venda'][0]['data_compra'])}}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="10">
                    <table width="100%">
                        <tr>
                            <td class="titulo" style="text-align: left">ITEM</td>
                            <td class="titulo" style="text-align: center">CODIGO</td>
                            <td class="titulo">DESCRIÇÃO</td>
                            <td class="titulo" style="text-align: center">QTD</td>
                            <td class="titulo" style="text-align: left">VALOR</td>
                            <td class="titulo" style="text-align: left">TOTAL</td>
                        </tr>
                        <tbody>
                            @php
                            $itensCompras = \App\Models\ItensVendas::where('venda_id',$item[0]['venda'][0]['id'])->get();

                            $totalCompra = 0;
                            $totalItens = 0;

                            @endphp
                            @foreach ($itensCompras as $item)

                            <tr>
                                <td width="2%" style="text-align: center;">
                                    {{$loop->index +1}}
                                </td>
                                <td width="5%" style="text-align: center">
                                    {{$item->produto->codigo}}
                                </td>
                                <td width="60%" style="text-align: left">
                                    {{$item->produto->descricao}}
                                </td>
                                <td width="10%" style="text-align: center">
                                    {{$item->qtd}}
                                </td>
                                <td width="10%" style="text-align: left">
                                    {{ 'R$ ' . number_format($item->produto->valor_venda, 2, ',', '.') }}</span>
                                </td>
                                @php
                                $totalItens = $totalItens + $item->qtd;
                                $totalCompra = $totalCompra + ($item->produto->valor_venda * $item->qtd);
                                @endphp
                                <td width="10%" style="text-align: left">
                                    {{ 'R$ ' . number_format($item->produto->valor_venda * $item->qtd, 2, ',', '.') }}</span>
                                </td>

                            </tr>
                            <span hidden>{{$totalGeral += ($item->produto->valor_venda * $item->qtd)}}</span>

                            @endforeach

                        </tbody>

                        <tbody>

                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td width="10%" style="text-align: center;"><span class="badge bg-success"> {{$totalItens}} </span></td>
                                <td></td>
                                <td width="10%" style="text-align: left;"><span class="badge bg-success">
                                        {{ 'R$ ' . number_format($totalCompra, 2, ',', '.') }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>






                </td>
            </tr>
            @endforeach

        </table>
       
        <tbody>
            <table class="table table-condensed table-striped">
                <tr style="background-color: red;">
                    <td  width="450px"></td>
                    <td width="100px" style="text-align: center;" class=""><span class="fw-bold"> R$ {{number_format($totalGeral,2,',', '.')}}</span></td>
                </tr>
            </table>
        </tbody>
    </div>
</div>

<div class="mt-4" style="text-align: right">

<button class="btn btn-my-secondary" type="button" onclick="javascript:history.go(-1)">Voltar</button>
  <!--   <button class="btn btn-my-secondary" onclick="window.location.href='/clientes'">
        Voltar
    </button> -->
</div>
@endsection