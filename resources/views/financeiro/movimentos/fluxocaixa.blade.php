@extends('home')
@section('body')
    <div class="card">

        <div class="card-header titulo-form "><i class="fa fa-code-fork mx-1"></i>
            Fluxo Caixa
        </div>
        <div class="card-body ">

            <div class="row ">

                <div class="col-sm-12 ">

                    <form class="" action="{{ route('movimentos.pesquisa') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input name="fluxo" value="sim" hidden>
                            <div class="col-sm-3 mb-2"><label class="fw-bold subtitulos">Conta</label>

                                <select id="conta_id" name="conta_id" type="text" class="form-select mb-4">
                                
                                    @foreach ($contas as $item)
                                        <option value="{{ $item->id }}">{{ $item->conta }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3 mb-2"><label class="fw-bold subtitulos">Data Inicial</label>
                                <input id="dtini" class="form-control me-3" type="date" name="dtini" placeholder=""
                                    aria-label="date">
                            </div>
                            <div class="col-sm-3 "><label class="fw-bold subtitulos">Data Final</label>
                                <input id="dtini" class="form-control me-2" type="date" name="dtfim" placeholder=""
                                    aria-label="Search">
                            </div>
                            <div class="col-sm-3 texto-direita">
                                <button class="btn btn-my-primary form-button mt-4 " type="submit">Pesquisar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

            <div class="row mt-4 mx-1 p-2" style="background-color: gainsboro">
                @if ($de != null)
                    <div class="col-sm-4 p-2">
                        <span class="fw-bold">Movimentação De {{ date('d/m/Y', strtotime($de)) }} até
                            {{ date('d/m/Y', strtotime($ate)) }}</span>
                    </div>
                @endIf
                @if ($de == null)
                    <div class="col-sm-4 p-2">
                        <span class="fw-bold">Movimentação</span>
                    </div>
                @endIf



            </div>



            <div class="table-responsive mt-3">
                <table class="table table-striped table-light text-black table-hover">
                    <thead>
                        <tr>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dados->groupBy('fluxo_id') as $fluxo)
                            <tr>
                                <td colspan="3" class="fw-bold" style="font-size: 12px">{{ $fluxo[0]['fluxo']['fluxo'] }}
                                    |
                                    <span class="text-muted small">{{ $fluxo[0]['tipo'] }}</span>
                                </td>
                                @foreach ($fluxo as $item)
                            <tr>
                                <td width="8%">
                                    {{ date('d/m/Y', strtotime($item['data'])) }}
                                </td>
                                <td>
                                    {{ $item['descricao'] }}
                                </td>
                                <td class="texto-direita">
                                    R$ {{ number_format($item->valor, 2, ',', '.') }}
                                </td>
                        @endforeach
                        </tr>
                        <tr>
                            <td class="texto-direita fw-bold" colspan="3">
                                R$ {{ number_format($fluxo->sum('valor'), 2, ',', '.') }}
                            </td>
                        </tr>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="text-align: right">
                    <button class="btn btn-my-secondary" type="button"
                        onclick="window.location.href='/financeiro/movimentos'">Voltar</button>
                </div>
            </div>
        </div>
    </div>
       {{--  @include('layouts.paginacao') --}}
@endsection
