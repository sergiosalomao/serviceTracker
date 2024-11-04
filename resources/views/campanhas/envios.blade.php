@extends('home')
@section('body')
    <div class="card">
        <div class="card-header titulo-form "><i class="fa fa-user mx-1"></i>
            Lista de Clientes para Envio
        </div>
        <div class="card-body ">


            <div class="row p-3">
              {{--   <div class="col-6 texto-esquerda">
                    <button class="btn btn-my-primary form-button " type="button"
                        onclick="window.location.href='/clientes/create'">Adicionar</button>
                </div> --}}
                <div class="col-6 texto-direita">
                   {{--  <button class="btn btn-warning form-button" type="button"
                        onclick="window.location.href='/clientes/ranking'">
                        <img class="mx-1" src="{{ env('APP_LINK_IMAGES') }}ranking.svg" width="18px" height="18px">
                        Ranking
                    </button> --}}
                </div>
            </div>

            <div class="row p-3 ">
                <div class="col-12 ">
                    <form class="" action="{{ route('campanhas.pesquisaenvios') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input class="form-control me-2 mx-2" type="search" name="pesquisa"
                            placeholder="Pesquisar por nome ou telefone" aria-label="Search">

                    </form>
                </div>
            </div>

           
            
            <div class="table-responsive mt-3">
                <table class="table table-striped table-light text-black table-hover">
                    <thead>
                        <tr>
                            {{--   <th class="texto-centro">#</th> --}}
                            <th class="texto-centro">ID</th>
                            <th class="texto-centro">CPF/CNPJ</th>
                            <th>NOME</th>
                            <th>TELEFONE</th>
                            <th>EMAIL</th>
                            <th style="text-align: center">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dados as $item)
                            <tr>
                                {{--  <td width="2%">
                                    <img src="{{ env('APP_LINK_IMAGES') }}user.svg" width="18px" height="18px"></a>
                                </td> --}}
                                <td width="3%" class="texto-centro">
                                    {{ $item->id }}
                                </td>
                                <td width="10%" class="texto-centro">
                                    {{ formata_cpf_cnpj($item->cpf_cnpj) }}
                                </td>
                                <td width="45%" nowrap>
                                    {{ $item->nome }}
                                </td>

                                <td width="10%" nowrap>
                                    {{ formataTelefone($item->telefone) }}
                                </td>
                                <td width="30%" nowrap>
                                    {{ $item->email }}
                                </td>


                        <div class="dropdown">
                            <td width="10%">
                                <div class=" d-flex align-items-center">

                                    <span class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ env('APP_LINK_IMAGES') }}whatsapp.svg" width="18px" height="18px">
                                    </span>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach ($campanhas as $camp)
                                            <li><a target="_blank" class="dropdown-item"
                                                    href="{{ route('campanhas.envia-cupom', ['id' => $camp->id, 'cliente' => $item->id]) }}">{{ $camp->titulo }}</a>
                                            </li>
                                        @endforeach
                                    </ul>


                                   {{--  <a class="btn-imagens" href="/clientes/veiculos/{{ $item->id }}">
                                        <img src="{{ env('APP_LINK_IMAGES') }}car.svg" width="18px" height="18px"></a>
                                    <a class="btn-imagens" href="/clientes/servicos/{{ $item->id }}">
                                        <img src="{{ env('APP_LINK_IMAGES') }}hand.svg" width="18px" height="18px"></a> --}}

                                  {{--   <a class="btn-imagens" href="/clientes/edit/{{ $item->id }}">
                                        <img src="{{ env('APP_LINK_IMAGES') }}edit.png" width="18px" height="18px"></a>


                                    <a class="btn-imagens"
                                        onclick="setaDadosModal('window.location.href=\'/clientes/delete/{{ $item->id }}\'')"
                                        data-bs-toggle="modal" data-bs-target="#delete-modal">
                                        <img src="{{ env('APP_LINK_IMAGES') }}trash.svg" width="18px" height="18px">
                                    </a> --}}
                                </div>
                            </td>
                        </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="text-align: right">
                    <button class="btn btn-my-secondary" onclick="window.location.href='/'">
                        Voltar
                    </button>



                </div>
            </div>
        </div>
    </div>
    @include('layouts.paginacao')
@endsection
