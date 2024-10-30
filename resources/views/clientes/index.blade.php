@extends('home')
@section('body')
<div class="card">
    <div class="card-header titulo-form ">
        Lista de Clientes
    </div>
    <div class="card-body ">
        <div class="row p-3">
            <div class="col-6 texto-esquerda">
                <button class="btn btn-my-primary form-button " type="button" onclick="window.location.href='/clientes/create'">Adicionar</button>
            </div>
            <div class="col-6 texto-direita">

            </div>
        </div>

        <div class="row p-3 ">
            <div class="col-12 ">
                <form id="formpesquisa" class="" action="{{ route('clientes.pesquisa') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-11 ">
                            <select type="search" id="pesquisa" class="selectpicker" data-width="100%" name="pesquisa" data-show-subtext="true" data-live-search="true" class="form-select">
                                <option value="">Selecione um cliente</option>

                                @foreach ($clientes as $item)
                                <option data-icon="fa fa-user-md" value="{{ $item->nome }}">
                                    {{ $item->nome }}
                                </option>

                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <button class="btn btn-success" type="submit">Pesquisar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>


        <div class="table-responsive mt-3">
            <table class="table table-striped table-light text-black table-hover">
                <thead>
                    <tr>
                        <th class="center">CODIGO</th>
                        <!-- <th class="center">AVISOS</th> -->
                        <th>NOME</th>
                        <th class="center">CPF/CNPJ</th>
                        <th class="center">DATA NASCIMENTO</th>
                        <th>TELEFONE</th>
                        <th>EMAIL</th>

                        <th style="text-align: center">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                 
                    @foreach ($dados as $item)
              
                    <tr>
                        <td width="3%" style="text-align: center;" class="fw-bold">
                            {{ $item->id }}
                        </td>

                        <td width="25%" style="cursor:pointer" onclick="window.location='/clientes/detalhes/{{ $item->id }}'">
                            {{ $item->nome }}
                        </td>
                        
                        <td width="10%" style="text-align: left;">
                            {{ $item->cpf_cnpj }}
                        </td>

                        <td width="10%" style="text-align: left;" >
                            {{ $item->nascimento }}
                        </td>
                        <td width="10%" nowrap>
                            {{ formataTelefone($item->telefone) }}
                        </td>
                        <td width="20%" nowrap>
                            {{ $item->email }}
                        </td>

                            <td width="5%">
                                <div class=" d-flex align-items-center">
                                    <!--   <a class="btn-imagens" href="/clientes/conta/{{ $item->id }}">
                                            <img src="{{ env('APP_LINK_IMAGES') }}movimento.svg" width="18px" height="18px"></a>
                                            <a class="btn-imagens" href="/clientes/itenscompras/{{ $item->id }}">
                                            <img src="{{ env('APP_LINK_IMAGES') }}carrinho.png" width="18px" height="18px"></a> -->
                                    <!--  <a class="btn-imagens" href="//{{ $item->id }}">
                                            <img src="{{ env('APP_LINK_IMAGES') }}qrcode.svg" width="18px" height="18px"></a> -->
                                    <a class="btn-imagens" href="/clientes/edit/{{ $item->id }}">
                                        <img src="{{ env('APP_LINK_IMAGES') }}edit.svg" width="18px" height="18px"></a>

                                    <a class="btn-imagens" onclick="setaDadosModal('window.location.href=\'/clientes/delete/{{ $item->id }}\'')" data-bs-toggle="modal" data-bs-target="#delete-modal">
                                        <img src="{{ env('APP_LINK_IMAGES') }}trash.svg" width="18px" height="18px">
                                    </a>
                                    @if (isset($vendas->data_compra) )
                                    <a class="btn-imagens" href="/clientes/historico/{{ $item->id }}">
                                        <img src="{{ env('APP_LINK_IMAGES') }}search.svg" width="18px" height="18px"></a>
                                    @endif
                                    
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


<script>
    $('#pesquisa').focus()
</script>
@endsection