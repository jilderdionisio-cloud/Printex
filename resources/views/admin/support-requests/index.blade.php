@extends('layouts.admin')

@section('title', 'Solicitudes de asesoría | Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Solicitudes de asesoría</h1>
            <p class="text-muted mb-0">Consulta y gestiona las solicitudes de los usuarios.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Curso</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $requestSupport)
                            <tr>
                                <td>{{ $requestSupport->id }}</td>
                                <td>{{ $requestSupport->user->name ?? 'Usuario' }}</td>
                                <td>{{ $requestSupport->course->name ?? 'N/D' }}</td>
                                <td>
                                    <span class="badge text-bg-secondary">{{ $requestSupport->status }}</span>
                                </td>
                                <td>{{ $requestSupport->created_at?->format('d/m/Y H:i') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.support-requests.show', $requestSupport->id) }}" class="btn btn-sm btn-outline-primary">
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No hay solicitudes registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($requests, 'links'))
                <div class="mt-3">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
