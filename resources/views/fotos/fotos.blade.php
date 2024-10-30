@extends('home')
@section('body')
    <div class="card">
        <div class="card-header titulo-form ">
            Fotos do Produto
        </div>
        <div class="card-body ">


            <div class="row p-3">
                <div class="col-6 texto-esquerda">
                    <button class="btn btn-my-primary form-button " type="button"
                        onclick="window.location.href='/fotos/addfoto/{{ request('id')}}'">Adicionar Foto</button>
                </div>
                <div class="col-6 texto-direita">
                  
                </div>
            </div>

        

            <div class=" d-flex justify-content-center flex-wrap ">
                @foreach ($dados as $item)
                    @include('layouts.card')
                @endforeach
            </div>
    


                <div style="text-align: right">
                    <button class="btn btn-my-secondary" onclick="window.location.href='/produtos/'">
                        Voltar
                    </button>
                </div>

            </div>

        </div>
    </div>
    @include('layouts.paginacao')
@endsection
