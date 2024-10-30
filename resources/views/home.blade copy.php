@include('layouts.header')
<!doctype html>
<html lang="en">

<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('layouts.navbar')
        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            <h2 class="mb-4"></h2>
            <div id="loading" class="spinner-border text-primary float-center" role="status">
                <span class="sr-only" style="color:red;font-size: 50px">carregando...</span>
            </div>

            @yield('body')
        </div>
    </div>
    <script src="{{ env('APP_LINK_JS') }}jquery.min.js"></script>
    <script src="{{ env('APP_LINK_JS') }}popper.js"></script>
    <script src="{{ env('APP_LINK_JS') }}bootstrap.min.js"></script>
    <script src="{{ env('APP_LINK_JS') }}main.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

</body>

</html>