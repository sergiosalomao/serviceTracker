@extends('home')
@section('body')
<div class="card">
    <div class="card-header titulo-form ">
        Lista de Cobranças
    </div>
    <div class="card-body ">


        <div class="row p-3">
            <div class="col-6 texto-esquerda">
                <button class="btn btn-my-primary form-button " type="button" onclick="window.location.href='/solicitacoes/create'">Nova Solictação</button>
            </div>
            <div class="col-6 texto-direita">
                {{-- <button class="btn btn-warning form-button" type="button"
                    onclick="window.location.href='/clientes/ranking'">
                    <img class="mx-1" src="{{ env('APP_LINK_IMAGES') }}ranking.svg" width="18px" height="18px">
                Ranking
                </button> --}}
            </div>
        </div>

        <div class="row p-3 ">
            <div class="col-12 ">
                <form class="" action="{{ route('solicitacoes.pesquisa') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-1 ">
                            <input id="codigo" class="form-control me-2" type="text" name="codigo" placeholder="" aria-label="Search">
                        </div>
                        <div class="col-sm-8 ">
                            <select type="search" id="pesquisa" class="selectpicker" data-width="100%" name="pesquisa" data-show-subtext="true" data-live-search="true" class="form-select">
                                <option value="">Selecione um cliente</option>
                                @foreach ($clientes as $item)
                                <option data-icon="fa fa-user-md" value="{{ $item->id }}">
                                    {{ $item->nome }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2 ">
                            <select name="mes" type="search" class="form-select form-select-sm ">
                                <option value="" selected>Todos os Periodos</option>
                                <option value="1">Janeiro</option>
                                <option value="2">Fevereiro</option>
                                <option value="3">Março</option>
                                <option value="4">Abril</option>
                                <option value="5">Maio</option>
                                <option value="6">Junho</option>
                                <option value="7">julho</option>
                                <option value="8">Agosto</option>
                                <option value="9">Setembro</option>
                                <option value="10">Outubro</option>
                                <option value="11">Novembro</option>
                                <option value="12">Dezembro</option>
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <button class="btn btn-success" type="submit">Pesquisar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>


        <div class="table-responsive mt-3">
            <table class="table table-striped table-light text-black table-hover">
                <thead>
                    <tr>
                        <th class="" style="text-align: center">COD.</th>
                        <th class="" style="text-align: center">DATA</th>
                        <th class="" style="text-align: center">SOLICITACAO</th>
                        <th class="" style="text-align: left">CLIENTE</th>
                        <th class="" style="text-align: center">FORMA PAGAMENTO</th>
                        <th class="" style="text-align: center">NR. PARCELAS</th>
                        <th class="" style="text-align: center">VALOR</th>
                        <th class="" style="text-align: center">ENTRADA</th>
                        <th class="" style="text-align: center">DESCONTO</th>
                        <th class="" style="text-align: center">SALDO DEVEDOR</th>
                        <th class="" style="text-align: center">STATUS</th>
                        <th class="" colspan="1" style="text-align: center">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $valor_pago = 0;
                    $itensVendidos = 0;
                    $tempo = 0;
                    $valor = 0;
                    $servicos = [];
                    $formattedTime = 0;
                    @endphp

                    @foreach ($dados as $item)



                    <td width="2%" style="text-align: center">
                        <span class="table-subtitulos cor-escura"> {{ $item->id }}</span>
                    </td>


                    <td width="5%" style="text-align: center">
                        {{ date('d/m/Y', strtotime($item->data_vencimento)) }}
                    </td>

                    <td width="5%" style="text-align: center">
                        <span class="table-subtitulos cor-escura"> {{ $item->solicitacao_id }}</span>
                    </td>

                    <td width="15%" style="text-align: left">
                        <span class="table-subtitulos cor-escura"> {{ $item['solicitacao']['cliente']['nome'] }}</span>
                    </td>
                    <td width="10%" style="text-align: center">
                    <span class="badge bg-info  cor-escura"> {{ $item['formapagamento']['forma']}}</span>
                    </td>
                    <td width="10%" style="text-align: center">
                        <span class="table-subtitulos cor-escura"> {{ $item->parcelas }}</span>
                    </td>

                    <td width="10%" style="text-align: center">
                        {{ 'R$ ' . number_format($item->valor_total, 2, ',', '.') }}</span>
                    </td>
                    <td width="10%" style="text-align: center">
                        {{ 'R$ ' . number_format($item->entrada, 2, ',', '.') }}</span>
                    </td>
                    <td width="10%" style="text-align: center">
                        {{ 'R$ ' . number_format($item->desconto, 2, ',', '.') }}</span>
                    </td>
                    <td width="10%" style="text-align: center">
                        {{ 'R$ ' . number_format($item->valor_total - ($item->entrada + $item->desconto), 2, ',', '.') }}</span>
                    </td>



                    @if ($item->status == 'PAGO')
                    <td width="5%" style="text-align: center">

                        <span class="badge bg-success  cor-escura"> {{ $item->status }}</span>
                    </td>
                    @endIf

                    @if ($item->status == 'VENCIDO')
                    <td width="5%" style="text-align: center">

                        <span class="badge bg-danger  cor-escura"> {{ $item->status }}</span>
                    </td>
                    @endIf

                    @if ($item->status == 'PENDENTE')
                    <td width="5%" style="text-align: center">

                        <span class="badge bg-warning  cor-escura"> {{ $item->status }}</span>
                    </td>
                    @endIf

                    @if ($item->status == 'CANCELADA')
                    <td width="5%" style="text-align: center">

                        <span class="badge bg-danger  cor-escura"> {{ $item->status }}</span>
                    </td>
                    @endIf





                    <td width="3%">
                        <div class=" d-flex align-items-center">
                            @if ($item->status != 'CANCELADA')
                            <a class="btn-imagens" href="/pagamentos/{{ $item->id }}">
                                <img src="{{ env('APP_LINK_IMAGES') }}search4.png" width="18PX" height="18PX" title="ver pagamentos"></a>
                            @endIf
                            <!-- @if ($item->status != 'CANCELADA')
                            <a class="btn-imagens" onclick="setaDadosModalCancela('window.location.href=\'/solicitacoes/cancela/{{ $item->id }}\'')" data-toggle="modal" data-target="#cancela-modal">
                                <img src="{{ env('APP_LINK_IMAGES') }}cancel.png" width="18PX" height="18PX" title="cancela a solicitacao">
                            </a>
                            @endIf

                            @if ($item->status != 'CANCELADA')
                            <a class="btn-imagens" onclick="setaDadosModalFinaliza('window.location.href=\'/solicitacoes/finalizar/{{ $item->id }}\'')" data-toggle="modal" data-target="#finaliza-modal">
                                <img src="{{ env('APP_LINK_IMAGES') }}finalizado.png" width="18PX" height="18PX" title="finaliza a solicitacao">
                            </a>
                            @endIf -->

                            <!-- @if ($item->status != 'CANCELADA')
                            <a class="btn-imagens" href="/solicitacoes/edit/{{ $item->id }}">
                                <img src="{{ env('APP_LINK_IMAGES') }}edit.png" width="18PX" height="18PX" title="edita a solicitacao"></a>
                            @endIf -->





                        </div>
                    </td>


                    </tr>
                    @php
                    $tempo = 0;
                    @endphp
                    @endforeach
                <tbody>

                </tbody>

            </table>
            <span><b>Total de Itens solicitados: {{ $itensVendidos }}</b></span>
            <div style="text-align: right">
                <button class="btn btn-my-secondary" onclick="window.location.href='/sistema'">
                    Voltar
                </button>
            </div>

        </div>

    </div>
</div>
@include('layouts.paginacao')
@endsection