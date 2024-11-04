@extends('home')
@section('body')
    <div class="card">

        <div class="card-header titulo-form "><span class="fa fa-external-link mx-1"></span>
            Lançamentos Caixa
        </div>
        <div class="card-body ">

            <div class="row ">
                <div class="col-sm-6 texto-esquerda mt-2 mb-2">

                    <button class="btn btn-my-primary form-button mb-4" type="button"
                        onclick="window.location.href='/financeiro/movimentos/create'">Novo Movimento</button>
                    <button class="btn btn-warning form-button mb-4" type="button"
                        onclick="window.location.href='/financeiro/movimentos/lancamentos'">
                        <img class="mx-1" src="{{ env('APP_LINK_IMAGES') }}edit.png" width="18px" height="18px">
                        Gerenciar
                    </button>

                    <button class="btn btn-warning form-button mb-4" type="button"
                        onclick="window.location.href='/financeiro/movimentos/fluxo-caixa'">
                        <img class="mx-1" src="{{ env('APP_LINK_IMAGES') }}fluxo.svg" width="18px" height="18px">
                        Fluxo Caixa
                    </button>

                    <button class="btn btn-warning form-button mb-4" type="button"
                        onclick="window.location.href='/financeiro/movimentos/fluxo-consolidado'">
                        <img class="mx-1" src="{{ env('APP_LINK_IMAGES') }}fluxo.svg" width="18px" height="18px">
                        Fluxo Consolidado
                    </button>

                </div>
                <div class="col-sm-6 ">

                    <form class="" action="{{ route('movimentos.pesquisa') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input name="caixa" value="sim" hidden>

                            <div class="col-sm-2"><label class="fw-bold subtitulos">Conta</label>
                                <select id="conta_id" name="conta_id" type="text" class="form-select mb-4">
                                    @foreach ($contas as $item)
                                        <option value="{{ $item->id }}">{{ $item->conta }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2"><label class="fw-bold subtitulos">Tipo</label>
                                <select id="tipo" name="tipo" type="text" class="form-select mb-4">
                                    <option value="" selected>TODOS</option>
                                    <option value="DEBITO">DEBITO</option>
                                    <option value="CREDITO">CREDITO</option>
                                </select>
                            </div>

                            <div class="col-sm-3 "><label class="fw-bold subtitulos">Data Inicial</label>
                                <input id="dtini" class="form-control me-3" type="date" name="dtini" placeholder=""
                                    aria-label="date">
                            </div>
                            <div class="col-sm-3 "><label class="fw-bold subtitulos">Data Final</label>
                                <input id="dtfim" class="form-control me-2" type="date" name="dtfim" placeholder=""
                                    aria-label="Search">
                            </div>
                            <div class="col-sm-2 texto-esquerda">
                                <button class="btn btn-my-primary form-button mt-4 " type="submit">Pesquisar</button>
                            </div>
                            {{--  <div class="col-sm-2 texto-direita">
                                <button id="btn-gerapdf" class="btn btn-danger form-button mt-4" type="button">Gerar
                                    PDF</button>
                            </div> --}}
                        </div>
                    </form>

                </div>
            </div>

            <div class="row mt-4 mx-1 p-2" style="background-color: gainsboro">
                @if ($de != null)
                    <div class="col-sm-4">
                        <span class="fw-bold ">Movimentação De {{ date('d/m/Y', strtotime($de)) }} até
                            {{ date('d/m/Y', strtotime($ate)) }}</span>
                    </div>
                @endIf
                @if ($de == null)
                    <div class="col-sm-4">
                        <span class="fw-bold">Movimentação</span>
                    </div>
                @endIf

                <div class="col-sm-12 texto-direita">
                    <span class="">
                        @if ($totalformaspagamento != null)
                            @foreach ($totalformaspagamento as $key => $value)
                                @if ($value > 0)
                                    <p>{{ $key }} - R$ {{ number_format($value, 2, ',', '.') }}</p>
                                @endIf
                            @endforeach
                        @endIf
                </div>

                {{--  @if ($saldo < 0)
                <div class="col-sm-12 texto-direita">
                    <span class="fw-bold" style="color:red;font-size: 18px">
                        SALDO : R$ {{ number_format($saldo, 2, ',', '.') }}</span>
                </div>
            @endIf
            @if ($saldo > 0)
                <div class="col-sm-12 texto-direita">
                    <span class="fw-bold" style="color:black;font-size: 18px">
                        SALDO : R$ {{ number_format($saldo, 2, ',', '.') }}</span>
                </div>
            @endIf --}}

                @if ($saldo < 0)
                    <div class="col-sm-12 texto-direita">
                        <span class="fw-bold" style="color:red;font-size: 12px">
                            SALDO ANTERIOR : R$ {{ number_format($saldoAnterior, 2, ',', '.') }}</span>
                    </div>
                @endIf
                @if ($saldo > 0)
                    <div class="col-sm-12 texto-direita">
                        <span class="fw-bold" style="color:black;font-size: 12px">
                            SALDO ANTERIOR: R$ {{ number_format($saldoAnterior, 2, ',', '.') }}</span>
                    </div>
                @endIf

            </div>



            <div class="table-responsive mt-3">
                <table class="table table-striped table-light text-black table-hover">
                    <thead>


                        <tr>
                            {{--    <th class="texto-centro">#</th> --}}
                            <th class="texto-centro">ID</th>
                            <th>DATA</th>
                            <th class="texto-centro">CONTA</th>
                            <th class="texto-centro">TIPO</th>
                            <th>DESCRICAO</th>
                            <th>VALOR</th>
                            <th>SALDO</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($dados as $item)
                            <tr>
                                {{--  <td class="texto-centro" width="2%">
                                    <img src="{{ env('APP_LINK_IMAGES') }}movimento.svg" width="20px" height="20px"></a>
                                </td> --}}
                                <td width="5%" class="texto-centro">
                                    {{ $item->id }}
                                </td>
                                <td width="5%">
                                    {{ date('d/m/Y', strtotime($item->data)) }}
                                </td>
                                <td width="5%" class="texto-centro">
                                    {{ $item->conta['conta'] }}
                                </td>
                                @if ($item->tipo == 'DEBITO')
                                    <td style="text-align: center; " width="10%" nowrap>
                                        <span class="badge bg-danger ">{{ $item->tipo }}</span>
                                    </td>
                                @endIf
                                @if ($item->tipo == 'CREDITO')
                                    <td style="text-align: center; " width="10%" nowrap>
                                        <span class="badge bg-success ">{{ $item->tipo }}</span>
                                    </td>
                                @endIf


                                <td width="50%">
                                    {{ $item->descricao }}
                                </td>
                                @if ($item->tipo == 'DEBITO')
                                    <td width="10%">
                                        <span style="color:red"> R$ {{ $item->valor }}</span>
                                    </td>
                                @endIf
                                @if ($item->tipo == 'CREDITO')
                                    <td width="10%">
                                        R$ {{ $item->valor }}
                                    </td>
                                @endIf
                                @if ($item->valor < 0)
                                    <td width="10%">
                                        <span class="fw-bold" style="color:red"> R$
                                            R$ {{ $item->valor }}
                                    </td>
                                @endif



                                @if ($item->saldo >= 0)
                                    <td width="10%">
                                        <span class="fw-bold" style="color:black"> R$
                                            {{ number_format($item->saldo, 2, ',', '.') }}</span>
                                    </td>
                                @endif

                                @if ($item->saldo < 0)
                                    <td width="10%">
                                        <span class="fw-bold" style="color:red"> R$
                                            {{ number_format($item->saldo, 2, ',', '.') }}</span>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div style="text-align: right">
                    <button class="btn btn-my-secondary" type="button"
                        onclick="window.location.href='/sistema'">Voltar</button>
                </div>
            </div>
        </div>
    </div>
    {{--  @include('layouts.paginacao') --}}
    <script>
        $(document).ready(function() {
            $('#dtini').val(new Date())
            $('#dtfim').val(new Date())
            console.log("limpa datas");
        });
    </script>

    <script>
        $(document).ready(function() {

            $('#btn-gerapdf').on('click', function() {
                var dtini = document.getElementById("dtini").value;
                var dtfim = document.getElementById("dtfim").value;
                var conta_id = document.getElementById("conta_id").value;



                $.ajax({
                    url: "{{ url('/financeiro/movimentos/pdf') }}",
                    type: "GET",
                    data: {
                        caixa: 'sim',
                        conta_id: conta_id,
                        dtini: dtini,
                        dtfim: dtfim,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        console.log(result);
                        window.open(
                            '{{ env('APP_URL') }}/public/relatorios/relatorio-caixa.pdf',
                            '_blank');

                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus);
                        alert("Error: " + errorThrown);
                    }



                });
            });
        })
    </script>
@endsection
