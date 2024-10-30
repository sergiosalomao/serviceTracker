@extends('home')
@section('body')
<div class="card painel mt-4">
    <div class="card-header titulo-form">
        Editar
    </div>
    <div class="card-body">
            <form action="{{ route('fotos.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-4">
                    <input name="id" value="{{ $dados->id }}" hidden>

                    <div class="col-lg-12  mb-4"><label class="labels-form">Produto</label>
                        <select id="2" name="produto_id" type="text" class="form-select form-control-sm">
                            <option  style="text-transform:uppercase" value="{{ $dados['produto']['id'] }}" selected>{{ $dados['produto']['descricao'] }}
                            </option>
                            @foreach ($produtos as $item)
                                <option  style="text-transform:uppercase" value="{{ $item->id }}">{{ $item->placa }}</option>
                            @endforeach
                        </select>
                    </div>

                  
                    <div class="col-lg-12">
                        <label class="labels-form">Descricao</label>
                        <input id="1" name="descricao" type="text" class="form-control form-control-sm mb-4"
                            value="{{ $dados->descricao }}">

                    </div>

                    <div class="col-lg-12">
                        <label class="labels-form">Foto</label>
                        <input id="1" name="image" type="file" class="form-control form-control-sm mb-4">
                    </div>



    


                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <button class="btn btn-my-secondary" type="button"
                            onclick="window.location.href='/fotos'">Voltar</button>
                        <button class="btn btn-success" type="submit">Gravar</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    @endsection
