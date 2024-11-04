<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
          body {
            background-color: #002148;
            color: #ffffff; /* Ajuste a cor do texto para melhor contraste */
        }
        .centered-content {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    </style>
</head>
<body class="">
    <div class="centered-content text-center">
        <!-- Link da logomarca -->
        <a href="/sistema">
                <img class="mb-4 mt-2" src="{{ env('APP_LINK_IMAGES') }}logo2.png" width="90%" style="object-fit: contain;z-index: 9; position: relative;margin-left:2%">
            </a>
 
        <!-- Botão para entrar no sistema -->
       
    </div>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
