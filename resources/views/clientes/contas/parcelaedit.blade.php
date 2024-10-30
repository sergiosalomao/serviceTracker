@extends('home')
@section('body')

<div class="card painel mt-4">
    <div class="card">
        @php
        $cobranca = App\Models\Cobrancas::find(request('cobranca_id'));
        @endphp
        <div class="card-header">
            <div class="row ">
                <div class="col-sm-6 esquerda titulo fw-media uppercase">
                    Baixar Parcela | <span class=" fw-small-x ">Baixa
                    </span>
                </div>
                <div class="col-sm-6 direita">
                    <span>{{$cobranca['cliente']['nome']}} | <span>VENDA: <b>{{$cobranca['venda_id']}}</b></span>
                </div>
            </div>
        </div>
    </div>


    <div class="card-body">
        <form action="{{ route('clientes.parcela.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mt-4">
                <input name="id" value="{{ $dados->id }}" hidden>
                <input name="cobranca_id" value="{{ $dados->cobranca_id }}" hidden>


                <div class="col-lg-12">
                    <label class="labels-form">Data Vencimento</label>
                    <input id="vencimento" name="vencimento" type="date" class="form-control form-control-sm mb-4" value="{{ $dados->vencimento }}" readonly>

                </div>

                <div class="col-lg-12">
                    <label class="labels-form">Data Pagamento</label>
                    <input id="data_pagamento" name="data_pagamento" type="text" class="form-control form-control-sm mb-4" value="{{ $dados->data_pagamento }}">

                </div>
                <div class="col-lg-12">
                    <label class="labels-form">Valor Parcela</label>
                    <input id="1" name="valor" type="text" class="form-control form-control-sm mb-4" value="{{ $dados->valor }}" >

                </div>
                <div class="col-lg-12">
                    <label class="labels-form">Valor Pago</label>
                    <input id="1" name="valor_pago" type="currency" class="form-control form-control-sm mb-4" value="{{ $dados->valor_pago }}">

                </div>

                <div class="col-lg-12">
                    <label class="labels-form">Observação</label>
                    <input id="1" name="obs" type="text" class="form-control form-control-sm mb-4" value="{{ $dados->obs }}">

                </div>



                <div class="col-lg-2"><label class="labels-form">Status</label>
                    <select name="status" type="text" class="form-select form-control ">
                        <option value="{{ $dados->status }}" selected>{{ $dados->status }}</option>
                        <option value="PAGA">PAGA</option>
                        <option value="ABERTA">ABERTA</option>
                    </select>

                </div>




                <div class="row mt-3">
                    <div class="col-lg-2">
                        <button class="btn btn-my-secondary" type="button" onclick="window.location.href='/clientes/conta/detalhes/{{ request('cobranca_id') }}/{{$dados->cliente_id}}'">Voltar</button>
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