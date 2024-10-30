@extends('home')
@section('body')

<div class="card painel">
    <div class="card">
        @php
        $solicitacoes = App\Models\Solicitacoes::find(request('id'));
        @endphp
        <div class="card-header">
            <div class="row ">
                <div class="col-sm-6 esquerda titulo fw-media uppercase">
                    Adicionar Serviço | <span class=" fw-small-x ">Lista
                    </span>
                </div>
                <div class="col-sm-6 direita">
                    <span>{{$solicitacoes['cliente']['nome']}} | <span>VENDA: <b>{{request('id')}}</b></span>
                </div>
            </div>
        </div>
        <div class="card-body">
            @php
            $solicitacao = request('id');
            @endphp

            <form action="{{ route('carrinho.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input id="id" name="solicitacao_id" type="text" value="{{ request('id') }}" hidden>
                <div class="row mt-4">

                    <div class="col-lg-12 mb-2"><label class="labels-form">Lista de Serviços</label>
                        <span class="h4 fa fa-question-circle-o mx-2" style="color:cadetblue;cursor: pointer;" title="Lista todos os produtos ativos disponiveis em estoque"></span>

                        <select id="servico_id" class="selectpicker" data-width="100%" name="servico_id" data-show-subtext="true" data-live-search="true"
                            class="form-select">

                            <option value="" selected>Selecione o Serviço</option>
                            @foreach ($servicos as $item)
                            <option value="{{ $item->id }}">{{ $item->descricao }}</option>
                            @endforeach
                        </select>



                    </div>
                    <div class="col-lg-12">
                        <label class="labels-form">Quantidade</label>
                        <select id="qtd" class="selectpicker" data-width="100%" name="qtd" data-show-subtext="true" data-live-search="true"
                        class="form-select" >
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        </select>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button class="btn btn-my-secondary" type="button" onclick="window.location.href='/carrinho/{{ $solicitacao }}'">Voltar</button>
                            <button class="btn btn-success" type="submit">Gravar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        @endsection