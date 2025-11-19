<nav class="navbar navbar-expand-lg printex-navbar fixed-top py-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-3 text-decoration-none" href="{{ url('/') }}">
            <span class="printex-logo-mark"></span>
            <div class="d-flex flex-column text-white text-uppercase">
                <span class="printex-brand-title fw-bold">PRINTEX</span>
                <span class="printex-brand-subtitle">ESTAMPADO PROFESIONAL</span>
            </div>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#printexNavbar"
                aria-controls="printexNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="printexNavbar">
            <div class="d-lg-flex align-items-center w-100 mt-3 mt-lg-0">
                <ul class="navbar-nav mx-lg-auto text-center align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('courses.index') }}">Cursos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contacto</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center justify-content-center justify-content-lg-end gap-3 ms-lg-4 mt-3 mt-lg-0">
                    <a href="{{ route('cart.index') }}"
                       class="btn printex-cart-btn position-relative d-inline-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#fff" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5m3.102 2 .84 4.5H13.5l1.2-6H3.102z"/>
                            <path d="M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4M5 13a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                        </svg>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                              data-cart-count>
                            0
                        </span>
                    </a>

                    @guest
                        <a href="{{ route('login') }}" class="btn printex-login-btn btn-sm">
                            Iniciar sesion
                        </a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-sm printex-account-btn dropdown-toggle d-flex align-items-center gap-2"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="badge bg-light text-primary fw-semibold text-uppercase">
                                    {{ auth()->user()->role ?? 'cliente' }}
                                </span>
                                <span class="text-white">{{ auth()->user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Mi perfil</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">Mis pedidos</a></li>
                                <li><a class="dropdown-item" href="{{ route('courses.my') }}">Mis cursos</a></li>
                                @if (auth()->user()->role === 'admin')
                                    <li>
                                        <a class="dropdown-item d-flex justify-content-between align-items-center"
                                           href="{{ route('admin.dashboard') }}">
                                            Panel admin
                                            <span class="badge bg-primary">Admin</span>
                                        </a>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">Cerrar sesion</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</nav>

<div style="height: 88px;"></div>
