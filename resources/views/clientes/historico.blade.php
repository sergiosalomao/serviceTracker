@extends('home')
@section('body')
<div class="card">
    <div class="card">
        <div class="card-header">
            <div class="row ">
                <div class="col-sm-6 esquerda titulo fw-media uppercase">
                    Historico de Compras | <span class=" fw-small-x ">Lista
                    </span>
                </div>
                <div class="col-sm-6 direita">
                    <span>{{$dados[0]['cliente']['nome']}}</span> </b></span>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row p-3">
                <div class="col-6 texto-esquerda">
                    <button class="btn btn-my-primary form-button " type="button" onclick="window.location.href='/produtos/create'">Adicionar</button>
                </div>
                <div class="col-6 texto-direita">
                    <button class="btn btn-my-primary form-button" type="button" onclick="window.location.href='/clientes/itenscompras/{{ request('id') }}'">
                        <img class="mx-1" src="{{ env('APP_LINK_IMAGES') }}carrinho.png" width="18px" height="18px">
                        Mostrar Itens de Compras
                    </button>
                    <button class="btn btn-my-primary form-button" type="button" onClick="javascript:window.open('{{ route('relatorios.contacliente', ['id' => request('id')]) }}', '_blank');" >
                        <img class="mx-1" src="{{ env('APP_LINK_IMAGES') }}printconsolidado.png" width="18px" height="18px">
                        Imprimir Compras Abertas Consolidado
                    </button>
                    <button class="btn btn-my-primary form-button" type="button" onClick="javascript:window.open('{{ route('relatorios.contaclientedetalhado', ['id' => request('id')]) }}', '_blank');" >
                        <img class="mx-1" src="{{ env('APP_LINK_IMAGES') }}detail.png" width="18px" height="18px">
                        Imprimir Compras Abertas Detalhadas
                    </button>
                    <button class="btn btn-my-primary form-button mt-4" type="button" onClick="javascript:window.open('{{ route('relatorios.contaclientegeral', ['id' => request('id')]) }}', '_blank');" >
                        <img class="mx-1" src="{{ env('APP_LINK_IMAGES') }}detail.png" width="18px" height="18px">
                        Imprimir Geral
                    </button>
                </div>
            </div>

            <div class="row p-3 ">
                <div class="col-sm-12 ">

                    <form class="" action="{{ route('clientes.conta.pesquisa') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @php
                            $cliente_id = (isset($cliente_id))?$cliente_id:request('id')
                            @endphp
                            <input name="cliente_id" value="{{$cliente_id}}" hidden>
                            <div class="col-sm-2 mb-2"><label class="fw-bold subtitulos">Data Inicial</label>
                                <input id="dtini" class="form-control me-2" type="date" name="dtini" placeholder="" aria-label="date">
                            </div>
                            <div class="col-sm-2 "><label class="fw-bold subtitulos">Data Final</label>
                                <input id="dtini" class="form-control me-2" type="date" name="dtfim" placeholder="" aria-label="Search">
                            </div>

                            <div class="col-sm-2 mb-2"><label class="fw-bold subtitulos">Status</label>
                                <select id="status" name="status" type="text" class="form-select mb-4">
                                    <option value="">TODAS</option>
                                    <option value="ABERTA" selected>ABERTA</option>
                                    <option value="PAGA">PAGA</option>
                                </select>
                            </div>
                            <div class="col-sm-6 texto-direita">
                                <button class="btn btn-my-primary form-button mt-4 " type="submit">Pesquisar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>


            <div class="table-responsive mt-3">
                <table class="table table-striped table-light text-black table-hover">
                    <thead>
                        <tr>
                            <th class="" style="text-align: center">NR.</th>
                            <th class="" style="text-align: center">VENDA</th>
                            <th class="" style="text-align: center">DATA VENDA</th>
                            <th class="" style="text-align: center">PARCELADO</th>
                            <th class="" style="text-align: center">FORMA PAGAMENTO</th>
                            <th class="" style="text-align: center">PRINCIPAL</th>
                            <th class="" style="text-align: center">DESC.(%)</th>
                            <th class="" style="text-align: center">DESCONTO</th>
                            <th class="" style="text-align: center">ENTRADA</th>
                            <th class="" style="text-align: center">PAGO</th>
                            <th class="" style="text-align: center">SALDO DEVEDOR</th>
                            <th class="" style="text-align: center">STATUS</th>
                            <th class="" colspan="3" style="text-align: center">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dados as $item)
                        <tr>
                            <td width="2%" style="text-align: center">
                                <span class="table-subtitulos cor-escura"> {{ $loop->index + 1 }}</span>
                            </td>
                            <td width="2%" style="text-align: center">
                                <span class="table-subtitulos cor-escura"> {{ $item['venda_id'] }}</span>
                            </td>
                            <td width="10%" style="text-align: center">
                                {{ date('d/m/Y', strtotime($item['venda']['data_compra'])) }}
                            </td>

                            <!--   <td width="20%" style="text-align: left">
                            <span class="table-subtitulos cor-escura"> {{ $item['cliente']['nome'] }}</span>
                        </td> -->
                            {{-- {{$item}} --}}
                            @if ($item->qtd_parcelas > 1)
                            <td width="10%" style="text-align: center">
                                {{-- <span class="badge bg-info">SIM</span> --}}
                                <span class="badge bg-dark"> {{ $item->qtd_parcelas }} PARCELAS</span>
                            </td>
                            @endIf
                            @if ($item->qtd_parcelas == 1)
                            <td width="10%" style="text-align: center">
                                <span class="badge bg-success">A VISTA</span>
                            </td>
                            @endIf

                            @if (isset($item['venda']['formapagamento']['forma']))
                            <td width="10%" style="text-align: center">
                                <span class="table-subtitulos cor-escura">{{$item['venda']['formapagamento']['forma']}}</span>
                            </td>
                            @endif

                            @php
                            $parcelas = \App\Models\Parcelas::where('cobranca_id', $item->id)->where('cliente_id',$item->cliente_id)->get();
                            $valor_pago = 0;
                            foreach ($parcelas as $itemParcela) {
                            $valor_pago = $valor_pago + $itemParcela->valor_pago ;
                            }
                            @endphp


                            <td width="10%" style="text-align: center">
                                <span class="subtitulos cor-escura fw-bold">
                                    {{ 'R$ ' . number_format($item->valor, 2, ',', '.') }}</span>
                            </td>

                            <td width="10%" style="text-align: center">
                                <span class="subtitulos cor-escura">
                                    {{ number_format($item->desconto_porcento, 2, ',', '.') }}</span>
                            </td>
                            <td width="10%" style="text-align: center">
                                <span class="subtitulos cor-escura">
                                    {{ 'R$ ' . number_format($item->desconto, 2, ',', '.') }}</span>
                            </td>
                            <td width="10%" style="text-align: center">
                                <span class="subtitulos cor-escura">
                                    {{ 'R$ ' . number_format($item->entrada, 2, ',', '.') }}</span>
                            </td>

                            <td width="10%" style="text-align: center">
                                <span class="subtitulos cor-escura">
                                    {{ 'R$ ' . number_format($valor_pago , 2, ',', '.') }}</span>
                            </td>

                            @php
                            $saldo = $item->valor - ($item->entrada + $valor_pago+ $item->desconto);
                            @endphp
                            <td width="10%" style="text-align: center">
                                <span class="subtitulos cor-escura">
                                    {{ 'R$ ' . number_format($saldo, 2, ',', '.') }}</span>
                            </td>



                            @if ($item->status == 'ABERTA')
                            <td width="10%" style="text-align: center">
                                <span class=" badge bg-warning  cor-escura"> {{ $item->status }}</span>
                            </td>
                            @endIf

                            @if ($item->status == 'PAGA')
                            <td width="10%" style="text-align: center">

                                <span class="badge bg-success  cor-escura"> {{ $item->status }}</span>
                            </td>
                            @endIf
                            @if ($item->status == 'CANCELADA')
                            <td width="10%" style="text-align: center">

                                <span class="badge bg-danger  cor-escura"> {{ $item->status }}</span>
                            </td>
                            @endIf
                            @if ($item->status == null)
                            <td width="10%" style="text-align: center">

                                <span class="badge bg-success  cor-escura">NAO DEFINIDO</span>
                            </td>
                            @endIf

                            {{-- <td>
                                {{ date('d-m-Y', strtotime($item->data)) }}
                            </td> --}}

                            <td width="3%">
                                <div class=" d-flex align-items-center">
                                    @if ($item->status != 'CANCELADA' )
                                    <a class="btn-imagens" href="/clientes/conta/detalhes/{{ $item->id }}/{{ $cliente_id }}">
                                        <img src="{{ env('APP_LINK_IMAGES') }}search.svg" width="18PX" height="18PX"></a>

                                    <a class="btn-imagens" href="/clientes/conta/compras/{{ $item->venda_id }}/{{ $cliente_id }}">
                                        <img src="{{ env('APP_LINK_IMAGES') }}carrinho.png" width="18PX" height="18PX"></a>

                                        <a class="btn-imagens" href="{{ route('relatorios.contaclientedetalhadoindividual', ['venda_id' => $item->venda_id,'cliente_id'=>request('id')]) }}" target="_blank">
                                            <img src="{{ env('APP_LINK_IMAGES') }}print.png" width="18PX" height="18PX">
                                        </a> 

                                    @endIf
                                </div>
                            </td>


                        </tr>
                        @endforeach

                    </tbody>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: center"><b>{{ 'R$ ' . number_format($total, 2, ',', '.') }}</b></td>
                            <td></td>
                            <td style="text-align: center"><b>{{ 'R$ ' . number_format($descontos, 2, ',', '.') }}</b></td>
                            <td style="text-align: center"><b>{{ 'R$ ' . number_format($entradas, 2, ',', '.') }}</b></td>
                            <td style="text-align: center"><b>{{ 'R$ ' . number_format($pago, 2, ',', '.') }}</b></td>
                            <td style="text-align: center"><b>{{ 'R$ ' . number_format($devedor - ($pago+$entradas), 2, ',', '.') }}</b></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>

                </table>
                <div style="text-align: right">
                    <button class="btn btn-my-secondary" onclick="window.location.href='/clientes'">
                        Voltar
                    </button>
                </div>

            </div>

        </div>
    </div>
    @include('layouts.paginacao')
    @endsection