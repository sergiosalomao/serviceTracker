@extends('home')
@section('body')

<div class="card painel mt-4">
    <div class="card">
        @php
        $venda = App\Models\Vendas::find(request('id'));
        @endphp
        <div class="card-header">
            <div class="row ">
                <div class="col-sm-6 esquerda titulo fw-media uppercase">
                    Criar Parcela | <span class=" fw-small-x ">Adicionar
                    </span>
                </div>
                <div class="col-sm-6 direita">
                    <span>{{$venda['cliente']['nome']}} | <span>VENDA: <b>{{request('id')}}</b></span>
                </div>
            </div>
        </div>


        <div class="card-body">
            <form action="{{ route('clientes.parcela.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mt-4">
                    <input name="id" value="{{ request('id') }}" hidden>
                    <input name="cobranca_id" value="{{ request('id') }}" hidden>


                    <div class="col-lg-12">
                        <label class="labels-form">Data Vencimento</label>
                        <input id="vencimento" name="vencimento" type="date" class="form-control form-control-sm mb-4" value="">

                    </div>

                    <div class="col-lg-12">
                        <label class="labels-form">Valor Parcela</label>
                        <input id="1" name="valor" type="text" class="form-control form-control-sm mb-4" value="">

                    </div>

                    <div class="col-lg-12">
                        <label class="labels-form">Observação</label>
                        <input id="1" name="obs" type="text" class="form-control form-control-sm mb-4" value="">

                    </div>

                </div>




                <div class="row mt-3">
                    <div class="col-lg-2">
                        <!--       <button class="btn btn-my-secondary" type="button" onclick="window.location.href='/clientes/conta/detalhes/{{ request('id') }}'">Voltar</button> -->
                        <button class="btn btn-my-secondary" type="button" onclick="javascript:history.go(-1)">Voltar</button>
                        <!--             <button class="btn btn-my-secondary" onclick="window.location.href='{{ url()->previous() }}'">
                Voltar
            </button> -->
                        <button class="btn btn-success" type="submit">Gravar</button>
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
            document.getElementById("data_pagamento").value = today

        });
    </script>

    <script>
        $('#data_pagamento').on('change', function() {
            $("#btn_salvar").attr("disabled", false);
        });

        $('#data_pagamento').on('click', function() {
            $("#btn_salvar").attr("disabled", false);
        });
    </script>


    @endsection