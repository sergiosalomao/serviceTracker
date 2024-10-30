@extends('home')
@section('body')
<div class="card painel mt-4">
        <div class="card-header titulo-form">
            Editar
        </div>

        <div class="card-body">
           
            <form action="{{ route('formas-pagamento.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-2">

                    <div class="col-12">
                        <input name="id" value="{{ $dados->id }}" hidden>
                        <label class="labels-form">FORMA PAGAMENTO</label>
                        <input id="1" name="forma" type="text" class="form-control mb-4"
                        value="{{ $dados->forma }}">
                      
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 texto-direita">
                            <button class="btn btn-my-secondary" type="button"
                            onclick="window.location.href='/financeiro/formas-pagamento'">Voltar</button>
                            <button class="btn btn-success" type="submit">Gravar</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    @endsection
