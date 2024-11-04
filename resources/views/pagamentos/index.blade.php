@extends('home')
@section('body')
<div class="card">
    <div class="card">
        @php
        
               
        
        $cobranca = App\Models\Cobranca::find(request('cobranca_id'));

        
        
        @endphp
        <div class="card-header">
            <div class="row ">
                <div class="col-sm-6 esquerda titulo fw-media uppercase">
                    PAGAMENTOS | <span class=" fw-small-x ">Lista
                    </span>
                </div>
                <div class="col-sm-6 direita">
                    <span>{{$cobranca['solicitacao']['cliente']['nome']}} | <span>COD. COBRANÇA: <b>{{request('cobranca_id')}}</b></span>
                </div>
            </div>
        </div>
        <div class="card-body ">
            <div class="row p-3">
                <div class="col-6 texto-esquerda">
                    @if (($cobranca->status == 'teste') || ($cobranca->status == 'teste'))
                    <button class="btn btn-my-primary form-button " type="button" onclick="window.location.href='/carrinho/create/{{ request('cobranca_id') }}'">Adicionar Pagamento</button>
                    @endIf
                </div>
                <div class="col-6 texto-direita">

                </div>
            </div>


            <div class="table-responsive mt-3">
                <table class="table table-striped table-light text-black table-hover">
                    <thead>
                        <tr>
                            <th class="" style="text-align: center">ID</th>
                            <th class="" style="text-align: center">COBRANCA</th>
                            <th class="" style="text-align: center">VENCIMENTO</th>
                            <th class="" style="text-align: left">PARCELA</th>
                            <th class="" style="text-align: center">VALOR</th>
                            <th class="" style="text-align: center">DATA PAGAMENTO</th>
                            <th class="" style="text-align: center">STATUS</th>
                            @if (($cobranca->status != 'PAGA') || ($cobranca->status == 'AGUARDANDO APROVAÇÃO'))
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

                    <tr>
                        <td width="2%" style="text-align: center">
                            <span class="table-subtitulos"> {{ $loop->index + 1 }}</span>
                        </td>

                        <td width="3%" style="text-align: center">
                            <span class="table-subtitulos fw-bold"> {{ $item->id }}</span>
                        </td>

                        <td width="10%" style="text-align: center">
                            <span class="table-subtitulos"> {{ date('d/m/Y', strtotime($item->data_vencimento)) }}</span>
                        </td>

                        <td width="12%" style="text-align: left">
                            <span class="table-subtitulos"> Parcela {{ $loop->index + 1 }} / {{$cobranca->parcelas}}</span>
                        </td>


                        <td width="10%" style="text-align: center">
                            <span class="subtitulos cor-escura">
                                {{ 'R$ ' . number_format($item->valor, 2, ',', '.') }}</span>
                        </td>
                        @if ($item->data_pagamento != '0000-00-00')
                        <td width="10%" style="text-align: center">
                            <span class="table-subtitulos"> {{ date('d/m/Y', strtotime($item->data_pagamento)) }}</span>
                        </td>
                        @endIf

                        @if ($item->data_pagamento == '0000-00-00')
                        <td width="5%" style="text-align: center">
                        -
                        </td>
                        @endIf



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


                    
                        <td width="1%">
                        <div class=" d-flex align-items-center">
                         
                            @if ($item->status != 'CANCELADA')
                            <a class="btn-imagens" onclick="setaDadosModalBaixaPagamento('window.location.href=\'/pagamentos/baixar/{{ $item->cobranca_id }}/{{ $item->id }}\'')" data-toggle="modal" data-target="#baixapagamento-modal">
                                <img src="{{ env('APP_LINK_IMAGES') }}pay.png" width="22PX" height="22PX" title="realiza a baixa do pagamento">
                            </a>
                            @endIf
                            
                            @if ($item->status != 'CANCELADA')
                            <a class="btn-imagens" onclick="setaDadosModalCancelaPagamento('window.location.href=\'/pagamentos/cancelar/{{ $item->cobranca_id }}/{{ $item->id }}/\'')" data-toggle="modal" data-target="#cancelapagamento-modal">
                                <img src="{{ env('APP_LINK_IMAGES') }}cancel.png" width="22PX" height="22PX" title="cancela o pagamento">
                            </a>
                            @endIf


                            <!-- @if ($item->status != 'CANCELADA')
                            <a class="btn-imagens" href="/solicitacoes/edit/{{ $item->id }}">
                                <img src="{{ env('APP_LINK_IMAGES') }}edit.png" width="18PX" height="18PX" title="edita a solicitacao"></a>
                            @endIf -->
                          



                            
                        </div>
                    </td>
                        
                    </div>



            </tr>

            @endforeach
           
          
            </table>

            </table>
          
            

            <div style="text-align: right">
                <button class="btn btn-my-secondary" onclick="window.location.href='/cobrancas'">
                    Fechar
                </button>


            </div>
        </div>
    </div>
</div>

@endsection