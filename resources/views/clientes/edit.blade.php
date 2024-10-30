@extends('home')
@section('body')
<div class="card painel mt-4">
    <div class="card-header titulo-form">
        Editar
    </div>
    <div class="card-body">
        <form action="{{ route('clientes.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mt-2">
                <input name="id" value="{{ $dados->id }}" hidden>

                <div class="col-sm-10">
                    <label class="labels-form">NOME</label>
                    <input id="nome" name="nome" type="text" class="form-control form-control mb-4" value="{{ $dados->nome }}">
                </div>
                <div class="col-sm-2">
                    <label class="labels-form">DATA NASCIMENTO</label>
                    <input id="nascimento" name="nascimento" type="text" class="form-control form-control mb-4" value="{{ $dados->nascimento }}">
                </div>



                <div class="row mt-2">
                    <div class="col-sm-2">
                        <label class="labels-form">CPF/CNPJ</label>
                        <input id="cpf" name="cpf_cnpj" type="text" class="form-control form-control mb-4" value="{{ $dados->cpf_cnpj }}">
                    </div>
                    <div class="col-sm-5">
                        <label class="labels-form">TELEFONE</label>
                        <input id="telefone" name="telefone" type="text" class="form-control form-control mb-4" value="{{ $dados->telefone }}">
                    </div>
                    <div class="col-sm-5">
                        <label class="labels-form">EMAIL</label>
                        <input id="1" name="email" type="text" class="form-control form-control mb-4" value="{{ $dados->email }}">
                    </div>
                </div>


                <div class="row mt-2">
                    <div class="col-2">
                        <label class="labels-form">CEP</label>
                        <input id="cep" name="cep" type="text" class="form-control mb-4" value="{{ $dados->cep }}">
                    </div>
                    <div class="col-10">
                        <label class="labels-form">Rua/Av.</label>
                        <input id="1" name="rua" type="text" class="form-control mb-4" value="{{ $dados->rua }}">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2">
                        <label class="labels-form">Numero</label>
                        <input id="1" name="numero" type="text" class="form-control mb-4" value="{{ $dados->numero }}">
                    </div>

                    <div class="col-2">
                        <label class="labels-form">Complemento</label>
                        <input id="1" name="complemento" type="text" class="form-control mb-4" value="{{ $dados->complemento }}">
                    </div>
                    <div class="col-4">
                        <label class="labels-form">Bairro</label>
                        <input id="1" name="bairro" type="text" class="form-control mb-4" value="{{ $dados->bairro }}">
                    </div>
                    <div class="col-3">
                        <label class="labels-form">Cidade</label>
                        <input id="1" name="cidade" type="text" class="form-control mb-4" value="{{ $dados->cidade }}">
                    </div>
                    <div class="col-1">
                        <label class="labels-form">UF</label>
                        <input id="1" name="uf" type="text" class="form-control mb-4" value="{{ $dados->uf }}">
                    </div>
                    <div class="col-12">
                            <label class="labels-form">ANOTAÇÃO</label>
                            <textarea rows="5" cols="30" name="obs" class="form-control mb-4" >{{ $dados->obs }}</textarea>
                        </div>
                </div>

                <div class="row mt-3">

                    <div class="col-12 texto-esquerda">
                        <button class="btn btn-my-secondary" type="button" onclick="window.location.href='/clientes'">Voltar</button>
                        <button class="btn btn btn-success" type="submit">Gravar</button>
                    </div>
                </div>
            </div>
        </form>
        <script>
            document.getElementById("nome").focus();
        </script>
    </div>
    @endsection