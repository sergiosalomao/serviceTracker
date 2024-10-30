@extends('home')
@section('body')
    <div class="card painel mt-4">
        <div class="card-header titulo-form">
            Editar
        </div>
        <div class="card-body">
            <form action="{{ route('movimentos.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
            
                <input name="id" value="{{ $dados->id }} "hidden>
                <div class="row mt-2">
                    <div class="col-sm-6"><label class="labels-form">DATA</label>
                        <input id="1" name="data" type="date-local" class="form-control form-control-lg mb-4 focus"
                        value="{{ Carbon\Carbon::parse($dados->data)->format('d/m/Y') }}" maxlength="10">
                    </div>
                    <div class="col-sm-6">
                        <label class="labels-form">TIPO</label>
                        <select name="tipo" type="text" class="form-control form-control-lg  mb-4">
                            <option value="{{ $dados->tipo }}" selected>{{ $dados->tipo }}</option>
                            <option value="DEBITO" >DEBITO</option>
                            <option value="CREDITO" >CREDITO</option>
                        </select>
                    </div>
                    
                    <div class="col-sm-6">
                        <label class="labels-form">CENTRO DE CUSTO</label>
                        <select id="" name="centro_id" type="text" class="form-control form-control-lg mb-4 ">
                            <option id="1" value="{{ $dados->centro['id'] }}" selected >
                                {{ $dados->centro['centro'] }}</option>
                            @foreach ($centros as $item)
                                <option value="{{ $item->id }}">{{ $item->centro }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-6">
                        <label class="labels-form">CONTA</label>
                        <select id="" name="conta_id" type="text" class="form-control form-control-lg mb-4 ">
                            <option id="1" value="{{ $dados->conta['id'] }}" selected >
                                {{ $dados->conta['conta'] }}</option>
                            @foreach ($contas as $item)
                                <option value="{{ $item->id }}">{{ $item->conta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label class="labels-form">FLUXOS</label>
                        <select id="" name="fluxo_id" type="text" class="form-control form-control-lg mb-4 ">
                            <option id="1" value="{{ $dados->fluxo['id'] }}" selected >
                                {{ $dados->fluxo['fluxo'] }}</option>
                            @foreach ($fluxos as $item)
                                <option value="{{ $item->id }}">{{ $item->fluxo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-12"><label class="labels-form">VALOR</label>
                        <input id="1" name="valor" type="text" class="form-control form-control-lg mb-4"
                            value="{{ $dados->valor }}">
                    </div>
                    <div class="col-sm-12"><label class="labels-form">DESCRICAO</label>
                        <input id="1" name="descricao" type="text" class="form-control form-control-lg mb-4"
                            value="{{ $dados->descricao }}">
                    </div>
                    <div class="col-sm-2"><label class="labels-form">Status</label>
                        <input id="1" name="status" type="text" class="form-control form-control-lg mb-4"
                            value="{{ $dados->status }}" readonly>
                    </div>

                    <div class="col-sm-12 texto-direita">
                        <button class="btn  btn-my-secondary" type="button"
                            onclick="window.location.href='/financeiro/movimentos/lancamentos'">Voltar</button>
                        <button class="btn  btn-my-primary" type="submit">Gravar</button>
                    </div>
                </div>
        </div>
        </form>

    </div>
@endsection
