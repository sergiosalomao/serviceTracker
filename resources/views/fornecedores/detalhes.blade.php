@extends('home')
@section('body')
    <div class="card painel mt-4">
        <div class="card-header titulo-form">
            Detalhes do Fornecedor
        </div>
        <div class="card-body">
            <form action="{{ route('fornecedores.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-2">

                    <div class="col-8">
                        <input name="id" value="{{ $dados->id }}" hidden>
                        <label class="labels-form">FORNECEDOR</label>
                        <input id="1" name="nome" type="text" class="form-control form-control-sm  mb-4"
                            value="{{ $dados->nome }}" disabled>
                    </div>
                    <div class="col-sm-2">
                        <label class="labels-form">CPF/CNPJ</label>
                        <input id="1" name="cpf_cnpj" type="text" class="form-control form-control-sm  mb-4"
                            value="{{ $dados->cpf_cnpj }}" disabled>
                    </div>
                    <div class="col-sm-2">
                        <label class="labels-form">STATUS</label>
                        <select name="status" type="text" class="form-select form-select-sm mb-4 focus">
                            <option value="{{ $dados->status }}" disabled selected>{{ $dados->status }}<option>
                           
                        </select>
                    </div>

                  
                    <div class="col-12">
                        <label class="labels-form">TELEFONE</label>
                        <input id="telefone" name="telefone" type="text" class="form-control form-control-sm  mb-4"
                            value="{{$dados->telefone }}" disabled>
                    </div>
                    <div class="col-12">
                        <label class="labels-form">EMAIL</label>
                        <input id="1" name="email" type="text" class="form-control form-control-sm  mb-4"
                            value="{{ $dados->email }}" disabled>
                    </div>


                    <div class="col-12">
                        <label class="labels-form">ENDEREÇO</label>
                        <input id="1" name="endereco" type="text" class="form-control form-control-sm  mb-4"
                            value="{{ $dados->endereco }}" disabled>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button class="btn btn-my-secondary" type="button"
                            onclick="window.location.href='/fornecedores'">Voltar</button>
                        
                    </div>
                </div>
            </form>

        </div>
    @endsection
