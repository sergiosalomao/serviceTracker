@extends('home')
@section('body')
    <div class="card painel">
        <div class="card-header titulo-form">
            Adicionar
        </div>
        <div class="card-body">

            <form action="{{ route('movimentos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-2">

                    <div class="col-lg-6">
                        <label class="labels-form">DATA</label>
                        <input id="data" name="data" type="date" class="form-control form-control-lg mb-4 focus" >
                    </div>
                    <div class="col-lg-6">
                        <label class="labels-form">TIPO</label>
                        <select name="tipo" type="text" class="form-control form-control-lg  mb-4">
                            <option value="DEBITO" selected>DEBITO</option>
                            <option value="CREDITO" >CREDITO</option>
                        </select>
                    </div>
                    
                    <div class="col-lg-6">
                        <label class="labels-form">CENTRO DE CUSTO</label>
                        <select id="2" name="centro_id" type="text" class="form-control form-control-lg mb-4 ">
                            <option value="" selected>SELECIONE UMA CENTRO DE CUSTO</option>
                            @foreach ($centros as $item)
                                <option value="{{ $item->id }}">{{ $item->centro }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-6">
                        <label class="labels-form">CONTA</label>
                        <select id="2" name="conta_id" type="text" class="form-control form-control-lg mb-4 ">
                            <option value="" selected>SELECIONE UMA CONTA</option>
                            @foreach ($contas as $item)
                            <option value="{{ $item->id }}">{{ $item->conta }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-12">
                        <label class="labels-form">FLUXO</label>
                        <select id="2" name="fluxo_id" type="text" class="form-control form-control-lg mb-4 ">
                            <option value="" selected>SELECIONE UM FLUXO</option>
                            @foreach ($fluxos as $item)
                                <option value="{{ $item->id }}">{{ $item->fluxo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-12">
                        <label class="labels-form">VALOR</label>
                        <input id="1" name="valor" type="text" class="form-control form-control-lg mb-4 ">
                    </div>
                    <div class="col-lg-12">
                        <label class="labels-form">DESCRICAO</label>
                        <input id="10" name="descricao" type="text" class="form-control form-control-lg mb-4 ">
                    </div>

                </div>
                <div class="row mt-3">
                    <div class="col-lg-12 texto-direita">
                        <button class="btn btn-my-secondary" type="button"
                            onclick="window.location.href='/financeiro/movimentos'">Voltar</button>
                        <button class="btn btn-my-primary" type="submit">Gravar</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
    </div>
    </div>

    <script>
        $(document).ready(function() {
            document.getElementById("data").valueAsDate = new Date();
        });
    </script>
@endsection
