
    <div class="card">
        <img src="https://minutowash.com.br/public/images/minutologo.svg" width="10%">
        <br>
        <br>
        <div style="font-size:50px;font-family: Arial, Helvetica, sans-serif">
            Lançamentos Caixa @if (isset($dados[0])) - Conta : {{$dados[0]->conta['conta']}} @endif
        </div>
        <br>
        <div class="card-body ">

           
            <div class="row mt-4 mx-1 p-2" style="background-color: silver;padding:50px">
                @if ($de != null)
                    <div class="col-sm-4">
                        <span style="font-size: 50px">MOVIMENTAÇÃO DE {{ date('d/m/Y', strtotime($de)) }} ATÉ
                            {{ date('d/m/Y', strtotime($ate)) }}</span>
                    </div>
                @endIf
                @if ($de == null)
                    <div class="col-sm-4">
                        <span style="font-size: 55px">MOVIMENTAÇÃO</span>
                    </div>
                @endIf

                <div class="col-sm-12 " style="text-align: right">
                    <span style="font-size: 50px">
                        @if  ($totalformaspagamento != null) 

                        @foreach ($totalformaspagamento as $key => $value)
                        @if ($value > 0)
                        <p>{{ $key }} - R$ {{ number_format($value, 2, ',', '.') }}</p>
                        @endIf   
                        @endforeach
                        @endIf
                </div>

                @if ($saldo < 0)
                    <div class="col-sm-12 " style="text-align: right">
                        <span class="fw-bold" style="color:red;font-size: 50px">
                            SALDO : R$ {{ number_format($saldo, 2, ',', '.') }}</span>
                    </div>
                @endIf
                @if ($saldo > 0)
                    <div class="col-sm-12 " style="text-align: right">
                        <span  style="color:black;font-size: 50px;font-weight: 600">
                            SALDO : R$ {{ number_format($saldo, 2, ',', '.') }}</span>
                    </div>
                @endIf
            </div>

<br>

            <div class="table-responsive mt-3">
                <table class="table table-striped table-light text-black table-hover">
                    <thead  style="font-size: 55px;font-weight: 600;">
                        <tr>
                            <th style="text-align: left">DATA</th>
                            <th style="text-align: left">TIPO</th>
                            <th style="text-align: left">DESCRICAO</th>
                            <th style="text-align: left">VALOR</th>
                            <th style="text-align: left">SALDO</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 55px">
                        @foreach ($dados as $item)
                            <tr>
                                <td width="280px">
                                    {{ date('d/m/Y', strtotime($item->data)) }}
                                </td>
                                @if ($item->tipo == 'DEBITO')
                                    <td style="text-align: left; " width="280px" nowrap>
                                        <span class="badge bg-danger ">{{ $item->tipo }}</span>
                                    </td>
                                @endIf
                                @if ($item->tipo == 'CREDITO')
                                    <td style="text-align: left; " width="280px" nowrap>
                                        <span class="badge bg-success ">{{ $item->tipo }}</span>
                                    </td>
                                @endIf
                             
                                <td width="2600px" >
                                    {{ $item->descricao }}
                                </td>
                                @if ($item->tipo == 'DEBITO')
                                    <td width="240px">
                                        <span style="color:red"> R$ {{ $item->valor }}</span>
                                    </td>
                                @endIf
                                @if ($item->tipo == 'CREDITO')
                                    <td width="280px">
                                        R$ {{ $item->valor }}
                                    </td>
                                @endIf
                                @if ($item->valor < 0)
                                    <td width="280px">
                                        <span class="fw-bold" style="color:red"> R$
                                            R$ {{ $item->valor }}
                                    </td>
                                @endif



                                @if ($item->saldo >= 0)
                                    <td width="350px">
                                        <span class="fw-bold" style="color:black"> R$
                                            {{ number_format($item->saldo, 2, ',', '.') }}</span>
                                    </td>
                                @endif

                                @if ($item->saldo < 0)
                                    <td width="350px">
                                        <span class="fw-bold" style="color:red"> R$
                                            {{ number_format($item->saldo, 2, ',', '.') }}</span>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                
            </div>
        </div>
    </div>

