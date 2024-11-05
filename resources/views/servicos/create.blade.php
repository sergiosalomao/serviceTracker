@extends('home')
@section('body')
<div class="card painel">
    <div class="card-header titulo-form">
        Adicionar
    </div>
    <div class="card-body">
        <form action="{{ route('servicos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mt-4">
                <div class="col-lg-2">
                    <label class="labels-form">Codigo</label>
                    <span class="h4 fa fa-question-circle-o mx-2" style="color:cadetblue;cursor: pointer;" title="codigo"></span>
                    <input id="codigo" name="codigo" type="text" class="form-control form-control-sm mb-4" placeholder="">
                </div>

                <div class="col-lg-6">
                    <label class="labels-form">Serviço</label>
                    <input id="1" name="descricao" type="text" class="form-control form-control-sm mb-4" placeholder="">
                </div>
                <div class="col-lg-2">
                    <label class="labels-form">TEMPO ESTIMADO(MIN)</label>
                    <input id="1" name="tempo_estimado" type="text" class="form-control form-control-sm mb-4" placeholder="">
                </div>
                <div class="col-lg-2">
                    <label class="labels-form">VALOR</label>
                    <span class="h4 fa fa-question-circle-o mx-2" style="color:cadetblue;cursor: pointer;" title="Valor do Serviço"></span>
                    <input pattern="[0-9]*[.]?[0-9]+" id="valor" name="valor" type="text" class="form-control form-control-sm mb-4" placeholder="">
                </div>
                <div class="col-lg-6 mb-2"><label class="labels-form">Categoria</label>
                    <select id="2" name="categoria_id" type="text" class="form-select form-control-sm">
                        <option value="" selected>Selecione a categoria</option>
                        @foreach ($categorias as $item)
                        <option value="{{ $item->id }}">{{ $item->categoria }}</option>
                        @endforeach
                    </select>
                </div>




                <div class="col-lg-6"><label class="labels-form">HABILITADO</label>
                    <select id="2" name="status" type="text" class="form-select form-control-sm">
                        <option value="SIM" selected>SIM</option>
                        <option value="NAO">NAO</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="labels-form">DESCRIÇÃO</label>
                    <textarea rows="3" cols="30" placeholder="Descreva o serviço..." name="anotacao" class="form-control mb-4"></textarea>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <button class="btn btn-my-secondary" type="button" onclick="window.location.href='/servicos'">Voltar</button>
                        <button class="btn btn-success" type="submit">Gravar</button>
                    </div>
                </div>


            </div>
        </form>

    </div>

    {{-- <script>
        document.getElementById("fornecedor_id").focus();
        $('#fornecedor_id').on('change', function() {
            $("#produto_id").attr("disabled", false);

        });

        $('#categoria_id').on('change', function() {
            $("#btn_salvar").attr("disabled", false);
        });
    </script> --}}


    <script>
        $('#margem_lucro').on('change', function() {
            calculaVenda();
        });
        $('#valor_compra').on('change', function() {
            calculaVenda();
        });

        function calculaVenda() {
            let valor_compra = document.getElementById("valor_compra").value;
            let margem = document.getElementById("margem_lucro").value;
            let markup = parseFloat(valor_compra) + parseFloat(valor_compra * margem / 100);
            $("#valor_venda").val(markup);
        }
    </script>



    @endsection