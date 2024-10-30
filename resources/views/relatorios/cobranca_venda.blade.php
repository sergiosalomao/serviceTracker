<!DOCTYPE html>


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cobrança</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


  <link rel="stylesheet" href="css/styles-relatorios.css">

</head>
<style>
  body {
    font-size: 31px;
  }

  table td,
  table td * {
    vertical-align: top;
  }

  #footer {
    position: fixed;
    left: 20px;
    bottom: 0;
    text-align: center;
  }

  #footer .page:after {
    content: counter(page);
  }


  .no-page-break {
    page-break-inside: avoid;

  }

  .page-break {
    page-break-before: always;
  }

  @font-face {
    font-family: Hind;
    src: url(/public/fonts/HindMadurai-Regular.ttf);
  }


  :root {
    --font-smallx: 8px;
    --font-small: 10px;
    --font-media: 12px;
    --font-large: 14px;
    --font-largex: 17px;

    --cor-principal: #012442;
    --cor-principal-hover: #47C4F2;
    --cor-secundaria: white;
    --cor-secundaria-hover: #2b2a2a;
    --cor-destaque: rgb(255, 165, 0);
    --cor-danger: rgb(119, 16, 16);
    --cor-danger-hover: rgb(187, 45, 45);

    --cor-btn-light: #e7e5e5;
    --cor-btn-light-texto: #000000;
    --cor-btn-light-hover: white;

    --cor-btn-my-secondary: #525252;
    --cor-btn-my-econdary-texto: #EBEBEB;
    --cor-btn-my-secondary-hover: #222020;

    --cor-fundo-secondary: #47C4F2;
    --cor-fundo-claro: #EBEBEB;
    --cor-fundo-claro-x: #f5f5f5;
    --cor-fundo-media: #d3d3d3;
    --cor-fundo-escuro: #3E3E3F;

    --cor-texto-claro: white;
    --cor-texto-escuro: #3E3E3F;

    --cor-table-list: #d4f4ff;
    --cor-table-hover: #47C4F2;
    --cor-table-header: #012442;
  }

  html,
  body {
    font-family: Hind;
    font-size: var(--font-media);
    line-height: var(--font-media);
  }

  .borda {
    border-color: var(--cor-fundo-claro);
    border-style: solid !important;
    border-radius: 3px !important;
    border-width: 5px 1px 1px 1 !important;
  }

  .borda-sombra {
    border-color: var(--cor-fundo-claro) !important;
    border-style: solid !important;
    border-radius: 3px !important;
    border-width: 1px 1px 1px 1px !important;
    box-shadow: 1px 1px 1px 1px var(--cor-fundo-media) !important;
  }

  table.table tr th {
    background-color: var(--cor-table-header) !important;
    color: white !important;
  }

  .table {
    --bs-table-striped-bg: var(--cor-table-list) !important;
  }

  .table {
    --bs-table-hover-bg: var(--cor-table-hover) !important;
  }

  textarea {
    border-color: var(--cor-fundo-media);
    border-style: solid;
    border-radius: 0px;
    border-width: 0px 0px 1px 0 !important;
    -webkit-transition: 0.3s !important;
    transition: 0.3s !important;
    outline: none !important;
    font-size: var(--font-small) !important;
    text-transform: uppercase !important;
    background-color: transparent !important;
    text-indent: 1px;
  }

  textarea:focus {
    box-shadow: 0 0 1 0px var(--cor-principal) !important;
    border-color: var(--cor-principal) !important;
    border-style: solid !important;
    border-radius: 0px !important;
    border-width: 0px 0px 1px 0 !important;
    background-color: var(--cor-fundo-claro-x) !important;
  }


  td {
    /* white-space:nowrap; */
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .secondary {
    color: var(--cor-fundo-claro) !important;
    background-color: var(--cor-fundo-media) !important;
  }


  /* tabela  */

  .hiddenRow {
    padding: 0 !important;
  }

  .titulo-form {
    font-weight: bolder !important;
    padding-top: 15px;
    padding-bottom: 10px;
    color: var(--cor-fundo-claro) !important;
  }

  .titulo {
    font-weight: bolder !important;
  }

  .subtitulo {
    font-weight: 500 !important;
  }

  .item {
    font-weight: lighter !important;
  }

  .fw-small-x {
    font-size: var(--font-smallx) !important;
  }

  .fw-small {
    font-size: var(--font-small) !important;
  }

  .fw-media {
    font-size: var(--font-media) !important;
  }

  .fw-large {
    font-size: var(--font-large) !important;
  }

  .fw-large-x {
    font-size: var(--font-largex) !important;
  }

  .centro {
    text-align: center !important;
  }

  .centro-meio {
    text-align: start !important;

  }

  .direita {
    text-align: right !important;
  }

  .esquerda {
    text-align: left !important;
  }

  .bg-dark {
    background-color: var(--cor-fundo-escuro) !important;
  }

  .bg-media {
    background-color: var(--cor-fundo-media) !important;
  }

  .bg-light {
    background-color: var(--cor-fundo-claro) !important;
  }

  .bg-principal {
    background-color: var(--cor-principal) !important;
  }

  .bg-secundaria {
    background-color: var(--cor-secundaria) !important;
  }

  .bg-secundaria-1 {
    background-color: var(--cor-fundo-secondary) !important;
  }

  .bg-secundaria-2 {
    color: var(--cor-table-list) !important;
    background-color: var(--cor-table-header) !important;
  }

  .cor-principal {
    color: var(--cor-principal) !important;
  }

  .cor-secundaria {
    color: var(--cor-secundaria) !important;
  }

  .cor-dark {
    color: var(--cor-fundo-escuro) !important;
  }

  .cor-light {
    color: var(--cor-fundo-claro) !important;
  }

  .cor-media {
    color: var(--cor-fundo-media) !important;
  }

  .cor-header {
    color: var(--cor-table-header) !important;
  }

  .uppercase {
    text-transform: uppercase !important;
  }

  .line-small {
    line-height: var(--font-small) !important;
  }

  .line-small-x {
    line-height: var(--font-smallx) !important;
  }

  .line-media {
    line-height: var(--font-media) !important;
  }

  .line-large {
    line-height: var(--font-large) !important;
  }

  .line-large-x {
    line-height: var(--font-largex) !important;
  }

  .espacamento {
    margin-left: 5px !important;
    margin-right: 5px !important;
  }
</style>


<body style="font-size: 38px">
  <div class="no-page-break container-fluid">
    <table width="100%" class="p-2">
      <tr>
        <td>
          <img src="images/logoP.png" width="5%">
        </td>

        <td width="15%">
          <p style="line-height: 10px;"><span class="uppercase fw-bold ">DATA: {{$data}}</span><span></p>
          <span class="uppercase fw-bold ">HORA: {{$hora}} </span><span>
        </td>

      </tr>
    </table>
    <table width="100%" class="p-2">
      <tr>
        <td class="centro " width="100%">
          <span class="titulo uppercase"> Relatório de Cobranças</span>
        </td>
      </tr>
    </table>

    <div class="card mb-2">
      <div style="background-color: #CEBB99;height: 60px;">
        <span class="p-2 titulo">PARCELAS</span>
      </div>

    </div>




    <table class="table table-condensed table-striped">
      <thead>
        <th width="1%">

        </th>

        </tr>
      </thead>


      <tr>

        <td width="100%" class="titulo">
          @if ($extra['de']!= null)
          Periodo: {{$extra['de']}} ate {{$extra['ate']}} - {{$extra['status']}}
          @endif
          @if ($extra['de']== null)
          Listando todas as parcelas {{$extra['status']}}
          @endif
        </td>
      </tr>
      <tr>
        <td colspan="10">
          <table width="100%" class="p-2">
            <tr>
              <td class=" titulo">Nr.</td>
              <td class="centro titulo">VENDA</td>
              <td class="left titulo">CLIENTE</td>
              <td class="centro titulo">DATA VENCIMENTO</td>
              <td class="centro titulo">VALOR</td>
              <td class="centro titulo">PAGO</td>
              <td class="centro titulo">DT. PAGAMENTO</td>
              <td class="centro titulo">A PAGAR</td>

            </tr>
            <tbody>

              @foreach ($dados as $item)

              <tr>
                <td width="2%">
                  {{ $loop->index +1  }}
                </td>

                @php
                $cobranca = App\Models\Cobrancas::find($item->cobranca_id);
                $venda = $cobranca->id;
                @endphp
                <td class="centro" width="5%">
                  {{ $venda }}
                </td>
                <td class="left" width="25%">
                  {{ $item['cliente']['nome']  }}
                </td>
                <td class="centro" width="10%">
                  {{ formataData( $item->vencimento ) }}
                </td>

                <td class="centro" width="10%" nowrap>
                  {{ formataMoeda($item->valor) }}
                </td>
                <td class="centro" width="10%" nowrap>
                  {{ formataMoeda($item->valor_pago) }}
                </td>
                @if ($item->data_pagamento == null)
                <td class="centro" width="10%">

                </td>
                @endif
                @if ($item->data_pagamento != null)
                <td class="centro" width="10%">
                  {{ formataData( $item->data_pagamento ) }}
                </td>
                @endif

                <td width="10%" class="centro">
                  {{ formataMoeda($item->valor - $item->valor_pago) }}
                </td>


              </tr>
              @endforeach
            </tbody>
          </table>

        </td>

      </tr>

      <br>


  </div>


  <div style="background-color: #CEBB99; height: 60px;">
    <table width="100%">
      <tr style="background-color: #CEBB99; ">
        <td width="2%">

        </td>
        <td class="centro" width="5%">

        </td>
        <td class="left" width="25%">

        </td>
        <td class="centro" width="10%">

        </td>

        <td class="centro" width="10%" nowrap>
          {{ formataMoeda($extra['total']) }}
        </td>
        <td class="centro" width="10%" nowrap>
          {{ formataMoeda($extra['pago']) }}

        </td>
        <td class="centro" width="10%">

        <td class="centro" width="10%" nowrap>
          {{ formataMoeda($extra['total'] - $extra['pago']) }}
        </td>
      </tr>
    </table>
  </div>




</body>
<script type="text/php">
  if ( isset($pdf) ) {
            $x = 790;
            $y = 18;
            $text = "{PAGE_NUM} / {PAGE_COUNT}";
            $font = $fontMetrics->get_font("helvetica", "bold");
            $size = 8;
            $color = array(255,255,255,0);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>

</html>