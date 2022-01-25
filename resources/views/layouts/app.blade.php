<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Restaurant JABE</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Restaurant JABE
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">{{ __('Inicio') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/shop') }}">{{ __('Tienda') }}</a>
                        </li>

                    @if(Auth::check())
                    @if(auth()->user()->hasRole('admin'))

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Gestionar inventario
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('category.index') }}">{{ __('Categorías') }}</a>
                            <a class="dropdown-item" href="{{ route('product.index') }}">{{ __('Productos') }}</a>
                        </div>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('employee.index') }}">{{ __('Empleados') }}</a>
                        </li>


                    @endif

                    @if(auth()->user()->hasRole('trabajador'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('order.index') }}">{{ __('Pedidos') }}</a>
                    </li>


                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Reportes
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('ventas_mes') }}">{{ __('Ventas por rango de fecha') }}</a>
                            <a class="dropdown-item" href="{{ route('ventas_dia') }}">{{ __('Ventas de hoy') }}</a>
                            <a class="dropdown-item" href="{{ route('venta_producto') }}">{{ __('Ventas por producto') }}</a>
                        </div>





                    @endif

                    @if(auth()->user()->hasRole('cliente'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clientorder.index') }}">{{ __('Mis pedidos') }}</a>
                    </li>


                    @endif

                    @endif
                </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle"
                               href="#" role="button" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <span class="badge badge-pill badge-dark">
                                    <i class="fa fa-shopping-cart"></i> {{ \Cart::getTotalQuantity()}}
                                </span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="width: 450px; padding: 0px; border-color: #9DA0A2">
                                <ul class="list-group" style="margin: 20px;">
                                    @include('partials.cart-drop')
                                </ul>

                            </div>

                            @if(Auth::check())
                            @if(auth()->user()->hasRole('trabajador'))
                            <li class="nav-item dropdown">
                                <a class="nav-link" data-toggle="dropdown" href="#">
                                  <i class="fas fa-bell"></i>
                                    @if (count(auth()->user()->unreadNotifications))
                                    <span class="badge badge-danger">{{ count(auth()->user()->unreadNotifications) }}</span>

                                    @endif
                                  </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                <span class="dropdown-header" >Notificaciones no leidas</span>
                                  @forelse (auth()->user()->unreadNotifications as $notification)
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-exclamation mr-2"></i>Pedido No. {{  $notification->data['code'] }}
                                    <span class="ml-3 pull-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                                  </a>
                                  @empty
                                    <span class="ml-3 pull-right text-muted text-sm">Sin notificaciones por leer </span>
                                  @endforelse

                                  <div class="dropdown-divider"></div>
                                  <span class="dropdown-header">Notificaciones Leidas</span>
                                  @forelse (auth()->user()->readNotifications as $notification)
                                  <a href="#" class="dropdown-item">
                                    <i class="fas fa-check mr-2"></i> Pedido No. {{ $notification->data['code'] }}
                                    <span class="ml-3 pull-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                                  </a>
                                  @empty
                                    <span class="ml-3 pull-right text-muted text-sm">Sin notificaciones leidas                      </span>
                                  @endforelse


                                  <div class="dropdown-divider"></div>
                                  <a href="{{ route('markAsRead') }}" class="dropdown-item dropdown-footer">Marcar todas como leídas</a>
                                  <div class="dropdown-divider"></div>
                                  <a href="{{ route('order.index') }}" class="dropdown-item dropdown-footer">Ir a ver pedidos</a>

                                </div>
                              </li>


                            @endif
                            @endif





                        </li>
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @if (isset($errors) && $errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session()->has('success'))
                    <div class="alert alert-success">
                        <ul>
                            @foreach (session()->get('success') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            @yield('content')
        </main>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
@stack('scripts')

</html>
