@extends('layouts.app')

@section('title', 'Mi perfil | Printex')

@section('content')
    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <h2 class="fw-bold mb-1">Datos personales</h2>
                <p class="text-muted mb-4">Actualiza tu información de contacto para recibir notificaciones y pedidos.</p>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Revisa los campos marcados.</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-12">
                        <label class="form-label">Nombre completo</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Dirección</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $user->address ?? '') }}">
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" style="background-color:#1e40af;">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <h4 class="fw-bold mb-3">Cambiar contraseña</h4>
                <p class="text-muted small mb-4">Por seguridad, ingresa tu contraseña actual y confirma la nueva.</p>

                <form method="POST" action="{{ route('profile.password') }}" class="row g-3">
                    @csrf
                    @method('PUT')

                    <div class="col-12">
                        <label class="form-label">Contraseña actual</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Nueva contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-outline-secondary">
                            Actualizar contraseña
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-light rounded-4 p-4 mt-3">
                <h6 class="text-uppercase text-muted small mb-2">Preferencias</h6>
                <p class="mb-0 text-muted small">Pronto podrás gestionar métodos de pago y direcciones frecuentes desde aquí.</p>
            </div>
        </div>
    </div>
@endsection
