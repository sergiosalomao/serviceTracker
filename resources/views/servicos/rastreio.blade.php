@extends('home')
@section('body')
<div class="card">
    <div class="card">
        @php
        $produto = App\Models\Produtos::find(request('id'));
        @endphp
        <div class="card-header">
            <div class="row ">
                <div class="col-sm-6 esquerda titulo fw-media uppercase">
                    Rastreio do Produto | <span class=" fw-small-x ">Lista
                    </span>
                </div>
                <div class="col-sm-6 direita">
                    <span>CODIGO: {{$produto['codigo']}} | {{$produto['descricao']}}</b></span>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body ">
        <div class="row p-3">

        </div>
        <div class="row p-3 ">
            <div class="col-12 titulo">
                Movimentaçao do Produto
            </div>
        </div>
        <div class="table-responsive mt-3">
            <table class="table table-striped table-light text-black table-hover">
                <thead>
                    <tr>
                        <th class="" style="text-align: center">DATA</th>
                        <th class="" style="text-align: center">TIPO</th>
                        <th class="" style="text-align: center">QTD</th>
                        <th class="" style="text-align: left">HISTORICO</th>
                        <!--  <th class="" colspan="3" style="text-align: center">AÇÕES</th>  -->
                    </tr>
                </thead>
                <tbody>
                    @php
                    $estoquetotal = 0
                    @endphp
                    @foreach ($dados as $item)
                    <tr>
                        <td width="2%" style="text-align: center">
                            {{ formatadata($item->created_at) }}

                        </td>
                        @if ($item->tipo == 'ENTRADA')
                        <td width="2%" style="text-align: center">
                            <span class=" badge bg-success  cor-escura"> {{ $item->tipo }}</span>
                        </td>
                        @endIf
                        @if ($item->tipo == 'SAIDA')
                        <td width="2%" style="text-align: center">

                            <span class="badge bg-danger  cor-escura"> {{ $item->tipo }}</span>
                        </td>
                        @endIf


                        <td width="2%" style="text-align: center">
                            <span class=""> {{ $item->qtd }}</span>
                        </td>


                        <td width="20%" style="text-align: left">
                            <span class="fw-bold"> {{ $item->historico }}</span>
                        </td>

                        {{-- <td>
                                {{ date('d-m-Y', strtotime($item->data)) }}
                        </td> --}}

                        <div class=" d-flex align-items-center">
                            {{-- <td width="5%">
                                <a class="btn-imagens" href="/estoque/edit/{{ $item->id }}">
                            <img src="{{ env('APP_LINK_IMAGES') }}edit.svg" width="18PX" height="18PX"></a>
                            </td> --}}
                            <!--   <td width="5%" style="text-align: center">
                                <a class="btn-imagens" onclick="setaDadosModal('window.location.href=\'/estoque/delete/{{ $item->id }}\'')" data-toggle="modal" data-target="#delete-modal">
                                    <img src="{{ env('APP_LINK_IMAGES') }}trash.svg" width="18PX" height="18PX">
                                </a>
                            </td> -->
                        </div>
                    </tr>
                    @php
                    $estoquetotal += $item->qtd
                    @endphp
                    @endforeach

                </tbody>
                <tbody>

                    <tr>
                        <td width="2%" style="text-align: center">
                        </td>

                        <td width="2%" style="text-align: center">

                        </td>
                        <td width="2%" style="text-align: center" class="fw-bold">
                            {{ $estoquetotal }}
                        </td>

                        <td width="20%" style="text-align: left">
                        </td>

                        <div class=" d-flex align-items-center">
                        </div>
                    </tr>


                </tbody>
            </table>
            <div style="text-align: right">
                <button class="btn btn-my-secondary" onclick="window.location.href='/produtos'">
                    Voltar
                </button>
            </div>
        </div>
    </div>
</div>
@include('layouts.paginacao')
@endsection