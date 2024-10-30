@extends('home')
@section('body')

    <div class="card painel">
        <div class="card-header titulo-form">
            Devolução de Produto
        </div>
        <div class="card-body">
            @php
                $venda = request('id');
            @endphp

            <form action="{{ route('devolucao.produto', $venda) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input id="id" name="venda_id" type="text" value="{{ request('id') }}" hidden>
                <div class="row mt-4">

                    <div class="col-lg-12 mb-2"><label class="labels-form">Lista de Produtos</label>
                        <span class="h4 fa fa-question-circle-o mx-2" style="color:cadetblue;cursor: pointer;"
                            title="Lista todos os produtos ativos disponiveis em estoque"></span>
                            <select id="produto_id" class="selectpicker" data-width="100%"  name="produto_id"  data-show-subtext="true" data-live-search="true"
                                            class="form-select">
                                            <option value="">Selecione um Produto</option>
                                            @foreach ($itens as $item)
                              
                              
                                    <option value="{{ $item['produto']['id'] }}">
                                    [{{ $item['produto']['codigo'] }}] {{ $item['produto']['descricao'] }}
                                        - Valor [ {{ $item['produto']['valor_venda'] }} ]
                                      
                                    </option>
                              
                           
                            @endforeach
                                        </select>
                      
                         
                    </div>
                    <div class="col-lg-12">
                        <label class="labels-form">Quantidade</label>
                        <input id="1" name="qtd" type="text" class="form-control form-control-sm mb-4"
                            placeholder="">
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <button class="btn btn-my-secondary" type="button"
                                onclick="window.location.href='/solicitacoes'">Voltar</button>
                            <button class="btn btn-success" type="submit">Gravar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endsection
