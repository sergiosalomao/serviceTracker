<html>

<head>

    <style>
        @font-face {
            font-family: 'Elegance';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url("http://eclecticgeek.com/dompdf/fonts/Elegance.ttf") format("truetype");
        }


        body {
            font-family: Elegance, sans-serif;
            margin-left: -70px;
            margin-top: -95px;
            line-height: 25px;
        }

        #texto {
            font-size: 20px;
            max-width: 11%;
            font-weight: bolder;
        }

        #codigo {
            font-size: 22px;
            font-weight: 800;
            margin-top: -4px;
        }

        #valor {
            font-size: 24px;
            font-weight: bolder;
            max-width: 90%;
        }

        #qrcode {
            margin-top: -28px;
            margin-left: 180px;
        }

        #logo {
            margin-top: -2px;
            margin-left: 28px;
        }

        label {
            display: block;
            margin-top: 1px;
        }
    </style>
</head>

<body>
    <table width="450px">
        <tr>
            <td width="190px">
                <span id="texto">{{$dados->descricao}}</span>
            </td>
            <td width="190px">
                <img id="logo" src="images/ass.bmp" width="96%" style="object-fit: fill;">
            </td>
        </tr>
        <tr>
            <td width="190px"> <label id="valor">R$ {{$dados->valor_venda}}</label></td>
            <td width="190px">
                <div id="codigo" style="text-align: center;"> {{$dados->codigo}} </div> <img id="qrcode" src="images/etiqueta.svg">
            </td>
        </tr>
    </table>
</body>

</html>