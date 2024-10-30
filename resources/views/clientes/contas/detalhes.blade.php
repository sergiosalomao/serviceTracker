@extends('home')
@section('body')
<div class="card">
    <div class="card">
        <div class="card-header">
            <div class="row ">
                <div class="col-sm-6 esquerda titulo fw-media uppercase">
                    Detalhes Cobrança | <span class=" fw-small-x ">Lista
                    </span>
                </div>
                <div class="col-sm-6 direita">
                     <span>{{$dados[0]['cliente']['nome']}}</span> | <span>VENDA: <b>{{$dados[0]['cobranca']['venda_id']}}</b></span>
                </div>
            </div>
        </div>
    <div class="card-body ">


        <div class="row p-3">
            <div class="col-6 texto-esquerda">
                <button class="btn btn-my-primary form-button " type="button" onclick="window.location.href='/clientes/conta/parcela/create/{{  request('id') }}'">Adicionar Parcela </button>
            </div>
            <div class="col-6 texto-direita">
                {{-- <button class="btn btn-warning form-button" type="button"
                    onclick="window.location.href='/clientes/ranking'">
                    <img class="mx-1" src="{{ env('APP_LINK_IMAGES') }}ranking.svg" width="18px" height="18px">
                Ranking
                </button> --}}
            </div>
        </div>

        {{-- <div class="row p-3 ">
                <div class="col-12 ">
                    <form class="" action="{{ route('parcelas.pesquisa') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <input class="form-control me-2 mx-2" type="search" name="pesquisa" placeholder="Pesquisar por descricao ou codigo do produto" aria-label="Search">

        </form>
    </div>
</div> --}}


<div class="table-responsive mt-3">
    <table class="table table-striped table-light text-black table-hover">
        <thead>
            <tr>
                <th class="" style="text-align: center">TITULO</th>
                <th class="" style="text-align: center">PARCELA</th>
                <th class="" style="text-align: center">VENCIMENTO</th>
                <th class="" style="text-align: center">VALOR</th>
                <th class="" style="text-align: center">DATA PAGAMENTO</th>
                <th class="" style="text-align: center">DIAS ATRASO</th>
                <th class="" style="text-align: center">PAGO</th>
                <th class="" style="text-align: center">SALDO DEVEDOR</th>
                <th class="" style="text-align: center">STATUS</th>
                <th class="" colspan="3" style="text-align: center">AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            @php
            $contador = 1;
            @endphp
            @foreach ($dados as $item)
            <tr title="{{$item->obs}}">
                <td width="2%" style="text-align: center">
                    <span class="table-subtitulos cor-escura"> {{ $item->id }}</span>
                </td>
                <td width="2%" style="text-align: center">
                    <span class="table-subtitulos cor-escura"> {{ $contador++ }}</span>
                </td>
                <td width="10%" style="text-align: center">
                    {{ date('d/m/Y', strtotime($item->vencimento)) }}
                </td>


                <td width="15%" style="text-align: center">
                    <span class="subtitulos cor-escura">
                        {{ 'R$ ' . number_format($item->valor, 2, ',', '.') }}</span>
                </td>
                @if ($item->data_pagamento !=null)
                <td width="10%" style="text-align: center">
                    {{ date('d/m/Y', strtotime($item->data_pagamento)) }}
                </td>
                @endif
                @if ($item->data_pagamento == null)
                <td width="10%" style="text-align: center">
                    {{ '-' }}
                </td>
                @endif

                @php
                if ($item->data_pagamento) {
                $hoje = \Carbon\Carbon::now();
                $date1 = \Carbon\Carbon::createFromFormat('Y-m-d', date($item->vencimento));
                $date2 = \Carbon\Carbon::createFromFormat('Y-m-d h:i:s', date($item->data_pagamento));
                $dias = $date2->diffInDays($date1);
                if ($date2 < $date1) { $dias='0' ; } } else { $dias=0; } @endphp <td width="5%" style="text-align: center">
                    {{ $dias }}
                    </td>


                    <td width="15%" style="text-align: center">
                        <span class="subtitulos cor-escura">
                            {{ 'R$ ' . number_format($item->valor_pago, 2, ',', '.') }}</span>
                    </td>

                    @php
                    $saldo = $item->valor - $item->valor_pago;
                    @endphp
                    <td width="15%" style="text-align: center">
                        <span class="subtitulos cor-escura">
                            {{ 'R$ ' . number_format($saldo, 2, ',', '.') }}</span>
                    </td>


                    @if ($item->status == 'ABERTA')
                    <td width="5%" style="text-align: center">
                        <span class=" badge bg-warning  cor-escura"> {{ $item->status }}</span>
                    </td>
                    @endIf

                    @if ($item->status == 'PAGA')
                    <td width="5%" style="text-align: center">

                        <span class="badge bg-success  cor-escura"> {{ $item->status }}</span>
                    </td>
                    @endIf
                    @if ($item->status == 'CANCELADA')
                    <td width="5%" style="text-align: center">

                        <span class="badge bg-danger  cor-escura"> {{ $item->status }}</span>
                    </td>
                    @endIf
                    @if ($item->status == null)
                    <td width="5%" style="text-align: center">

                        <span class="badge bg-success  cor-escura">NAO DEFINIDO</span>
                    </td>
                    @endIf




                    {{-- <td>
                                {{ date('d-m-Y', strtotime($item->data)) }}
                    </td> --}}

                    <td width="3%">
                        <div class=" d-flex align-items-center">


                            <a class="btn-imagens" href="/clientes/conta/parcela/edit/{{ $item->id }}/{{$item->cobranca_id }}">
                                <img src="{{ env('APP_LINK_IMAGES') }}baixa.svg" width="18PX" height="18PX"></a>
                            @if ($item->status == 'ABERTA')
                            <a class="btn-imagens" href="#">
                                <img src="{{ env('APP_LINK_IMAGES') }}cancel.svg" width="18PX" style="opacity: 50%" height="18PX"></a>
                            @endIf

                            @if ($item->status == 'PAGA')
                            <a class="btn-imagens" href="/clientes/conta/cancela/{{ $item->id }}/{{ request('id') }}">
                                <img src="{{ env('APP_LINK_IMAGES') }}cancel.svg" width="18PX" height="18PX" title="Cancelar parcela"></a>
                            @endIf
                            @if ($item->status != 'PAGA')
                            <a class="btn-imagens" onclick="setaDadosModal('window.location.href=\'/parcelas/delete/{{ $item->id }}\'')" data-bs-toggle="modal" data-bs-target="#delete-modal">
                                <img src="{{ env('APP_LINK_IMAGES') }}trash.svg" width="18px" height="18px">
                            </a>

                            @endif
                        </div>
                    </td>


            </tr>
            @endforeach

        </tbody>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: center"><b>{{ 'R$ ' . number_format($valor, 2, ',', '.') }}</b></td>
                <td></td>
                <td></td>
                <td style="text-align: center"><b>{{ 'R$ ' . number_format($pago, 2, ',', '.') }}</b></td>
                <td style="text-align: center"><b>{{ 'R$ ' . number_format($valor - $pago, 2, ',', '.') }}</b></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div style="text-align: right">
        <button class="btn btn-my-secondary" onclick="window.location.href='/clientes/conta/{{request('cobranca_id')}}'">
            Voltar
        </button>
    </div>

</div>

</div>
</div>
@include('layouts.paginacao')
@endsection