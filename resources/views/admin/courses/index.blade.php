@extends('layouts.admin')

@section('title', 'Cursos | Admin')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Cursos</h1>
            <p class="text-muted mb-0">Gestiona la oferta formativa.</p>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary" style="background-color:#1e40af;">
            <i class="bi bi-plus-circle me-1"></i> Nuevo curso
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Modalidad</th>
                            <th>Duración (horas)</th>
                            <th>Cupos</th>
                            <th>Precio</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($courses as $course)
                            <tr>
                                <td>{{ $course->id }}</td>
                                <td>{{ $course->name }}</td>
                                <td>{{ $course->modality }}</td>
                                <td>{{ $course->duration_hours . " h" }}</td>
                                <td>{{ $course->slots }}</td>
                                <td>S/ {{ number_format($course->price, 2) }}</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-outline-secondary">Editar</a>
                                        <form action="{{ route('admin.courses.destroy', $course) }}" method="POST"
                                              onsubmit="return confirm('¿Eliminar curso?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger" type="submit">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No hay cursos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if (method_exists($courses, 'links'))
                <div class="mt-3">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

