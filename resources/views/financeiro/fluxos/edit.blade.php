@extends('home')
@section('body')
    <div class="card painel mt-4">
        <div class="card-header titulo-form">
            Editar
        </div>
        <div class="card-body">
            <form action="{{ route('fluxos.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-2">
                    <input name="id" value="{{ $dados->id }} "hidden>
                    <div class="col-12">
                        <label class="labels-form">TIPO</label>
                        <select id="2" name="tipo" type="text" class="form-control mb-4">
                            <option value="{{ $dados->tipo }}" selected>{{ $dados->tipo }}</option>
                            <option value="CREDITO">CREDITO</option>
                            <option value="DEBITO">DEBITO</option>
                        </select>
                        </div>
                    <div class="col-12"><label class="labels-form">FLUXO</label>
                        <input id="1" name="fluxo" type="text" class="form-control mb-4"
                        value="{{ $dados->fluxo }}" >
                    </div>
                    <div class="col-12 texto-direita">
                        <button class="btn  btn-my-secondary" type="button"
                        onclick="window.location.href='/financeiro/fluxos'">Voltar</button>
                        <button class="btn  btn-success" type="submit">Gravar</button>
                    </div>
                </div>
        </div>
        </form>

    </div>
@endsection
