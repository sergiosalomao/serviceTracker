@extends('home')
@section('body')
<div class="card">
    <div class="card">
        @php
        $solicitacao = App\Models\Solicitacoes::find(request('id'));
        @endphp
        <div class="card-header">
            <div class="row ">
                <div class="col-sm-6 esquerda titulo fw-media uppercase">
                    Solicitações de Serviços | <span class=" fw-small-x ">Lista
                    </span>
                </div>
                <div class="col-sm-6 direita">
                    <span>{{$solicitacao['cliente']['nome']}} | <span>VENDA: <b>{{request('id')}}</b></span>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row p-3">
                <div class="col-6 texto-esquerda">
                    @if (($solicitacao->status == 'ABERTA') || ($solicitacao->status == 'AGUARDANDO APROVAÇÃO'))
                    <button class="btn btn-my-primary form-button " type="button" onclick="window.location.href='/carrinho/create/{{ request('id') }}'">Adicionar Serviço</button>
                    @endIf
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
                    <form class="" action="{{ route('carrinho.pesquisa') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input class="form-control me-2 mx-2" type="search" name="pesquisa" placeholder="Pesquisar por nome ou codigo" aria-label="Search">

            </form>
        </div>
    </div>
    --}}
    <div class="table-responsive mt-3">
        <table class="table table-striped table-light text-black table-hover">
            <thead>
                <tr>
                    <th class="" style="text-align: center">ID</th>
                    <th class="" style="text-align: center">CODIGO</th>
                    <th class="" style="text-align: left">SERVIÇO</th>
                    <th class="" style="text-align: center">TEMPO ESTIMADO(min)</th>
                    <th class="" style="text-align: center">QUANTIDADE</th>
                    <th class="" style="text-align: center">TEMPO ESTIMADO TOTAL</th>
                    <th class="" style="text-align: center">VALOR(UND)</th>
                    <th class="" style="text-align: center">VALOR TOTAL</th>
                    @if (($solicitacao->status == 'ABERTA') || ($solicitacao->status == 'AGUARDANDO APROVAÇÃO'))
                    <th class="" colspan="3" style="text-align: center">AÇÕES</th>
                    @endIf
                </tr>
            </thead>

            @php
            $total = 0;
            $status = null;
            $totalItens = 0;
            $tempo = 0;
            @endphp


            @foreach ($dados as $item)
            @php
            $totalItens+= $item->qtd;
            $tempo+= $item->qtd * $item['servico']['tempo_estimado'];
            @endphp
            <tr>
                <td width="2%" style="text-align: center">
                    <span class="table-subtitulos"> {{ $loop->index + 1 }}</span>
                </td>

                <td width="3%" style="text-align: center">
                    <span class="table-subtitulos fw-bold"> {{ $item['servico']['codigo'] }}</span>
                </td>

                <td width="30%" style="text-align: left">
                    <span class="table-subtitulos"> {{ $item['servico']['descricao'] }}</span>
                </td>
                @php
                $totalSeconds = $item['servico']['tempo_estimado'] * 60;
                $formattedTime = \Carbon\CarbonInterval::seconds($totalSeconds)->cascade();
                @endphp
                <td width="10%" style="text-align: center">
                    <span class="table-subtitulos fw-bold"> {{ $formattedTime->format('%H:%I') }}</span>
                </td>

                <td width="6%" style="text-align: center">
                    <span class="subtitulos cor-escura">
                        {{$item->qtd}}</span>
                </td>
                @php
                $totalSeconds = ($item['servico']['tempo_estimado'] * $item->qtd) * 60;
                $formattedTime = \Carbon\CarbonInterval::seconds($totalSeconds)->cascade();
                @endphp
                <td width="10%" style="text-align: center">
                    <span class="table-subtitulos fw-bold"> {{ $formattedTime->format('%H:%I') }}</span>
                </td>

                <td width="6%" style="text-align: center">
                    <span class="subtitulos cor-escura">
                        {{ 'R$ ' . number_format($item['servico']['valor'], 2, ',', '.') }}</span>
                </td>

                @if ($item->qtd >= 0)
                <td width="6%" style="text-align: center">
                    <span class="subtitulos cor-escura">
                        @php
                        $total = $total + $item['servico']['valor'] * $item->qtd;
                        @endphp
                        {{ 'R$ ' . number_format($item['servico']['valor'] * $item->qtd, 2, ',', '.') }}</span>
                </td>

                @endif


                @if (($solicitacao->status == 'ABERTA' && $total > 0) || ($solicitacao->status == 'AGUARDANDO APROVAÇÃO' && $total > 0))
                <td width="1%">
                    <div class=" d-flex align-items-center">
                        <a class="btn-imagens" onclick="setaDadosModal('window.location.href=\'/carrinho/delete/{{ $item->id }}/{{ request('id') }}\'')" data-toggle="modal" data-target="#delete-modal">
                            <img src="{{ env('APP_LINK_IMAGES') }}trash.svg" width="18PX" height="18PX">
                        </a>
                    </div>
                </td>
                @endIf
                @if ($solicitacao->status == 'ABERTA' && $total == 0)
                <td width="1%">

    </div>
    </td>
    @endIf



    </tr>

    @endforeach
    @php
    $formattedTime = \Carbon\CarbonInterval::minutes($tempo)->cascade();
    @endphp
    <tbody>

        <tr>
            <td></td>
            <td style="text-align: center"><b></b></td>
            <td></td>
            <td></td>
            <td style="text-align: center"><b>{{$totalItens}}</b></td>
            <td style="text-align: center"><b>{{ $formattedTime->format('%H:%I')}}</b></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
    </table>

    </table>
    @if ($total == 0)
    <p><b><span class="titulo cor-escura">O Carrinho está vazio.</span></b></p>
    @endIf
    <span class="titulo"> Total do Carrinho: <b>{{ 'R$ ' . number_format($total, 2, ',', '.') }}</b></span>

    <div style="text-align: right">
        <button class="btn btn-my-secondary" onclick="window.location.href='/solicitacoes'">
            Sair do Carrinho
        </button>
        <!--  @if ($solicitacao->status == 'ABERTA' && $total > 0)
                        <button class="btn btn-my-danger"
                            onclick="window.location.href='/carrinho/limpa/{{ $solicitacao->id }}'">
                            Limpar Carrinho
                        </button>                    @endIf -->
        @if (($solicitacao->status == 'AGUARDANDO APROVAÇÃO' && $total > 0))
        <button class="btn btn-success  " type="button" onclick="window.location.href='/solicitacoes/pagamento/{{ request('id') }}/{{ $total }}'">Proximo</button>
        @endIf
    </div>
</div>
</div>
</div>
@include('layouts.paginacao')
@endsection