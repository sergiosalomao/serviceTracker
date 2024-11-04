@extends('home')
@section('body')

<div class="card painel">
    <div class="card">
        @php
        $solicitacao = App\Models\Solicitacoes::find(request('id'));


        $itens = App\Models\ItensSolicitacoes::where('solicitacao_id', request('id'))
        ->with('servico') 
        ->get();

        // Soma os valores dos serviços
        $valorTotalServicos = $itens->sum(function ($item) {
        return $item->servico->valor  * $item->qtd ?? 0; 
        });



        @endphp
        <div class="card-header">
            <div class="row ">
                <div class="col-sm-6 esquerda titulo fw-media uppercase">
                    Editar Solicitação | <span class=" fw-small-x ">Lista
                    </span>
                </div>
                <div class="col-sm-6 direita">
                    <span>{{$solicitacao['cliente']['nome']}} | <span>Solicitação: <b>{{request('id')}}</b></span>
                </div>
            </div>
        </div>
        <div class="card-body">
            @php
            $valorTotalServicos = number_format((float) $valorTotalServicos, 2, '.', '');
            @endphp



            <form action="{{ route('solicitacoes.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input id="id" name="id" type="text" value="{{ request('id') }}" hidden>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <label class="labels-form">Data Solicitação</label>
                        <input id="data_solicitacao" name="data_solicitacao" type="text" class="form-control form-control-sm mb-4" value="{{ $dados->data_solicitacao }}">

                    </div>
                    <div class="col-lg-12">
                        <label class="labels-form">Entrada</label>
                        <span class="h4 fa fa-question-circle-o mx-2" style="color:cadetblue;cursor: pointer;" title="Entrada"></span>
                        <input id="entrada" name="entrada" type="text" class=" form-control form-control-sm mb-4" value="{{$dados->entrada}}">
                    </div>

                    <div class="col-lg-12">
                        <label class="labels-form">Desconto(R$)</label>
                        <span class="h4 fa fa-question-circle-o mx-2" style="color:cadetblue;cursor: pointer;" title="desconto no valor total dos servicos."></span>
                        <input id="desconto" name="desconto" type="text" class=" form-control form-control-sm mb-4" value="{{$dados->desconto}}">
                    </div>

                    <div class="col-lg-12">
                        <label class="labels-form">Valor Total</label>
                        <span class="h4 fa fa-question-circle-o mx-2" style="color:cadetblue;cursor: pointer;" title="O valor total dos servicos adicionados."></span>
                        <input id="valor" name="valor" type="text" class=" form-control form-control-sm mb-4" readonly value="{{$valorTotalServicos}}">
                    </div>

                    <div class="col-lg-12 mb-2"><label class="labels-form">Forma de Pagamento</label>
                        <select id="forma_pagamento" name="forma_pagamento" type="text" class="form-select form-control-sm">
                            @if ($dados->formapagamento != NULL)
                            <option value="{{$dados->formapagamento->id}}" selected>{{$dados->formapagamento->forma}}</option>
                            @endif
                            @foreach ($formaspagamento as $formapagamento)
                            <option value="{{$formapagamento->id}}">{{$formapagamento->forma}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-12 mb-2"><label class="labels-form">Parcelas</label>
                        <select id="2" name="parcelas" type="text" class="form-select form-control-sm">
                            @if ($dados->parcelas != NULL)
                            <option selected value="{{$dados->parcelas}}">{{$dados->parcelas}}x</option>
                            @endif
                            <option value="1">1x</option>
                            <option value="2">2x</option>
                            <option value="3">3x</option>
                            <option value="4">4x</option>
                            <option value="5">5x</option>
                            <option value="6">6x</option>
                            <option value="7">7x</option>
                            <option value="8">8x</option>
                            <option value="9">9x</option>
                            <option value="10">10x</option>
                            <option value="11">11x</option>
                            <option value="12">12x</option>
                        </select>
                    </div>

                    <div class="col-lg-2"><label class="labels-form">Status</label>
                        <select name="status" type="text" class="form-select form-control ">
                            <option value="{{ $dados->status }}" selected>{{ $dados->status }}</option>
                            <option value="AGUARDANDO APROVAÇÃO">AGUARDANDO APROVAÇÃO</option>
                            <option value="EM ANDAMENTO">EM ANDAMENTO</option>
                            <option value="CONCLUIDA">CONCLUIDA</option>
                        </select>

                    </div>


                    <div class="row mt-3">
                        <div class="col-12">
                            <button class="btn btn-my-secondary" type="button" onclick="window.location.href='/solicitacoes'">Voltar</button>
                            <button class="btn btn-success" type="submit">Alterar Solicitação</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>

        <script>
            $(document).ready(function() {
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();
                today = dd + '/' + mm + '/' + yyyy;
                document.getElementById("data_solicitacao").value = today

            });
        </script>

        <!-- <script>
            $('#entrada').on('change', function() {
                var entrada = document.getElementById("entrada").value;
            let principal = document.getElementById("principal").value;
            let desconto = document.getElementById("desconto").value;
            $("#valor").val((principal - (entrada + desconto)));
            });
        </script>
        <script>
            $('#desconto').on('change', function() {
                var entrada = document.getElementById("entrada").value;
            let principal = document.getElementById("principal").value;
            let desconto = document.getElementById("desconto").value;
            $("#valor").val((principal - (entrada + desconto)));
            });
        </script> -->
        @endsection