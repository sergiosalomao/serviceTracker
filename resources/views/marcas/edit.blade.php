@extends('home')
@section('body')
    <div class="card painel mt-4">
        <div class="card-header titulo-form">
            Editar
        </div>
        <div class="card-body">

            <form action="{{ route('marcas.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-2">

                    <div class="col-12">
                        <input name="id" value="{{ $dados->id }}" hidden>
                        <label class="labels-form">MARCA</label>
                        <input id="1" name="marca" type="text" class="form-control mb-4 focus"
                            value="{{ $dados->marca }}">

                    </div>

                    <div class="row mt-3">
                        <div class="col-12 direita">
                            <button class="btn btn-sm btn-secondary" type="button"
                                onclick="window.location.href='/marcas'">Voltar</button>
                            <button class="btn btn-sm btn-success" type="submit">Gravar</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    @endsection
