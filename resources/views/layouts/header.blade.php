<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>SistemaPDV - {{ env('APP_VER') }}</title>
    <meta name="description" content="Sistema Homepass">
    <meta name="keywords" content="Desenvolvedor - Sergio Salomão Leite Filho" />
    <meta name="author" content="comercialbonanca.com.br">
    <meta name="reply-to" content="comercialbonanca.com.br">
    <link rel="icon" href="{{ env('APP_LINK_IMAGES') }}favicon.ico" sizes="any" type="image/svg+xml">

    <meta property="og:image" content="{{ env('APP_URL') }}{{ env('APP_LINK_IMAGES') }}imagem_colocar.jpg">
    <meta property="og:image:type" content="image/jpg">
    <meta property="og:image:width" content="1280">
    <meta property="og:image:height" content="720">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    {{-- Styles --}}
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ env('APP_LINK_CSS') }}styles.css">

    {{-- Bootstrap --}}


    {{-- Jquery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="{{ env('APP_LINK_JS') }}/script.js"></script>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SistemaPDV {{ env('APP_VER') }}</title>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script defer src="{{ env('APP_LINK_JS') }}/fontawesome640/js/brands.js"></script>
    <script defer src="{{ env('APP_LINK_JS') }}/fontawesome640/js/solid.js"></script>
    <script defer src="{{ env('APP_LINK_JS') }}/fontawesome640/js/fontawesome.js"></script>


         <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
   

</head>

<div class="container">
    {{--    @include('layouts.flash-message') --}}
  
    @yield('content')
</div>


{{-- toastr js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />



<script>
    $(window).on('load', function() {
        $('#loading').hide();
    })


  
</script>


<script>
    $(document).ready(function() {
        $(".focus").focus();
    });
</script>
