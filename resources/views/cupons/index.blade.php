@extends('home')
@section('body')
    <div class="card">

        <div class="card-header titulo-form ">
            Lista de Cupons da Campanha 
        </div>
        <div class="card-body ">

            <div class="table-responsive mt-3">
                <table class="table table-striped table-light text-black table-hover">
                    <thead>
                        <tr>
                            <th class="texto-centro">#</th>
                            <th class="texto-centro">CODIGO</th>
                            <th >CAMPANHA</th>
                            <th class="texto-centro">CLIENTE</th>
                            <th class="texto-centro">DESCONTO</th>
                            <th class="texto-centro">EXPIRA EM</th>
                            <th class="texto-centro">STATUS</th>

                            <th style="text-align: center">AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dados as $item)
                            <tr>
                                <td width="2%">
                                    <img src="{{env('APP_LINK_IMAGES')}}cupom.svg" width="35px" height="35px"></a>
                                </td>
                                <td width="10%" class="texto-centro">
                                    {{ $item->codigo }}
                                </td>
                                <td width="25%">
                                    {{ $item->campanha[0]->titulo }}
                                </td>
                             
                                @if ( $item->cliente_id )
                                <td width="30%" class="texto-centro">
                                    {{ $item->cliente[0]->nome }}
                                </td>
                               @endIf

                               @if ( $item->cliente_id  == null)
                               <td width="25%" class="texto-centro">
                                  Não Utilizado
                               </td>
                              @endIf

                                <td width="10%" class="texto-centro">
                                    {{ $item->desconto }}
                                </td>
                                <td width="15%" class="texto-centro">
                                    {{date( 'd-m-Y' , strtotime(  $item->limite ) )}}
                                </td>
                              
                                @if ( $item->status  == "ENTREGUE")
                               <td width="10%" class="texto-centro">
                                <span class="badge bg-info ">{{ $item->status }}</span>
                               </td>
                              @endIf

                              @if ( $item->status  == "DISPONIVEL")
                              <td width="10%" class="texto-centro">
                               <span class="badge bg-success ">{{ $item->status }}</span>
                              </td>
                             @endIf
                             @if ( $item->status  == "USADO")
                             <td width="10%" class="texto-centro">
                              <span class="badge bg-danger ">{{ $item->status }}</span>
                             </td>
                            @endIf

                                <td width="10%">
                                    <div class=" d-flex align-items-center">
                                        <a class="btn-imagens" href="/cupons/gera-qrcode/{{ $item->codigo }}">
                                            <img src="{{env('APP_LINK_IMAGES')}}qrcode.svg" width="18px" height="18px"></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="text-align: right">
                    <button class="btn btn-my-secondary" type="button" onclick="window.location.href='/campanhas'">Voltar</button>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.paginacao')
@endsection
