@extends('home')
@section('body')
    <div class="card painel">
        <div class="card-header titulo-form">
            Adicionar
        </div>
        <div class="card-body">

            <form action="{{ route('fluxos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-2">

                    <div class="col-12">
                        <label class="labels-form">TIPO</label>
                        <select id="2" name="tipo" type="text" class="form-control mb-4 focus">
                            <option value="" selected>SELECIONE O TIPO</option>
                            <option value="CREDITO">CREDITO</option>
                            <option value="DEBITO">DEBITO</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="labels-form">FLUXO</label>
                        <input id="1" name="fluxo" type="text" class="form-control mb-4">
                       
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 texto-direita">
                            <button class="btn btn-my-secondary" type="button"
                                onclick="window.location.href='/financeiro/fluxos'">Voltar</button>
                            <button class="btn btn-success" type="submit">Gravar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection
