@include('layouts.header')
<!doctype html>
<html lang="en">

<body>
    <div class="wrapper d-flex align-items-stretch">
        @include('layouts.navbar')
        
        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            @include('layouts.flash-messages')


            @include('layouts.modal-delete')

            @include('layouts.modal-cancela')

            @include('layouts.modal-finaliza')


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
  


    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="{{ env('APP_LINK_JS') }}script.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


    <script>
        $(".menu-rapido").on('click', function(event) {
            $('#sidebar').toggleClass("active");
            $('#sidebar').show();


        });
        $(".menu-fecha").on('click', function(event) {
            $('#sidebar').removeClass("active");
        });
    </script>

<script>
    $(document).ready(function() {
        console.log('ok')

        setTimeout(function() {
            $("#msg").hide('fade');

        }, 3000);

    });
</script>




</body>

</html>
