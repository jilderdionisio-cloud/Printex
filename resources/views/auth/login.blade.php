@extends('layouts.guest')

@section('title', 'Iniciar sesión | Printex')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <h1 class="fw-bold mb-3 text-center">Bienvenido</h1>
                <p class="text-muted text-center mb-4">Ingresa tu correo y contraseña para continuar.</p>

                <form method="POST" action="{{ route('login.store') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Recordarme</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" style="background-color:#1e40af;">
                        Iniciar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
