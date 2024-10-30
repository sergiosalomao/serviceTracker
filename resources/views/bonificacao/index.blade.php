@extends('home')
@section('body')

<div class="card">
    <div class="card">
        <div class="card-header">
            <div class="row ">
                <div class="col-sm-6 esquerda titulo fw-media uppercase">
                    Bonificação | <span class=" fw-small-x ">Lista
                    </span>
                </div>
                <div class="col-sm-6 direita">
                    <span>Ranking </b></span>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="table-responsive mt-3">
                <table class="table table-striped table-light text-black table-hover">
                    <thead>
                        <tr>
                            <th class="" style="text-align: center">RANKING</th>
                            <th class="" style="text-align: center">AVISOS</th>
                            <th class="" style="text-align: left">NOME</th>
                            <th class="" style="text-align: center">TOTAL PAGO</th>
                            <th class="" style="text-align: center">PONTOS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $temvenda = 'NAO';
                        @endphp
                        @foreach ($dados as $item)

                        @php
                        $atrasada = 'NAO';
                        $vendas = App\Models\Vendas::where('cliente_id',$item['cliente']['id'])->orderby('data_compra','desc')->first();
                        if (isset($vendas)){
                        $temvenda = 'SIM';
                        $dias = \Carbon\Carbon::createFromFormat('Y-m-d', Carbon\Carbon::now()->format('Y-m-d'))->diffInDays(
                        \Carbon\Carbon::createFromFormat('Y-m-d', $vendas->data_compra));

                        $parcelas = App\Models\Parcelas::where('cliente_id',$item['cliente']['id'])->where('status','ABERTA')->get();
                        foreach ($parcelas as $parcela){
                        if (Carbon\Carbon::now()->format('Y-m-d') > $parcela->vencimento)
                        $atrasada = 'SIM';
                        }
                        }
                        @endphp
                        <tr>
                            <td width="3%" style="text-align: center">
                                <span class="table-subtitulos cor-escura"> {{ $loop->index + 1 }}</span>
                            </td>

                           <!--se tiver mais de 30 dias sem comprar e nao tiver atrasado-->
                        @if (($temvenda == 'SIM') && ($dias > 30) && ($atrasada == 'NAO'))
                        <td width="3%" style="text-align: center;">
                            <img src="{{ env('APP_LINK_IMAGES') }}redflag.png" width="18px" height="18px" title="todos os pagamentos em dia, com mais de 30 dias sem comprar">
                        </td>
                        @endif
                        <!--se tiver mais de 30 dias sem comprar e tiver atrasado-->
                        @if (($temvenda == 'SIM') && ($dias > 30) && ($atrasada == 'SIM'))
                        <td width="3%" style="text-align: center;">
                            <img src="{{ env('APP_LINK_IMAGES') }}bad.png" width="18px" height="18px" title="Mais de 30 dias sem comprar e com pagamento atrasado">
                        </td>
                        @endif
                        <!--se tiver menos de 30 dias sem comprar e tiver atrasado-->
                        @if (($temvenda == 'SIM') && ($dias <= 30) && ($atrasada=='SIM' )) <td width="3%" style="text-align: center;">
                            <img src="{{ env('APP_LINK_IMAGES') }}bad.png" width="18px" height="18px" title="Cliente com pagamento atrasado">
                            </td>
                            @endif
                            <!--se tiver menos de 30 dias sem comprar e nao tiver atrasado-->
                            @if (($temvenda == 'SIM') && ($dias <= 30) && ($atrasada=='NAO' )) <td width="3%" style="text-align: center;">
                                <img src="{{ env('APP_LINK_IMAGES') }}ok.png" width="18px" height="18px" title="todos os pagamentos em dia">
                                </td>
                                @endif
                                @if (($temvenda == 'NAO')) <td width="3%" style="text-align: center;">
                                    <img src="{{ env('APP_LINK_IMAGES') }}ok.png" width="18px" height="18px" title="cliente nao tem compra">
                                </td>
                                @endif

                                    <td width="30%" style="text-align: left;">
                                        <span class="cor-escura  fw-bold"> {{ $item['cliente']['nome']}}</span>
                                    </td>

                                    <td width="10%" style="text-align: center">
                                        <span class="cor-escura"> {{ formatamoeda($item['total_pago'])}}</span>
                                    </td>
                                    <td width="10%" style="text-align: center">
                                        <span class="cor-escura"> {{ number_format($item['pontos'],0)}}</span>
                                    </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <div style="text-align: right">
                    <button class="btn btn-my-secondary" onclick="window.location.href='/sistema'">
                        Voltar
                    </button>
                </div>

            </div>

        </div>
    </div>


    @endsection