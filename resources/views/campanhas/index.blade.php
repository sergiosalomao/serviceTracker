@extends('home')
@section('body')
    <div class="card">

        <div class="card-header titulo-form "><i class="fa-solid fa fa-bullhorn  mx-1"></i>
            Lista de Campanhas
        </div>
        <div class="card-body ">

            <button class="btn btn-my-primary form-button" type="button"
                onclick="window.location.href='/campanhas/create'">Adicionar</button>

            <div class="table-responsive mt-3">
                <table class="table table-striped table-light text-black table-hover">
                    <thead>
                        <tr>
                            <th class="texto-centro">#</th>
                            <th class="texto-centro">INICIO</th>
                            <th>TITULO</th>
                            <th class="texto-centro">GERA CUPOM</th>
                            <th class="texto-centro">CUPONS GERADOS</th>
                            <th class="texto-centro">CUPONS ENTREGUES</th>
                            <th class="texto-centro">CUPONS USADOS</th>
                            <th class="texto-centro">DESCONTO</th>
                            <th class="texto-centro">EXPIRA EM</th>
                            <th class="texto-centro">STATUS</th>

                            <th style="text-align: center">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dados as $item)
                            <tr>
                                <td width="2%">
                                    <img src="{{ env('APP_LINK_IMAGES') }}campanha.svg" width="18px" height="18px"></a>

                                </td>
                                <td width="10%" class="texto-centro">
                                    {{ $item->created_at->format('d-m-Y') }}
                                </td>
                                <td width="25%">
                                    <p>{{ $item->titulo }}</p>

                                </td>


                                @if ($item->gera_cupom == 'SIM')
                                    <td style="text-align: center; " width="5%">
                                        <span class="badge bg-success ">SIM</span>
                                    </td>
                                @endIf
                                @if ($item->gera_cupom == 'NAO')
                                    <td style="text-align: center; " width="5%">
                                        <span class="badge bg-danger ">NAO</span>
                                    </td>
                                @endIf



                                @if ($item->gera_cupom == 'SIM')
                                    <td width="5%" class="texto-centro">
                                        {{ $item->qtd_cupons }}
                                    </td>
                                @endIf

                                @if ($item->gera_cupom == 'NAO')
                                    <td width="5%" class="texto-centro">
                                        --
                                    </td>
                                @endIf
                                {{-- Verifica se foi entregue --}}
                                <span hidden>
                                    {{ $entregue = 0 }}
                                    @foreach ($item->cupom as $cup)
                                        @if ($cup->status == 'ENTREGUE')
                                            {{ $entregue++ }}
                                        @endIf
                                    @endforeach
                                </span>

                                @if ($item->gera_cupom == 'SIM')
                                    <td width="5%" class="texto-centro">
                                        {{ $entregue }}
                                    </td>
                                @endIf
                                @if ($item->gera_cupom == 'NAO')
                                    <td width="5%" class="texto-centro">
                                        --
                                    </td>
                                @endIf


                                {{-- Verifica se foi usado --}}
                                <span hidden>
                                    {{ $usados = 0 }}
                                    @foreach ($item->cupom as $cup)
                                        @if ($cup->status == 'USADO')
                                            {{ $usados++ }}
                                        @endIf
                                    @endforeach
                                </span>
                                @if ($item->gera_cupom == 'SIM')
                                    <td width="5%" class="texto-centro">
                                        {{ $usados }}
                                    </td>
                                @endIf
                                @if ($item->gera_cupom == 'NAO')
                                    <td width="5%" class="texto-centro">
                                        --
                                    </td>
                                @endIf
                                @if ($item->gera_cupom == 'SIM')
                                    <td width="5%" class="texto-centro">
                                        R$ {{ number_format($item->desconto, 2, ',', '.') }}
                                    </td>
                                @endIf
                                @if ($item->gera_cupom == 'NAO')
                                    <td width="5%" class="texto-centro">
                                        --
                                    </td>
                                @endIf
                                <td width="15%" class="texto-centro">
                                    {{ date('d-m-Y', strtotime($item->limite)) }}
                                </td>
                                @if ($item->status == 'ATIVO')
                                    <td width="5%" class="texto-centro">
                                        <span class="badge bg-success ">{{ $item->status }}</span>
                                    </td>
                                @endIf
                                @if ($item->status == 'INATIVO')
                                    <td width="5%" class="texto-centro">
                                        <span class="badge bg-danger ">{{ $item->status }}</span>
                                    </td>
                                @endIf

                                <td width="5%">
                                    <div class=" d-flex align-items-center">
                                        @if ($item->status == 'ATIVO')
                                            <a class="btn-imagens" href="/campanhas/atualiza-status/{{ $item->id }}">
                                                <img src="{{ env('APP_LINK_IMAGES') }}stop.svg" width="18px"
                                                    height="18px"></a>
                                        @endIf

                                        @if ($item->status == 'INATIVO')
                                            <a class="btn-imagens" href="/campanhas/atualiza-status/{{ $item->id }}">
                                                <img src="{{ env('APP_LINK_IMAGES') }}play.svg" width="18px"
                                                    height="18px"></a>
                                        @endIf

                                        <a class="btn-imagens" href="/campanhas/edit/{{ $item->id }}">
                                            <img src="{{ env('APP_LINK_IMAGES') }}edit.svg" width="18px"
                                                height="18px"></a>

                                        @if ($item->foto_path != null)
                                            <a class="btn-imagens" href="/campanhas/links/{{$item->id}}" >
                                                <img src="{{ env('APP_LINK_IMAGES') }}link.png" width="18px"
                                                    height="18px"></a>
                                        @endIf

                                        @if ($item->foto_path == null)
                                            <a class="btn-imagens" href="" style="opacity: 30%">
                                                <img src="{{ env('APP_LINK_IMAGES') }}link.png" width="18px"
                                                    height="18px"></a>
                                        @endIf


                                        @if ($item->gera_cupom == 'SIM')
                                            <a class="btn-imagens" href="/cupons/{{ $item->id }}">
                                                <img src="{{ env('APP_LINK_IMAGES') }}cupom.svg" width="18px"
                                                    height="18px"></a>
                                        @endIf
                                        @if ($item->gera_cupom == 'NAO')
                                            <a class="btn-imagens" href="" style="opacity: 30%">
                                                <img src="{{ env('APP_LINK_IMAGES') }}cupom.svg" width="18px"
                                                    height="18px"></a>
                                        @endIf

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="text-align: right">
                    <button class="btn btn-my-secondary" type="button"
                        onclick="window.location.href='/sistema'">Voltar</button>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.paginacao')
@endsection
