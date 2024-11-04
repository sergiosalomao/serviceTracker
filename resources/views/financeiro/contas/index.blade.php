@extends('home')
@section('body')

    <div class="card">
        
        <div class="card-header titulo-form "><i class="fa fa-home mx-1"></i>
            Contas de Movimentações Financeiras
        </div>
        <div class="card-body ">

            <button class="btn btn-my-primary btn-add form-button" type="button"
                onclick="window.location.href='/financeiro/contas/create'">Adicionar</button>

            <div class="table-responsive mt-3">
                <table class="table table-striped table-light text-black table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CONTA</th>
                            <th  style="text-align: center">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dados as $item)
                            <tr>
                                <td width="3%">
                                    {{ $item->id }}
                                </td>
                                <td width="97%">
                                    {{ $item->conta }}
                                </td>

                                <td width="10%">
                                    <div class=" d-flex align-items-center">
                                        <a class="btn-imagens" href="/financeiro/contas/edit/{{ $item->id }}">
                                            <img src="{{env('APP_LINK_IMAGES')}}edit.png" width="18px" height="18px"></a>
                                        <a class="btn-imagens"
                                            onclick="setaDadosModal('window.location.href=\'/financeiro/contas/delete/{{ $item->id }}\'')"
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

