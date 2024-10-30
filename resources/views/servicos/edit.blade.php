@extends('home')
@section('body')
<div class="card painel mt-4">
    <div class="card-header titulo-form">
        Editar
    </div>
    <div class="card-body">
        <form action="{{ route('servicos.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input name="id" value="{{ $dados->id }}" hidden>

            <div class="row mt-4">
                <div class="col-lg-2">
                    <label class="labels-form">Codigo</label>
                    <span class="h4 fa fa-question-circle-o mx-2" style="color:cadetblue;cursor: pointer;" title=""></span>
                    <input id="1" name="codigo" type="text" class="form-control form-control-sm mb-4" placeholder="" value="{{ $dados->codigo }}">
                </div>
                <div class="col-lg-6">
                    <label class="labels-form">Descricao do Serviço</label>
                    <input id="1" name="descricao" type="text" class="form-control form-control-sm mb-4" value="{{ $dados->descricao }}">

                </div>
                <div class="col-lg-2">
                    <label class="labels-form">TEMPO ESTIMADO (MIN)</label>
                    <input id="1" name="tempo_estimado" type="text" class="form-control form-control-sm mb-4" placeholder="" value="{{ $dados->tempo_estimado }}">
                </div>
                <div class="col-lg-2">
                    <label class="labels-form">VALOR</label>
                    <span class="h4 fa fa-question-circle-o mx-2" style="color:cadetblue;cursor: pointer;" title="Valor do Serviço"></span>
                    <input pattern="[0-9]*[.]?[0-9]+" id="valor" name="valor" type="text" class="form-control form-control-sm mb-4" placeholder="" value="{{ $dados->valor }}">
                </div>
            </div>


            <div class="row mt-1">
                <div class="col-lg-6  mb-4"><label class="labels-form">Categoria</label>
                    <select id="2" name="categoria_id" type="text" class="form-select form-control-sm">
                        <option value="{{ $dados->categoria_id }}" selected>{{ $dados->categoria['categoria'] }}
                        </option>
                        @foreach ($categorias as $item)
                        <option value="{{ $item->id }}">{{ $item->categoria }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-6"><label class="labels-form">DISPONIVEL</label>
                    <select name="status" type="text" class="form-select form-control ">
                        <option value="{{ $dados->status }}" selected>{{ $dados->status }}</option>
                        <option value="SIM">SIM</option>
                        <option value="NAO">NAO</option>
                    </select>

                </div>
            </div>




            <div class="row mt-3">
                <div class="col-lg-2">
                    <button class="btn btn-my-secondary" type="button" onclick="window.location.href='/servicos'">Voltar</button>
                    <button class="btn btn-success" type="submit">Gravar</button>
                </div>
            </div>
    </div>
    </form>

</div>

@endsection