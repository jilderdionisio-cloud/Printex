@extends('layouts.admin')

@section('title', 'Inscripciones | Admin')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Inscripciones</h1>
            <p class="text-muted mb-0">Seguimiento de alumnos registrados en cursos.</p>
        </div>
        <form method="GET" class="d-flex gap-2">
            <select class="form-select form-select-sm" name="status">
                <option value="">Todos los estados</option>
                @foreach (($allowedStatuses ?? ['Activo', 'Pendiente', 'Completado', 'Cancelado']) as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                @endforeach
            </select>
            <button class="btn btn-outline-secondary btn-sm" type="submit">Filtrar</button>
        </form>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th>ID</th>
                            <th>Alumno</th>
                            <th>Curso</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Contacto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enrollments as $enrollment)
                            <tr>
                                <td>{{ $enrollment->id }}</td>
                                <td>{{ $enrollment->student_name ?? $enrollment->user->name }}</td>
                                <td>{{ $enrollment->course->name ?? 'Curso' }}</td>
                                <td>{{ $enrollment->created_at?->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge text-dark @class([
                                        'text-bg-success' => $enrollment->status === 'Activo',
                                        'text-bg-warning' => $enrollment->status === 'Pendiente',
                                        'text-bg-secondary' => $enrollment->status === 'Completado',
                                        'text-bg-danger' => $enrollment->status === 'Cancelado',
                                    ])">
                                        {{ $enrollment->status ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="small text-muted">{{ $enrollment->student_email ?? $enrollment->user->email }}</div>
                                    <div class="small">{{ $enrollment->student_phone ?? $enrollment->user->phone }}</div>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.enrollments.show', $enrollment->id) }}"
                                       class="btn btn-sm btn-primary">
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No hay inscripciones registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($enrollments, 'links'))
                <div class="mt-3">
                    {{ $enrollments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
