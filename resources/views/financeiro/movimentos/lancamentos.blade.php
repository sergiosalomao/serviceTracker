@extends('home')
@section('body')
    <div class="card">

        <div class="card-header titulo-form ">
            Lançamentos
        </div>
        <div class="card-body ">
            <form class="d-flex" action="{{ route('movimentos.pesquisa') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input name="lancamento" value="sim" hidden>

                <div class="col-sm-2 mb-2"><label class="fw-bold subtitulos">Conta</label>

                    <select id="conta_id" name="conta_id" type="text" class="form-select mb-4">
                       
                        @foreach ($contas as $item)
                            <option value="{{ $item->id }}">{{ $item->conta }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-2  mx-2"><label class="fw-bold subtitulos">Codigo</label>

                    <input class="form-control  " type="search" name="codigo" placeholder="Pesquisa por ID"
                        aria-label="Search">
                </div>
                <div class="col-sm-6"><label class="fw-bold subtitulos">Descricao</label>

                    <input class="form-control " type="search" name="pesquisa"
                        placeholder="Pesquisa por descricao" aria-label="Search">
                </div>
                <div class="col-sm-1 my-4 texto-direita">
                    <button class="btn btn-my-primary form-button" type="submit">Pesquisar</button>
                </div>
            </form>

            <div class="table-responsive mt-3">
                <table class="table table-striped table-light text-black table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>DATA</th>
                            <th style="text-align: center; ">TIPO</th>
                            <th>CENTRO</th>
                            <th>CONTA</th>
                            <th>FLUXO</th>
                            <th>COD.VENDA</th>
                            <th>DESCRICAO</th>
                            <th>VALOR</th>

                          
                                <th style="text-align: center">AÇÕES</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dados as $item)
                            <tr>
                                {{--   <td class="texto-centro" width="2%">
                                    <img src="{{env('APP_LINK_IMAGES')}}movimento.svg" width="20px" height="20px"></a>
                                </td> --}}
                                <td width="2%">
                                    {{ $item->id }}
                                </td>
                                <td width="10%">
                                    {{ date('d/m/Y', strtotime($item->data)) }}
                                </td>
                                @if ($item->tipo == 'DEBITO')
                                    <td style="text-align: center; " width="3%" >
                                        <span class="badge bg-danger ">{{ $item->tipo }}</span>
                                    </td>
                                @endIf
                                @if ($item->tipo == 'CREDITO')
                                    <td style="text-align: center; " width="3%" >
                                        <span class="badge bg-success ">{{ $item->tipo }}</span>
                                    </td>
                                @endIf
                                <td width="5%">
                                    {{ $item->centro['centro'] }}
                                </td>
                                <td width="5%">
                                    {{ $item->conta['conta'] }}
                                </td>
                                <td width="15%">
                                    {{ $item->fluxo['fluxo'] }}
                                </td>
                                <td width="5%" style="text-align: center; ">
                                    {{ $item->venda_id }}
                                </td>
                                <td width="35%">
                                    {{ $item->descricao }}
                                </td>
                                <td width="10%">
                                    R$ {{ $item->valor }}
                                </td>



                            {{-- permissao pra editar ou nao o movimento comentada por enquanto --}}
                               {{--  @if (auth()->user()->id != 5) --}}
                                    <td width="5%"  style="text-align: center; ">
                                        <div class=" d-flex align-items-center">
                                            <a class="btn-imagens" href="/financeiro/movimentos/edit/{{ $item->id }}">
                                                <img src="{{ env('APP_LINK_IMAGES') }}edit.png" width="18px"
                                                    height="18px"></a>

                                            <a class="btn-imagens"
                                                onclick="setaDadosModal('window.location.href=\'/financeiro/movimentos/delete/{{ $item->id }}\'')"
                                                data-bs-toggle="modal" data-bs-target="#delete-modal">
                                                <img src="{{ env('APP_LINK_IMAGES') }}trash.svg" width="18px"
                                                    height="18px">
                                            </a>
                                        </div>
                                    </td>
                              {{--   @endIf --}}
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
@endsection
