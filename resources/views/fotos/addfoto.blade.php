@extends('home')
@section('body')

<div class="card painel">
    <div class="card-header titulo-form">
        Adicionar Foto
    </div>
    <div class="card-body">
              <form action="{{ route('fotos.fotosstore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-4">
                    <input name="produto_id" value="{{ $produto->id }}" hidden >
                  
                    <div class="col-lg-12">
                        <label class="labels-form">Produto</label>
                        <input id="1" name="" type="text" class="form-control form-control-sm mb-4"
                            placeholder="" value="{{ $produto['descricao'] }}" readonly>
                    </div>


                    
                     <div class="col-lg-12">
                         <label class="labels-form">Descricao</label>
                         <input id="1" name="descricao" type="text" class="form-control form-control-sm mb-4"
                             placeholder="">
                     </div>

                   
                    <div class="col-lg-12">
                        <label class="labels-form">Imagem</label>
                        <input id="1" name="image" type="file" class="form-control form-control-sm mb-4">
                    </div>
                    
              
                   
                    <div class="row mt-3">
                        <div class="col-12">
                            <button class="btn btn-my-secondary" type="button"
                            onclick="window.location.href='/produtos'">Fechar</button>
                        <button class="btn btn-success" type="submit">Gravar</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    @endsection
