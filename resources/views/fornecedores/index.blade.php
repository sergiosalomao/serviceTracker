@extends('home')
@section('body')
    <div class="card">
        <div class="card-header titulo-form ">
            Lista de Fornecedores
        </div>
        <div class="card-body ">


            <div class="row p-3">
                <div class="col-6 texto-esquerda">
                    <button class="btn btn-my-primary form-button " type="button"
                        onclick="window.location.href='/fornecedores/create'">Adicionar</button>
                </div>
                <div class="col-6 texto-direita">
                    {{--  <button class="btn btn-warning form-button" type="button"
                        onclick="window.location.href='/fornecedores/ranking'">
                        <img class="mx-1" src="{{ env('APP_LINK_IMAGES') }}ranking.svg" width="18px" height="18px">
                        Ranking
                    </button> --}}
                </div>
            </div>

            <div class="row p-3 ">
                <div class="col-12 ">
                    <form class="" action="{{ route('fornecedores.pesquisa') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input class="form-control me-2 mx-2" type="search" name="pesquisa"
                            placeholder="Pesquisar por fornecedor" aria-label="Search">

                    </form>
                </div>
            </div>


            <div class="table-responsive mt-3">
                <table id="tabela" class="table table-striped table-light text-black table-hover">
                    <thead>
                        <tr>
                            {{--   <th class="texto-centro">#</th> --}}
                            <th>CODIGO</th>
                            <th>NOME</th>
                            <th>TELEFONE</th>
                            <th>EMAIL</th>

                            <th style="text-align: center">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                     
                        @foreach ($dados as $item)
                           
                             <tr   >
                               
                                <td width="2%" class="texto-centro">
                                    {{ $item->id }}
                                </td>

                                <td width="68%" onclick="window.location='/fornecedores/detalhes/{{ $item->id }}'" style="cursor:pointer">
                                    {{ $item->nome }}
                                </td>

                                <td width="15%" nowrap>
                                    {{ formataTelefone($item->telefone) }}
                                </td>
                                <td width="20%" nowrap>
                                    {{ $item->email }}
                                </td>

                         
                               
                                    <td width="5%">
                                        <div class=" d-flex align-items-center">
                                            <a class="btn-imagens" href="/fornecedores/{{ $item->id }}">


                                                <a class="btn-imagens" href="/fornecedores/edit/{{ $item->id }}">
                                                    <img src="{{ env('APP_LINK_IMAGES') }}edit.png" width="18px"
                                                        height="18px"></a>


                                                <a class="btn-imagens"
                                                    onclick="setaDadosModal('window.location.href=\'/fornecedores/delete/{{ $item->id }}\'')"
                                                    data-bs-toggle="modal" data-bs-target="#delete-modal">
                                                    <img src="{{ env('APP_LINK_IMAGES') }}trash.svg" width="18px"
                                                        height="18px">
                                                </a>
                                                <a class="btn-imagens" href="/fornecedores/detalhes/{{ $item->id }}">
                                                    <img src="{{ env('APP_LINK_IMAGES') }}search.svg" width="18px"
                                                        height="18px"></a>
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
