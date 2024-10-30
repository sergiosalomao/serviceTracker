@extends('home')
@section('body')
    <div class="card painel">
        <div class="card-header titulo-form">
            Adicionar
        </div>
        <div class="card-body">

            <form action="{{ route('campanhas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-2">
                    <div class="col-12">
                        <label class="labels-form">TITULO</label>
                        <input id="1" name="titulo" type="text" class="form-control mb-4">
                    </div>

                    <div class="col-12">
                        <div class="form-outline">
                            <textarea name="descricao" class="form-control mb-4" id="descricao" rows="4">somos a *SUA EMPRESA AQUI*, é um prazer ter você como cliente, e por isso estamos lhe enviando um CUPOM de desconto. Clique aqui para acessar! Link:
                            </textarea>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="labels-form">DESCONTO</label>
                        <input id="1" name="desconto" type="text" class="form-control mb-4">
                    </div>

                    <div id="imagem" class="col-12" >
                        <label class="labels-form">IMAGEM CAMPANHA</label>
                        <input id="image" name="image" type="file" class="form-control form-control-sm mb-4"
                            title="Não exibe quando a opção Gerar Cupom tiver ativa">
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="labels-form">DATA EXPIRACAO</label>
                            <input id="1" name="limite" type="date" class="form-control mb-4">
                        </div>

                        <div id="quantidade" class="col-sm-4" hidden>
                            <label class="labels-form">QUANTIDADE</label>
                            <input id="1" name="qtd_cupons" type="text" class="form-control mb-4">
                        </div>
                        <div class="col-sm-4">
                            <label class="labels-form">GERA CUPOM?</label>
                            <select id="gera_cupom" name="gera_cupom" type="text"
                                class="form-control form-control-lg mb-4">
                               
                                <option value="SIM" >SIM</option>
                                <option value="NAO" selected>NAO</option>
                            </select>
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-12 texto-direita">
                            <button class="btn btn-my-secondary " type="button"
                                onclick="window.location.href='/campanhas'">Voltar</button>
                            <button class="btn btn-success " type="submit">Gravar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#gera_cupom').on('change', function() {
                var valor = this.value;
                if (valor == 'SIM') {
                    $('#imagem').attr('hidden', true);
                    $('#quantidade').attr('hidden', false);
                }
                if (valor == 'NAO') {
                    $('#imagem').attr('hidden', false);
                    $('#quantidade').attr('hidden', true);
                }
            });
        })
    </script>
@endsection
