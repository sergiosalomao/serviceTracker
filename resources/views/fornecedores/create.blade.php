@extends('home')
@section('body')
    <div class="card painel">
        <div class="card-header titulo-form">
            Adicionar
        </div>
        <div class="card-body">

            <form action="{{ route('fornecedores.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-2">


                    <div class="col-8">
                        <label class="labels-form">FORNECEDOR</label>
                        <input id="nome" name="nome" type="text" class="form-control form-control-sm focus mb-4">
                    </div>

                    <div class="col-sm-2">
                        <label class="labels-form">CPF/CNPJ</label>
                        <input id="1" name="cpf_cnpj" type="text" class="form-control form-control-sm  mb-4">
                    </div>
                    <div class="col-sm-2">
                        <label class="labels-form">STATUS</label>
                        <select name="status" type="text" class="form-select form-select-sm mb-4 ">
                            <option value="ATIVO">ATIVO</option>
                            <option value="INATIVO">INATIVO</option>

                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <label class="labels-form">TELEFONE</label>
                        <input id="telefone" name="telefone" type="text" class="form-control form-control-sm  mb-4">
                    </div>
                    <div class="col-6">
                        <label class="labels-form">EMAIL</label>
                        <input id="1" name="email" type="text" class="form-control form-control-sm  mb-4">
                    </div>
                </div>


                <div class="row mt-2">
                    <div class="col-12">
                        <label class="labels-form">ENDEREÇO</label>
                        <input id="1" name="endereco" type="text" class="form-control form-control-sm mb-4">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <button class="btn btn-my-secondary" type="button"
                            onclick="window.location.href='/fornecedores'">Voltar</button>
                        <button class="btn btn-success" type="submit">Gravar</button>
                    </div>
                </div>
        </div>
        </form>
       
    </div>
@endsection
