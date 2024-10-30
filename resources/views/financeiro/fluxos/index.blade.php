@extends('home')
@section('body')
    <div class="card">

        <div class="card-header titulo-form "><i class="fa fa-code-fork mx-3"></i>
            Fluxos de Caixa
        </div>
        <div class="card-body ">

            <button class="btn btn-my-primary form-button" type="button"
                onclick="window.location.href='/financeiro/fluxos/create'">Adicionar</button>

            <div class="table-responsive mt-3">
                <table class="table table-striped table-light text-black table-hover">
                    <thead>
                        <tr>
                            <th class="texto-centro">ID</th>
                            <th>TIPO</th>
                            <th>FLUXO</th>
                            <th class="texto-centro" >AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dados as $item)
                            <tr>
                                <td width="3%" class="texto-centro">
                                    {{ $item->id }}
                                </td>
                                @if ($item->tipo == 'DEBITO')
                                <td width="5%" nowrap>
                                    <span class="badge bg-danger ">{{ $item->tipo }}</span>
                                </td>
                            @endIf
                            @if ($item->tipo == 'CREDITO')
                                <td width="5%" nowrap>
                                    <span class="badge bg-success ">{{ $item->tipo }}</span>
                                </td>
                            @endIf
                                <td width="87%">
                                    {{ $item->fluxo }}
                                </td>

                                <td width="5%" class="texto-centro">
                                    <div class=" d-flex align-items-center">
                                        <a class="btn-imagens" href="/financeiro/fluxos/edit/{{ $item->id }}">
                                            <img src="{{env('APP_LINK_IMAGES')}}edit.svg" width="18px" height="18px"></a>
                                        <a class="btn-imagens"
                                            onclick="setaDadosModal('window.location.href=\'/financeiro/fluxos/delete/{{ $item->id }}\'')"
                                            data-bs-toggle="modal" data-bs-target="#delete-modal">
                                            <img src="{{env('APP_LINK_IMAGES')}}trash.svg" width="18px" height="18px">
                                        </a>
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
