@extends('home')
@section('body')
    <div class="card">
        <div class="card-header titulo-form ">
            Historico de Fotos dos Produtos
        </div>
        <div class="card-body ">


            <div class="row p-3">
                <div class="col-6 texto-esquerda">
                    <button class="btn btn-my-primary form-button " type="button"
                        onclick="window.location.href='/fotos/create'">Adicionar</button>
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
                    <form class="" action="{{ route('fotos.pesquisa') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input class="form-control me-2 mx-2" type="search" name="pesquisa"
                            placeholder="Pesquisar por nome ou codigo" aria-label="Search">

                    </form>
                </div>
            </div>


            <div class="table-responsive mt-3">
                <table class="table table-striped table-light text-black table-hover">
                    <thead>
                        <tr>
                            <th class="" style="text-align: left">ID</th>
                            <th class="" style="text-align: center">IMAGEM</th>
                            <th class="" style="text-align: center">DATA</th>
                            <th class="" style="text-align: left">PRODUTO</th>
                            <th class="" style="text-align: left">DESCRIÇÃO</th>
                            <th class="" colspan="3" style="text-align: center">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dados as $item)
                            <tr>
                                <td width="3%">
                                    <span class="table-subtitulos"> {{ $item->id }}</span>
                                </td>
                                <td width="6%" style="text-align: center">
                                    <img src="{{ $item->path }}" height="42px" width="60px"
                                        style="border: 1px solid black;object-fit: contain">
                                </td>
                                <td width="10%" style="text-align: center">
                                    {{ date('d-m-Y', strtotime($item->created_at)) }}
                                </td>
                                <td>
                                    <p class="table-subtitulos" style="text-align: left"> PRODUTO: {{ $item['produto']['descricao'] }}</p>
                                </td>
                                <td>
                                    <span class="table-subtitulos" style="text-align: center"> {{ $item->descricao }}</span>
                                </td>

                                <td width="3%">
                                    <div class=" d-flex align-items-center">
                                        <a class="btn-imagens" href="/fotos/edit/{{ $item->id }}">
                                            <img src="{{ env('APP_LINK_IMAGES') }}edit.svg" width="18PX"
                                                height="18PX"></a>
                                        <a class="btn-imagens"
                                            onclick="setaDadosModal('window.location.href=\'/fotos/delete/{{ $item->id }}\'')"
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
