@extends('home')
@section('body')
    <div class="card">
        <div class="card-header titulo-form ">
            Estoque
        </div>
        <div class="card-body ">


            <div class="row p-3">
                <div class="col-6 texto-esquerda">
                   {{--  <button class="btn btn-my-primary form-button " type="button"
                        onclick="window.location.href='/servicos/create'">Adicionar</button> --}}
                </div>
                <div class="col-6 texto-direita">
                    {{--   <button class="btn btn-warning form-button" type="button"
                    onclick="window.location.href='/clientes/ranking'">
                    <img class="mx-1" src="{{ env('APP_LINK_IMAGES') }}ranking.svg" width="18px" height="18px">
                    Ranking
                </button> --}}
                </div>
            </div>

            <div class="row p-3 ">
                <div class="col-12 ">
                    <form class="" action="{{ route('servicos.pesquisa') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input class="form-control me-2 mx-2" type="search" name="pesquisa"
                            placeholder="Pesquisar por descricao ou codigo do produto" aria-label="Search">

                    </form>
                </div>
            </div>


            <div class="table-responsive mt-3">
                <table class="table table-striped table-light text-black table-hover">
                    <thead>
                        <tr>
                            <th class="" style="text-align: center">CODIGO</th>
                        <!--     <th class="" style="text-align: left">IMAGEM</th> -->
                            <th class="" style="text-align: left">MARCA</th>
                            <th class="" style="text-align: left">DESCRIÇÃO</th>
                            <th class="" style="text-align: center">UND</th>
                            <th class="" style="text-align: center">QTD</th>
                            <th class="" style="text-align: center">P. UNITÁRIO</th>
                            <th class="" style="text-align: center">P.VENDA</th>
                            <th class="" style="text-align: center">QTD. MIN</th>
                            <th class="" style="text-align: center">QTD. MAX</th>
                          {{--   <th class="" style="text-align: center">Margem de Lucro(%)</th> --}}
                            <th class="" style="text-align: center">DISPONIVEL</th>
                            <th class="" colspan="3" style="text-align: center">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dados as $item)
                            <tr>
                                <td>
                                    <span class="table-subtitulos cor-escura"> {{ $item->id }}</span>
                                </td>

                              <!--   <td width="10%">
                                    <img src="{{ $item->produto['capa'] }}" height="90px" width="75px"
                                        style="border: 1px solid black;object-fit: contain">
                                </td> -->

                                <td width="10%" style="text-align: left">
                                    <span class="table-subtitulos cor-escura"> {{ $item['marca']['marca'] }}</span>
                                </td>

                                <td>
                                    <span class="table-subtitulos cor-escura" style="text-align: center">
                                        {{ $item['produto']['descricao'] }}</span>
                                </td>
                                <td width="7%" style="text-align: center">
                                    <span class="table-subtitulos cor-escura" style="text-align: center">
                                        {{ $item->und }}</span>
                                </td>
                              
                                <td width="7%" style="text-align: center">
                                    <span class="table-subtitulos cor-escura" style="text-align: center">
                                        {{ $item->qtd }}</span>
                                </td>
                             
                                <td width="7%" style="text-align: center">
                                    <span class="table-subtitulos cor-escura">
                                        {{ 'R$ ' . number_format($item->valor_compra, 2, ',', '.') }}</span>
                                </td>
                                <td width="7%" style="text-align: center">
                                    <span class="table-subtitulos cor-escura">
                                        {{ 'R$ ' . number_format($item->venda, 2, ',', '.') }}</span>
                                </td>
                                <td width="7%" style="text-align: center">
                                    <span class="table-subtitulos cor-escura" style="text-align: center">
                                        {{ $item->qtd_min }}</span>
                                </td>
                                <td width="7%" style="text-align: center">
                                    <span class="table-subtitulos cor-escura" style="text-align: center">
                                        {{ $item->qtd_max }}</span>
                                </td>

                              {{--   <td style="text-align: center">
                                    <span class="table-subtitulos cor-escura">
                                        {{ 'R$ ' . number_format($item->valor + $item->valor * ($item->margem_lucro / 100), 0, ',', '.') }}</span>
                                </td> --}}
                                @if ($item->status == 'SIM')
                                <td style="text-align: center">
                                    <span class=" badge bg-success  cor-escura"> {{ $item->status }}</span>
                                </td>
                                @endIf

                                @if ($item->status == 'NAO')
                                <td style="text-align: center">
                                 
                                    <span class="badge bg-danger  cor-escura"> {{ $item->status }}</span>
                                </td>
                                @endIf


                                {{--   <td>
                                {{ date('d-m-Y', strtotime($item->data)) }}
                            </td> --}}

                                <td width="5%">
                                    <div class=" d-flex align-items-center">
                                        <a class="btn-imagens" href="/estoque/edit/{{ $item->id }}">
                                            <img src="{{ env('APP_LINK_IMAGES') }}edit.png" width="18PX"
                                                height="18PX"></a>
                                        <a class="btn-imagens"
                                            onclick="setaDadosModal('window.location.href=\'/estoque/delete/{{ $item->id }}\'')"
                                            data-toggle="modal" data-target="#delete-modal">
                                            <img src="{{ env('APP_LINK_IMAGES') }}trash.svg" width="18PX"
                                                height="18PX">
                                        </a>
                                    </div>
                                </td>


                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div style="text-align: right">
                    <button class="btn btn-my-secondary" onclick="window.location.href='/sistema'">
                        Voltar
                    </button>
                </div>

            </div>

        </div>
    </div>
    @include('layouts.paginacao')
  

@endsection
