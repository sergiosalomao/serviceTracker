@extends('home')
@section('body')
    <div class="card painel">
        <div class="card-header titulo-form">
            Adicionar
        </div>
        <div class="card-body">

            <form action="{{ route('formas-pagamento.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-2">
                    <div class="col-12">
                        <label class="labels-form">FORMA PAGAMENTO</label>
                        <input id="1" name="forma" type="text" class="form-control mb-4">
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 texto-direita">
                            <button class="btn btn-my-secondary " type="button"
                                onclick="window.location.href='/financeiro/formas-pagamento'">Voltar</button>
                            <button class="btn btn-success " type="submit">Gravar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
