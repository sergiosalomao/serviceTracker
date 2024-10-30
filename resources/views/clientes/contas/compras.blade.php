@extends('home')
@section('body')
<div class="card">
    <div class="card">
        @php
        $venda = App\Models\Vendas::find(request('id'));
        @endphp
        <div class="card-header">
            <div class="row ">
                <div class="col-sm-6 esquerda titulo fw-media uppercase">
                    Itens da Cobrança | <span class=" fw-small-x ">Lista
                    </span>
                </div>
                <div class="col-sm-6 direita">
                    <span>{{$venda['cliente']['nome']}} | <span>VENDA: <b>{{request('id')}}</b></span>
                </div>
            </div>
        </div>
        <div class="card-body ">

            @php
            $venda = App\Models\Vendas::find(request('id'));
            @endphp

            <div class="row p-3">
                <div class="col-6 texto-esquerda">

                </div>
                <div class="col-6 texto-direita">
                    {{-- <button class="btn btn-warning form-button" type="button"
                    onclick="window.location.href='/clientes/ranking'">
                    <img class="mx-1" src="{{ env('APP_LINK_IMAGES') }}ranking.svg" width="18px" height="18px">
                    Ranking
                    </button> --}}
                </div>
            </div>

            {{-- <div class="row p-3 ">
                <div class="col-12 ">
                    <form class="" action="{{ route('carrinho.pesquisa') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input class="form-control me-2 mx-2" type="search" name="pesquisa" placeholder="Pesquisar por nome ou codigo" aria-label="Search">

            </form>
        </div>
    </div>
    --}}

    <div class="table-responsive mt-3">
        <table class="table table-striped table-light text-black table-hover">
            <thead>
                <tr>
                    <th class="" style="text-align: left">CODIGO</th>
                    <!--  <th class="" style="text-align: center">IMAGEM</th> -->
                    <th class="" style="text-align: left">DESCRIÇÃO</th>
                    <th class="" style="text-align: center">QUANTIDADE</th>
                    <th class="" style="text-align: center">VALOR</th>
                    <th class="" style="text-align: center">TOTAL</th>

                </tr>
            </thead>
                @php
                $total = 0;
                $totalItens = 0;
                $status = null;
                @endphp
                @foreach ($dados as $item)
                @php
                $totalItens+=$item->qtd;
                @endphp
                <tr>
                    <td width="3%">
                        <span class="table-subtitulos"> {{ $item['produto']['codigo']  }}</span>
                    </td>

                    <!--     <td width="6%" style="text-align: center">
                                    <img src="{{ $item['produto']['capa'] }}" height="90px" width="75px"
                                        style="border: 1px solid black;object-fit: contain">
                                </td> -->


                    <td width="20%" style="text-align: left">
                        <span class="table-subtitulos"> {{ $item['produto']['descricao'] }}</span>
                    </td>

                    <td width="10%" style="text-align: center">
                        <span class="table-subtitulos"> {{ $item->qtd }}</span>
                    </td>

                    <td width="10%" style="text-align: center">
                        <span class="table-subtitulos"> {{ $item['produto']['valor_venda'] }}</span>
                    </td>

                    <td width="10%" style="text-align: center">
                        <span class="subtitulos cor-escura">
                            @php
                            $total = $total + $item['produto']['valor_venda'] * $item->qtd;
                            @endphp
                            {{ 'R$ ' . number_format($item['produto']['valor_venda'] * $item->qtd, 2, ',', '.') }}</span>
                    </td>
                    @if ($item->status == 'ATIVO')
                    <td width="8%" style="text-align: center">
                        <span class=" badge bg-success  cor-escura"> {{ $item->status }}</span>
                    </td>
                    @endIf
                    @if ($item->status == 'INATIVO')
                    <td width="8%" style="text-align: center">
                        <span class=" badge bg-danger  cor-escura"> {{ $item->status }}</span>
                    </td>
                    @endIf


                    {{-- <td>
                                {{ date('d-m-Y', strtotime($item->data)) }}
                    </td> --}}

                </tr>
                @endforeach
            <tbody>

                <tr>
                    <td style="text-align: center"><b></b></td>
                    <td></td>
                    <td style="text-align: center"><b>{{$totalItens}}</b></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        @if ($total == 0)
        <p><b><span class="titulo cor-escura">O Carrinho está vazio.</span></b></p>
        @endIf
        <span class="titulo"> Total do Carrinho: <b>{{ 'R$ ' . number_format($total, 2, ',', '.') }}</b></span>





        <div style="text-align: right">
            <button class="btn btn-my-secondary" onclick="window.location.href='/clientes/conta/{{request('cobranca_id')}}'">
                Voltar
            </button>

        </div>

    </div>

</div>
</div>
@include('layouts.paginacao')
@endsection