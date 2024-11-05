@extends('home')
@section('body')

<div class="card">
    <div class="card-header titulo-form ">
        Lista de Serviços
    </div>
    <div class="card-body ">

        <div class="row p-3">
            <div class="col-6 texto-esquerda">
                <button class="btn btn-my-primary form-button " type="button" onclick="window.location.href='/servicos/create'">Adicionar</button>
            </div>
            <div class="col-6 texto-direita">
                {{-- <button class="btn btn-warning form-button" type="button"
                    onclick="window.location.href='/clientes/ranking'">
                    <img class="mx-1" src="{{ env('APP_LINK_IMAGES') }}ranking.svg" width="18px" height="18px">
                Ranking
                </button> --}}
            </div>
        </div>

        <div class="row p-3 ">
            <div class="col-12 ">
                <form class="" action="{{ route('servicos.pesquisa') }}" method="GET" enctype="multipart/form-data">
                    @csrf
                    <input class="form-control me-2 mx-2" type="search" name="pesquisa" placeholder="Pesquisar por nome ou codigo" aria-label="Search">

                </form>
            </div>
        </div>


        <div class="table-responsive mt-3">
            <table class="table table-striped table-light text-black table-hover">
                <thead>
                    <tr>
                        <th class="" style="text-align: center">CODIGO</th>
                        <th class="" style="text-align: left">CATEGORIA</th>
                        <th class="" style="text-align: left">DESCRIÇÃO</th>
                        <th class="" style="text-align: center">TEMPO ESTIMADO(Min)</th>
                        <th class="" style="text-align: center">VALOR</th>
                        <th class="" style="text-align: center">DISPONIVEL</th>
                        <th class="" colspan="3" style="text-align: center">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dados as $item)
                    <tr>
                        <!-- <td width="3%" style="text-align: center">
                            <span class="table-subtitulos cor-escura"> {{ $item->id }}</span>
                        </td> -->

                        <!--   <td width="8%">
                                <img src="{{ $item->capa }}" height="90px" width="75px"
                                    style="border: 1px solid black;object-fit: contain">
                            </td> -->

                        <!-- <td width="6%" style="text-align: center">
                            <span class="cor-escura"> {{ formatadata($item->created_at) }}</span>
                        </td> -->
                        <td width="5%" style="text-align: center;">
                            <span class="cor-escura  fw-bold"> {{ $item->codigo}}</span>
                        </td>
                        <td width="20%" style="text-align: left">
                            <span class="cor-escura"> {{ $item->categoria['categoria']}}</span>
                        </td>
                        <td width="40%" style="text-align: left">
                            <span class="cor-escura"> {{ $item->descricao}}</span>
                        </td>
                        <td width="10%" style="text-align: center">
                            <span class="cor-escura"> {{ $item->tempo_estimado}}</span>
                        </td>
                        <td width="10%" style="text-align: center">
                            <span class="table-subtitulos cor-escura">
                                {{ 'R$ ' . number_format($item->valor, 2, ',', '.') }}</span>
                        </td>
                       

                        @if ($item->status == 'SIM')
                        <td width="5%" style="text-align: center">
                            <span class=" badge bg-success  cor-escura"> {{ $item->status }}</span>
                        </td>
                        @endIf

                        @if ($item->status == 'NAO')
                        <td width="5%" style="text-align: center">
                            <span class="badge bg-danger  cor-escura"> {{ $item->status }}</span>
                        </td>
                        @endIf


                      


                        <td width="1%">
                            <div class=" d-flex align-items-center">
                                <a class="btn-imagens" href="/servicos/edit/{{ $item->id }}">
                                    <img src="{{ env('APP_LINK_IMAGES') }}edit.png" width="18PX" height="18PX"></a>
                                <a class="btn-imagens" onclick="setaDadosModal('window.location.href=\'/servicos/delete/{{ $item->id }}\'')" data-toggle="modal" data-target="#delete-modal">
                                    <img src="{{ env('APP_LINK_IMAGES') }}trash.svg" width="18PX" height="18PX">
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