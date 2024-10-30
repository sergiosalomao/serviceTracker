@extends('home')
@section('body')

<div class="card painel">
    <div class="card-header titulo-form">
        Solicitação
    </div>
    <div class="card-body">


        <form action="{{ route('solicitacoes.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input id="id" name="id" type="text" value="{{ request('id') }}" hidden>
            <input id="status" name="status" type="text" value="EM ANDAMENTO" hidden>
            <div class="row mt-4">
                <div class="col-lg-12">
                    <label class="labels-form">Data Solicitação</label>
                    <input id="data_compra" name="data_solicitacao" type="text" class="form-control form-control-sm mb-4" value="{{ $dados->data_solicitacao }}">

                </div>

                @php
                $valor = number_format((float) request('valor'), 2, '.', '');
                @endphp

                <div class="col-lg-12">
                    <label class="labels-form">Valor Total</label>
                    <span class="h4 fa fa-question-circle-o mx-2" style="color:cadetblue;cursor: pointer;" title="O valor total nao pode ser alterado."></span>
                    <input id="valor" name="valor" type="text" class=" form-control form-control-sm mb-4" readonly value="{{$valor}}">
                </div>
             



             

                <div class="row mt-3">
                    <div class="col-12">
                        <button class="btn btn-my-secondary" type="button" onclick="window.location.href='/solicitacoes'">Voltar</button>
                        <button class="btn btn-success" type="submit">Gerar Solicitação</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <script>
        $(document).ready(function() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            today = dd + '/' + mm + '/' + yyyy;
            document.getElementById("data_compra").value = today

        });
    </script>

    <script>
        $('#desconto_porcento').on('change', function() {
            var desconto_porcento = document.getElementById("desconto_porcento").value;
            let valor = document.getElementById("valor").value;
            let desconto = valor * (desconto_porcento / 100);
            $("#desconto").val(Math.round(desconto));
        });
    </script>
     <script>
            $('#desconto').on('change', function() {
                var desconto= document.getElementById("desconto").value;
                let valor = document.getElementById("valor").value;
                let desc = ((desconto / valor) * 100 );
                $("#desconto_porcento").val((desc).toFixed(2));
            });
        </script>
    @endsection