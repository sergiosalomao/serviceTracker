@extends('home')
@section('body')
<div class="card painel mt-4">
    <div class="card-header titulo-form">
        Detalhes do Cliente
    </div>
    <div class="card-body">


        <div class="row mt-4">
            <div class="col-sm-4 ">
                <div style="margin-left: 20%">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" height="150" width="150">
                    <p class="mt-4">

                    </p>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="row mt-2">
                    <div class="col-sm-6">
                        <input name="id" value="{{ $dados->id }}" hidden>
                        <label class="labels-form">NOME</label>
                        <input id="nome" name="nome" type="text" class="form-control form-control mb-4"
                            value="{{ $dados->nome }}" disabled>
                    </div>
                    <div class="col-sm-6">
                        <label class="labels-form">CPF/CNPJ</label>
                        <input id="1" name="cpf_cnpj" type="text" class="form-control form-control mb-4"
                            value="{{ $dados->cpf_cnpj }}" disabled>
                    </div>

                    <div class="row mt-2">

                        <div class="col-6">
                            <label class="labels-form">TELEFONE</label>
                            <input id="telefone" name="telefone" type="text" class="form-control form-control mb-4"
                                value="{{ $dados->telefone }}" disabled>
                        </div>

                        <div class="col-6">
                            <label class="labels-form">EMAIL</label>
                            <input id="1" name="email" type="text" class="form-control form-control mb-4"
                                value="{{ $dados->email }}" disabled>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="row mt-2">
                            <div class="col-2">
                                <label class="labels-form">CEP</label>
                                <input id="cep" name="cep" type="text" class="form-control mb-4"
                                    value="{{ $dados->cep }}" disabled>
                            </div>
                            <div class="col-8">
                                <label class="labels-form">Rua/Av.</label>
                                <input id="1" name="rua" type="text" class="form-control mb-4"
                                    value="{{ $dados->rua }}" disabled>
                            </div>

                            <div class="col-2">
                                <label class="labels-form">Numero</label>
                                <input id="1" name="numero" type="text" class="form-control mb-4"
                                    value="{{ $dados->numero }}" disabled>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-2">

                        <div class="col-6">
                            <label class="labels-form">Complemento</label>
                            <input id="1" name="complemento" type="text" class="form-control mb-4"
                                value="{{ $dados->complemento }}" disabled>
                        </div>
                        <div class="col-6">
                            <label class="labels-form">Bairro</label>
                            <input id="1" name="bairro" type="text" class="form-control mb-4"
                                value="{{ $dados->bairro }}" disabled>
                        </div>
                        <div class="col-3">
                            <label class="labels-form">Cidade</label>
                            <input id="1" name="cidade" type="text" class="form-control mb-4"
                                value="{{ $dados->cidade }}" disabled>
                        </div>
                        <div class="col-1">
                            <label class="labels-form">UF</label>
                            <input id="1" name="uf" type="text" class="form-control mb-4"
                                value="{{ $dados->uf }}" disabled>
                        </div>
                        <div class="col-12">
                            <label class="labels-form">ANOTAÇÃO</label>
                            <textarea rows="5" cols="30" name="obs" class="form-control mb-4" readonly>{{ $dados->obs }}</textarea>
                        </div>
                    </div>
                </div>

            </div>


        </div>






        <div class="row mt-3">

            <div class="col-12 texto-esquerda">
                <button class="btn btn-my-secondary" type="button"
                    onclick="window.location.href='/clientes'">Fechar</button>

            </div>
        </div>
    </div>
    </form>
    <script>
        document.getElementById("nome").focus();
    </script>
</div>
@endsection