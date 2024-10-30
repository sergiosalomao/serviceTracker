<nav id="menu-rapido" class="navbar navbar-expand-lg navbar-light bg-light fw-media py-2 py-sm-0 mb-3" style="border-radius:5px;">
    <div class="container-fluid">
         <a id="btn-menu-rapido" class="navbar-brand menu-rapido" href="#{{-- {{ route('dashboard') }} --}}"> <img src="{{ env('APP_LINK_IMAGES') }}mini-logo.jpeg" width="40px"
                height="40px"></a>
         <span id="menu-rapido-titulo" class="titulo fw-large-x"> HomePass - Mobile</span></a>
        <button  class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                {{-- <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('index') }}">Home</a>
                </li> --}}
                <li class="nav-item ">
                   {{--  <div class="d-flex flex-column">
                        <div class="p-2">Flex item 1</div>
                        <div class="p-2">Flex item 2</div>
                        <div class="p-2">Flex item 3</div>
                      </div> --}}
                  
                    <a class="nav-link " href=""> <img
                            class="btn btn-redondo-light-xl" src="{{ env('APP_LINK_IMAGES') }}atendimento4.png" data-bs-toggle="tooltip"
                            title="Atendimentos"> <span class="titulos fw-large mobile mx-2 centro">Atendimentos</span></a>
                            
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href=""><img
                            class="btn btn-redondo-light-xl" src="{{ env('APP_LINK_IMAGES') }}pacientes2.png" data-bs-toggle="tooltip"
                            title="Pacientes"><span class="titulos fw-large mobile mx-2">Pacientes</span></a>
                </li > 

                <li class="nav-item ">
                    <a class="nav-link " href=""><img
                            class="btn btn-redondo-light-xl"src="{{ env('APP_LINK_IMAGES') }}profissional.png" data-bs-toggle="tooltip"
                            title="Profissionais"><span class="titulos fw-large mobile mx-2">Profissionais</span></a>
                </li>

              

            </ul>

        </div>

    </div>
    <a class="navbar-brand" href="#">

    </a>
    <button id="menu-rapido-sair" class="navbar-toggler mobile" type="button" data-toggle="collapse" data-target="#navbar-list-4"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    