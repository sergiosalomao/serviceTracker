@extends('home')
@section('body')
    <div class="card painel mt-4">
        <div class="card-header titulo-form">
            Link
        </div>
        <div class="card-body">

            {{{'http://'. $link}}}
            <div class="row mt-5 text-center">
            </div>
            <div class="col-12 texto-direita">
                <button class="btn btn-my-secondary" type="button" onclick="javascript:history.go(-1)">Voltar</button>
            </div>
        </div>

    </div>
@endsection
