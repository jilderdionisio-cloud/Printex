<nav class="navbar navbar-expand-lg navbar-dark bg-white shadow-sm fixed-top py-3 border-bottom">
    <div class="container">
        <a class="navbar-brand fw-bold text-uppercase text-primary" href="{{ url('/') }}" style="color: #1e40af !important;">
            PRINTEX
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#printexNavbar"
                aria-controls="printexNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="printexNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                    <a class="nav-link" href="{{ url('/about') }}">Nosotros</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('cart.index') }}"
                   class="btn position-relative border-0 bg-transparent p-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="#1e40af" class="bi bi-cart3"
                         viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5m3.102 2 .84 4.5H13.5l1.2-6H3.102z"/>
                        <path d="M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4M5 13a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                    </svg>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-bg-danger"
                          data-cart-count>
                        0
                    </span>
                </a>

                <div class="dropdown">
                    <button class="btn btn-sm btn-primary dropdown-toggle d-flex align-items-center gap-2"
                            style="background-color:#1e40af;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="badge text-bg-light text-primary fw-semibold" data-profile-role>CLIENTE</span>
                        <span data-profile-name>Invitado</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Mi perfil</a></li>
                        <li><a class="dropdown-item" href="{{ route('orders.index') }}">Mis pedidos</a></li>
                        <li><a class="dropdown-item" href="{{ route('courses.my') }}">Mis cursos</a></li>
                        <li>
                            <a class="dropdown-item d-flex justify-content-between align-items-center"
                               href="{{ route('admin.dashboard') }}" data-role-guard="admin">
                                Panel admin
                                <span class="badge bg-primary">Admin</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <button class="dropdown-item" type="button" data-profile-toggle>
                                Cambiar perfil
                            </button>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<div style="height: 88px;"></div>
