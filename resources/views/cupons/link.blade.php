<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<html>

<body style="background-color:black">
    <div class=" mt-5 p-1">
        <div class="" style="width: 100%;">
            <img src="{{ env('APP_LINK_CUPOM') }}logo.svg" style="width: 100%; height:200px" class="card-img-top"
                alt="...">
            <div class="container">
                <div style="text-align: center; color:white">
                    <p>
                    <h5 class="">Minuto Wash</h5>
                    </p>
                </div>

             {{--    <p class="fw-bold text-light" style="text-align: center"> {{ $campanhas->titulo }}</p> --}}
                <p style="text-align: justify;">
              {{--   <p class="text-light" style="text-align: justify;">{{ $campanhas->descricao }}</p> --}}
                </p>
                <p style="text-align: center;font-size:16px;color:white">
                    Olá {{ $clientes->nome }}
                    <p style="text-align: center;font-size:16px;color:white;">   Estamos sentindo sua falta.
                    Voce ganhou R$ {{ number_format($campanhas->desconto, 2, ',', '.') }} de desconto
                    na lavagem geral ou na lavagem com cera de carnauba.
                   </p>


                 


                <div style="background-color: white;padding:10px;margin:auto">
                    <p style="text-align: center"> {{ $qrcode }}</p>
                </div>

                <p style="text-align: center;color:red;font-size:20px" class="fw-bold">CUPOM : {{ $cupom }} </p>
                <p style="text-align: center;font-size:16px;color:white">Apresente este cupom.</p>

                <p class="small" style="text-align: center;color:silver">Promoção valida até
                    {{ date('d/m/Y', strtotime($campanhas->limite)) }}</p>

            </div>
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
