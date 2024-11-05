@extends('home')
@section('body')
<div class="card painel">
    <div class="card-header titulo-form">
        Novo Serviço - Cliente
    </div>
    <div class="card-body ">
        <form name="form-solicitacao" id="form-solicitacao" action="{{ route('solicitacoes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mt-4">

                <div class="col-lg-12 mb-2"><label class="labels-form">Lista de Clientes</label>
                    <span class="h4 fa fa-question-circle-o mx-2" style="color:cadetblue;cursor: pointer;"
                        title="Lista todos os clientes ativos"></span>
                    <select id="cliente_id" class="selectpicker" data-width="100%" name="cliente_id" data-show-subtext="true" data-live-search="true"
                        class="form-select">

                        <option value="" selected>Selecione o Cliente</option>
                        @foreach ($clientes as $item)
                        <option value="{{ $item->id }}">{{ $item->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button class="btn btn-my-secondary" type="button"
                            onclick="window.location.href='/solicitacoes'">Fechar</button>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#cadastrarClienteModal">
                            Adicionar Novo Cliente
                        </button>
                        <button class="btn btn-success" type="submit">Inserir Serviços</button>
                    </div>
                </div>

        </form>


        <!-- Modal -->
        <div class="modal fade" id="cadastrarClienteModal" tabindex="-1" role="dialog" aria-labelledby="cadastrarClienteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cadastrarClienteModalLabel">Cadastro Rápido</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulário de cadastro de cliente -->

                        <form name="form-cliente" id="form-cliente" action="{{ route('clientes.storerapido') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Campos do formulário -->
                            <div class="form-group mb-2">
                                <label for="nomeCliente">Nome do Cliente</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="telefoneCliente">Telefone</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="emailCliente">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-success mb-2">Cadastrar Cliente</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>




</div>

@endsection