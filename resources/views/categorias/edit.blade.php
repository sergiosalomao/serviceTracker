@extends('home')
@section('body')
    <div class="card painel mt-4">
        <div class="card-header titulo-form">
            Editar
        </div>
        <div class="card-body">
            <form action="{{ route('categorias.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-2">
                    <input name="id" value="{{ $dados->id }} "hidden>


                    <div class="col-12"><label class="labels-form">Categoria</label>
                        <input id="1" name="categoria" type="text" class="form-control mb-4 focus"
                            value="{{ $dados->categoria }}">
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 direita">
                            <button class="btn btn-sm btn-secondary" type="button"
                                onclick="window.location.href='/categorias'">Voltar</button>
                            <button class="btn btn-sm btn-success" type="submit">Gravar</button>
                        </div>
                    </div>
                </div>
        </div>
        </form>

    </div>
@endsection
