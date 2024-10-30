@extends('home')
@section('body')
    <div class="card painel mt-4">
        <div class="card-header titulo-form">
            Editar
        </div>

        <div class="card-body">

            <form action="{{ route('campanhas.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-2">

                    <div class="col-12">
                        <input name="id" value="{{ $dados->id }}" hidden>
                        <label class="labels-form">TITULO</label>
                        <input id="1" name="titulo" type="text" class="form-control mb-4"
                            value="{{ $dados->titulo }}">

                    </div>
                    <div class="col-12">
                        <div class="form-outline">
                            <textarea name="descricao" class="form-control mb-4" id="descricao" rows="4">{{$dados->descricao}}</textarea>
                        </div>
                    </div>

                    <div id="imagem" class="col-12">
                        <label class="labels-form">IMAGEM CAMPANHA</label>
                        <input id="image" name="image" type="file" class="form-control form-control-sm mb-4"
                            title="Não exibe quando a opção Gerar Cupom tiver ativa" value="{{ $dados->foto_path }}">
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 texto-direita">
                            <button class="btn btn-my-secondary" type="button"
                                onclick="window.location.href='/campanhas'">Voltar</button>
                            <button class="btn btn-success" type="submit">Gravar</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    @endsection
