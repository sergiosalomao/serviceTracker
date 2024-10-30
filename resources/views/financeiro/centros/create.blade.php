@extends('home')
@section('body')
    <div class="card painel">
        <div class="card-header titulo-form">
            Adicionar
        </div>
        <div class="card-body">

            <form action="{{ route('centros.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-2">
                    <div class="col-12">
                        <label class="labels-form">CENTRO DE CUSTO</label>
                        <input id="1" name="centro" type="text" class="form-control mb-4 focus">
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 texto-direita">
                            <button class="btn btn-my-secondary " type="button"
                                onclick="window.location.href='/financeiro/centros'">Voltar</button>
                            <button class="btn btn-my-primary " type="submit">Gravar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
