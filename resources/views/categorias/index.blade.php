@extends('home')
@section('body')
    <div class="card">
        <div class="card-header titulo-form ">
            Lista de Categorias
        </div>
        <div class="card-body ">


            <div class="row p-3">
                <div class="col-6 texto-esquerda">
                    <button class="btn btn-my-primary form-button " type="button"
                        onclick="window.location.href='/categorias/create'">Adicionar</button>
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
                    <form class="" action="{{ route('categorias.pesquisa') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input class="form-control me-2 mx-2" type="search" name="pesquisa"
                            placeholder="Pesquisar por categoria" aria-label="Search">

                    </form>
                </div>
            </div>


            <div class="table-responsive mt-3">
                <table class="table table-striped table-light text-black table-hover">
                    <thead>
                        <tr>
                            <th>CODIGO</th>
                            <th>CATEGORIA</th>
                            <th style="text-align: center">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dados as $item)
                            <tr>
                                <td width="1%">
                                    {{ $item->id }}
                                </td>

                                <td width="60%">
                                    {{ $item->categoria }}
                                </td>

                                <td width="3%">
                                    <div class=" d-flex align-items-center">
                                        <a class="btn-imagens" href="/categorias/edit/{{ $item->id }}">
                                            <img src="{{ env('APP_LINK_IMAGES') }}edit.png" width="18PX"
                                                height="18PX"></a>
                                        <a class="btn-imagens"
                                            onclick="setaDadosModal('window.location.href=\'/categorias/delete/{{ $item->id }}\'')"
                                            data-toggle="modal" data-target="#delete-modal">
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
