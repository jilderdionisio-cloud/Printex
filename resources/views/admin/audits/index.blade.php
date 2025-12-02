@extends('layouts.admin')

@section('title', 'Auditoría | Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Auditoría</h1>
            <p class="text-muted mb-0">Registro de acciones de usuarios.</p>
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
                            <th>Acción</th>
                            <th>Modelo</th>
                            <th>ID modelo</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($audits as $audit)
                            <tr>
                                <td>{{ $audit->id }}</td>
                                <td>{{ $audit->user->name ?? 'Sistema' }}</td>
                                <td>{{ $audit->action }}</td>
                                <td>{{ class_basename($audit->auditable_type) }}</td>
                                <td>{{ $audit->auditable_id }}</td>
                                <td>{{ $audit->created_at?->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Sin registros</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($audits, 'links'))
                <div class="mt-3">
                    {{ $audits->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
