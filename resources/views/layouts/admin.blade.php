<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Printex | Admin')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --printex-primary: #1e40af;
            --printex-secondary: #991b1b;
            --printex-neutral: #6b7280;
            --printex-accent: #f59e0b;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #f3f4f6;
            color: #111827;
        }

        .admin-sidebar .nav-link {
            color: #4b5563;
        }

        .admin-sidebar .nav-link.active {
            background-color: rgba(30, 64, 175, 0.1);
            color: #1e40af;
            font-weight: 600;
        }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color:#1e40af;">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-uppercase" href="{{ route('admin.dashboard') }}">Printex Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminTopbar"
                    aria-controls="adminTopbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="adminTopbar">
                <ul class="navbar-nav align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Ver sitio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="badge text-bg-light text-primary fw-semibold">
                                {{ strtoupper(Auth::user()?->role ?? 'USER') }}
                            </span>
                            {{ Auth::user()?->name ?? 'Administrador' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Mi perfil</a></li>
                            <li><button class="dropdown-item" type="button">Cambiar perfil</button></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">Cerrar sesión</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="flex-grow-1 d-flex flex-column flex-lg-row">
        <nav class="admin-sidebar bg-white border-end p-3" style="width:260px;">
            @if (View::hasSection('sidebar'))
                @yield('sidebar')
            @else
                @php
                    $adminLinks = [
                        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'bi-speedometer2'],
                        ['label' => 'Productos', 'route' => 'admin.products.index', 'icon' => 'bi-box'],
                        ['label' => 'Proveedores', 'route' => 'admin.suppliers.index', 'icon' => 'bi-people'],
                        ['label' => 'Pedidos', 'route' => 'admin.orders.index', 'icon' => 'bi-bag-check'],
                        ['label' => 'Cursos', 'route' => 'admin.courses.index', 'icon' => 'bi-journal-text'],
                        ['label' => 'Inscripciones', 'route' => 'admin.enrollments.index', 'icon' => 'bi-person-lines-fill'],
                        ['label' => 'Solicitudes de asesoría', 'route' => 'admin.support-requests.index', 'icon' => 'bi-chat-dots'],
                    ];
                @endphp
                <h6 class="text-uppercase text-muted small mb-3">Menú principal</h6>
                <ul class="nav nav-pills flex-column gap-1">
                    @foreach ($adminLinks as $link)
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-2 @if (Route::is($link['route'])) active @endif"
                               href="{{ route($link['route']) }}">
                                <i class="bi {{ $link['icon'] }}"></i>
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </nav>

        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>
    </div>

    @include('components.footer')
    @include('components.chatbot-widget')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
