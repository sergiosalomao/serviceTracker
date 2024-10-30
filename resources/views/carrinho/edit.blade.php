@extends('home')
@section('body')
    <div class="card painel mt-4">
        <div class="card-header titulo-form">
            Editar
        </div>
        <div class="card-body">
            <form action="{{ route('produtos.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-4">
                    <input name="id" value="{{ $dados->id }}" hidden>



                    <div class="col-lg-12  mb-4"><label class="labels-form">Categoria</label>
                        <select id="2" name="categoria_id" type="text" class="form-select form-control-sm">
                            <option value="{{ $dados->categoria_id }}" selected>{{ $dados->categoria['categoria'] }}
                            </option>
                            @foreach ($categorias as $item)
                                <option value="{{ $item->id }}">{{ $item->categoria }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-12">
                        <label class="labels-form">Marca</label>
                        <select id="2" name="marca_id" type="text" class="form-select form-control-sm mb-4">
                            <option value="{{ $dados->marca->id }}" selected>{{ $dados->marca['marca'] }}</option>
                            @foreach ($marcas as $item)
                                <option value="{{ $item->id }}">{{ $item->marca }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-12">
                        <label class="labels-form">Descricao</label>
                        <input id="1" name="descricao" type="text" class="form-control form-control-sm mb-4"
                            value="{{ $dados->descricao }}">

                    </div>

                    <div class="col-lg-12">
                        <label class="labels-form">Capa</label>
                        <input id="1" name="image" type="file" class="form-control form-control-sm mb-4">
                    </div>


                    {{--     <div class="col-lg-6">
                        <label class="labels-form">Valor de Compra</label>
                        <input id="1" name="valor" type="text" class="form-control form-control-sm mb-4"
                            value="{{ $dados->valor }}">

                    </div>

                    <div class="col-lg-6">
                        <label class="labels-form">Margem de Lucro</label>
                        <input id="1" name="margem_lucro" type="text" class="form-control form-control-sm mb-4"
                            value="{{ $dados->margem_lucro }}">

                    </div> --}}

                    <div class="col-lg-2"><label class="labels-form">Status</label>
                        <select name="status" type="text" class="form-select form-control ">
                            <option value="{{ $dados->status }}" selected>{{ $dados->status }}</option>
                            <option value="ATIVO">ATIVO</option>
                            <option value="INATIVO">INATIVO</option>
                        </select>

                    </div>




                    <div class="row mt-3">
                        <div class="col-lg-2">
                            <button class="btn btn-my-secondary" type="button"
                                onclick="window.location.href='/produtos'">Voltar</button>
                            <button class="btn btn-success" type="submit">Gravar</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    @endsection
