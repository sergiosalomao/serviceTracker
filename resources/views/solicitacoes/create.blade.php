@extends('home')
@section('body')
    <div class="card painel">
        <div class="card-header titulo-form">
            Novo Serviço - Cliente
        </div>
        <div class="card-body ">
            <form action="{{ route('solicitacoes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-4">

                    <div class="col-lg-12 mb-2"><label class="labels-form">Lista de Clientes</label>
                        <span class="h4 fa fa-question-circle-o mx-2" style="color:cadetblue;cursor: pointer;"
                        title="Lista todos os clientes ativos"></span>
                        <select id="cliente_id" class="selectpicker" data-width="100%"  name="cliente_id"  data-show-subtext="true" data-live-search="true"
                                            class="form-select">
                                          
                            <option value="" selected>Selecione o Cliente</option>
                            @foreach ($clientes as $item)
                                <option value="{{ $item->id }}">{{ $item->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="row mt-3">
                    <div class="col-12">
                        <button class="btn btn-my-secondary" type="button"
                            onclick="window.location.href='/solicitacoes'">Voltar</button>
                        <button class="btn btn-success" type="submit">Adicionar Serviços</button>
                    </div>
                </div>
        </div>
        </form>


        

    </div>

    
@endsection
