@extends('layouts.admin')

@section('title', 'Solicitud #' . ($requestSupport->id ?? 'N/D') . ' | Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Solicitud #{{ $requestSupport->id }}</h1>
            <p class="text-muted mb-0">Creada el {{ $requestSupport->created_at?->format('d/m/Y H:i') }}</p>
        </div>
        <a href="{{ route('admin.support-requests.index') }}" class="btn btn-outline-secondary">Volver</a>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Detalle</h5>
                    <p class="mb-2"><strong>Usuario:</strong> {{ $requestSupport->user->name ?? 'N/D' }} ({{ $requestSupport->user->email ?? 'N/D' }})</p>
                    <p class="mb-2"><strong>Curso:</strong> {{ $requestSupport->course->name ?? 'N/D' }}</p>
                    <p class="mb-2"><strong>Estado:</strong> {{ $requestSupport->status }}</p>
                    <p class="mb-0"><strong>Mensaje:</strong><br>{{ $requestSupport->message }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Actualizar estado</h5>
                    <form method="POST" action="{{ route('admin.support-requests.update', $requestSupport->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Estado</label>
                            <select name="status" class="form-select">
                                @foreach (['Pendiente','En proceso','Resuelto'] as $status)
                                    <option value="{{ $status }}" @selected($requestSupport->status === $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" style="background-color:#1e40af;">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
