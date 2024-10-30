<nav id="sidebar" class="">

    <div class="custom-menu" style="index-z:-9">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa-solid fa-bars" style="margin-right: -70"></i>
            {{-- <span class="">Menu</span> --}}
        </button>
    </div>

    <br>
    <div class="p-4">
        <div class="texto-centro">
            <a href="/sistema">
                <img class="mb-4 mt-2" src="{{ env('APP_LINK_IMAGES') }}logo2.png" width="90%" style="object-fit: contain;z-index: 9; position: relative;margin-left:2%">
            </a>
        </div>
        <br>
        <br>


        @php
        $solicitacoes = App\Models\Solicitacoes::where('status','EM ANDAMENTO')->get();
        @endphp
        <ul class="list-unstyled components mb-3">
            <li class="">
                <a href="#acompanhamento" data-toggle="collapse" aria-expanded="false" class="">
                    <div class="d-flex">
                        <div class=""> <span class="fa-solid fa-suitcase mx-3"></span> <span class="fw-bold">Solicitações</span> <span class="badge bg-success fw-small">
                                {{ count($solicitacoes) }}</span>
                        </div>
                        <div style="margin-left:35%"> <span class="if-collapsed"><i class="fa-solid fa-circle-chevron-left"></i></span>
                            <span class="if-not-collapsed"><i class="fa-solid fa-circle-chevron-down"></i></span>
                        </div>
                    </div>
                </a>
            </li>
            <!-- Submenu content -->
            <div id='acompanhamento' class="collapse sidebar-submenu">
                <li class="mx-2">
                    <a href="/solicitacoes/create" class="menu-fecha"><span class="fa fa-user mx-3"></span>Nova Solicitação&#32;</a>
                </li>
                <li class="mx-2">
                    <a href="/solicitacoes" class="menu-fecha"><i class="fa fa-list mx-3"></i>Listar</a>
                </li>

            </div>
        </ul>

        @php
        $clientes = App\Models\Clientes::all();
        @endphp
        <ul class="list-unstyled components mb-3">
            <li class="">
                <a href="#clientes" data-toggle="collapse" aria-expanded="false" class="">
                    <div class="d-flex">
                        <div class=""> <span class="fa-solid fa-suitcase mx-3"></span> <span class="fw-bold">Clientes</span> <span class="badge bg-success fw-small">
                                {{ count($clientes) }}</span>
                        </div>
                        <div style="margin-left:40%"> <span class="if-collapsed"><i class="fa-solid fa-circle-chevron-left"></i></span>
                            <span class="if-not-collapsed"><i class="fa-solid fa-circle-chevron-down"></i></span>
                        </div>
                    </div>
                </a>
            </li>
            <!-- Submenu content -->
            <div id='clientes' class="collapse sidebar-submenu">
                <li class="mx-2">
                    <a href="/clientes/create" class="menu-fecha"><span class="fa fa-user mx-3"></span>Novo&#32;</a>
                </li>
                <li class="mx-2">
                    <a href="/clientes" class="menu-fecha"><i class="fa fa-list mx-3"></i>Listar</a>
                </li>
                <!-- <li class="mx-2">
                    <a href="/bonificacao" class="menu-fecha"><i class="fa fa-list mx-3"></i>Bonificações</a>
                </li> -->
            </div>
        </ul>

        





       




           
           
            <ul class="list-unstyled components mb-3">
                <li class="">
                    <a href="#campanhas" data-toggle="collapse" aria-expanded="false" class="">
                        <div class="d-flex">
                            <div class=""> <span class="fa-solid fa fa-bullhorn  mx-3"></span> <span class="fw-bold">Campanhas</span></div>
                            <div style="margin-left:52%"> <span class="if-collapsed"><i class="fa-solid fa-circle-chevron-left"></i></span>
                                <span class="if-not-collapsed"><i class="fa-solid fa-circle-chevron-down"></i></span>
                            </div>
                        </div>
                    </a>
                </li>
                <!-- Submenu content -->
                <div id='campanhas' class="collapse sidebar-submenu">
                    <li class="mx-2">
                        <a href="/campanhas/create" class="menu-fecha"><span class="fa fa-plus mx-3"></span>Nova
                            Campanha
                        </a>
                    </li>
                    <li class="mx-2">
                        <a href="/campanhas" class="menu-fecha"><i class="fa fa-search mx-3"></i>Minhas Campanhas</a>
                    </li>

                    @php

                    $clientes = App\Models\Clientes::all();
                    $contador = 0;

                    foreach ($clientes as $cliente) {
                    $venda = App\Models\Solicitacoes::where('cliente_id', '=', $cliente->id)
                    ->get()
                    ->last();

                    if (isset($venda)) {
                    $result = $venda->created_at->format('d-m-Y');
                    $dias = \Carbon\Carbon::createFromFormat('d-m-Y', Carbon\Carbon::now()->format('d-m-Y'))->diffInDays(\Carbon\Carbon::createFromFormat('d-m-Y', $result));

                    if ($dias > 35) {
                    $contador++;
                    }
                    }
                    }
                    // $contador = "000";
                    @endphp

                    <li class="mx-2">
                        <a href="/campanhas/envios">
                            <span class="fa fa-bell  mx-3"></span> <span class="fw-bold">Envio de Campanhas</span> <span class="badge bg-danger fw-small">{{ $contador }}</span>
                        </a>
                    </li>
                </div>
            </ul>
           

         
            <ul class="list-unstyled components mb-3">
                <li class="">
                    <a href="#financeiro" data-toggle="collapse" aria-expanded="false" class="">
                        <div class="d-flex">
                            <div class=""> <span class="fa-solid fa-suitcase mx-3"></span> <span class="fw-bold">Financeiro </span></div>
                            <div style="margin-left:51%"> <span class="if-collapsed"><i class="fa-solid fa-circle-chevron-left"></i></span>
                                <span class="if-not-collapsed"><i class="fa-solid fa-circle-chevron-down"></i></span>
                            </div>
                        </div>
                    </a>
                </li>
                <!-- Submenu content -->
                <div id='financeiro' class="collapse sidebar-submenu">
                    <li class="mx-2">
                        <a href="/financeiro/movimentos" class="menu-fecha"><span class="fa fa-external-link mx-3"></span>Lançamentos
                        </a>
                    </li>
                    <li class="mx-2">
                        <a href="/financeiro/formas-pagamento" class="menu-fecha"><i class="fa fa-credit-card mx-3"></i>Formas de Pagamento</a>
                    </li>
                    <li class="mx-2">
                        <a href="/financeiro/fluxos" class="menu-fecha"><i class="fa fa-code-fork mx-3"></i>Fluxos</a>
                    </li>
                    <li class="mx-2">
                        <a href="/financeiro/contas" class="menu-fecha"><i class="fa fa-home mx-3"></i>Contas</a>
                    </li>
                    <li class="mx-2">
                        <a href="/financeiro/centros" class="menu-fecha"><i class="fa fa-building mx-3"></i>Centros
                            de Custo</a>
                    </li>
                </div>
            </ul>
          

            <ul class="list-unstyled components mb-3">
                <li class="">
                    <a href="#cadastro" data-toggle="collapse" aria-expanded="false" class="">
                        <div class="d-flex">
                            <div class=""> <span class="fa-solid fa-suitcase mx-3"></span> <span class="fw-bold">Cadastros</span></div>
                            <div style="margin-left:51%"> <span class="if-collapsed"><i class="fa-solid fa-circle-chevron-left"></i></span>
                                <span class="if-not-collapsed"><i class="fa-solid fa-circle-chevron-down"></i></span>
                            </div>
                        </div>
                    </a>
                </li>
                <!-- Submenu content -->
                <div id='cadastro' class="collapse sidebar-submenu">
                    <li class="mx-2">
                        <a href="/servicos" class="menu-fecha"><span class="fa fa-archive mx-3"></span>Serviços</a>
                    </li>
                    <li class="mx-2">
                            <a href="/categorias" class="menu-fecha"><span class="fa fa-tags mx-3"></span>Categorias</a>
                        </li>
                    <!-- <li class="mx-2">
                            <a href="/fornecedores" class="menu-fecha"><span class="fa fa-male mx-3"></span>Fornecedores</a>
                        </li>
                        <li class="mx-2">
                            <a href="/produtos" class="menu-fecha"><span class="fa fa-archive mx-3"></span>Produtos</a>
                        </li>
                      
                        <li class="mx-2">
                            <a href="/marcas" class="menu-fecha"><span class="fa fa-tag mx-3"></span>Marcas</a>
                        </li> -->

                </div>
            </ul>


            <br>
            <br>



            <div class="footer">

                <p style="line-height: 5px" class="fw-bold cor-light">
                    <img class="" src="{{ env('APP_LINK_IMAGES') }}hdd.png" width="16px" style="">Recursos
                    Usados:
                </p>
                <p style="line-height: 2px" class="cor-light fw-small fw-light"> Pasta /storage:
                    {{ tamanhoPasta('../storage') }}
                </p>
                <p style="line-height: 2px" class="cor-light fw-small fw-light"> Pasta /public:
                    {{ tamanhoPasta('../public') }}
                </p>
                <p class="cor-light">

                    Sistema desenvolvido por <i class="icon-heart" aria-hidden="true"></i>
                    <a href="/" target="_blank">Sergio Salomão</a>
                </p>
            </div>

    </div>
</nav>