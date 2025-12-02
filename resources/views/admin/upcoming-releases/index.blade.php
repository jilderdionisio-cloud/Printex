@extends('layouts.admin')

@section('title', 'Próximos lanzamientos | Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Próximos lanzamientos</h1>
            <p class="text-muted mb-0">Gestiona productos y cursos por lanzar.</p>
        </div>
        <a href="{{ route('admin.upcoming-releases.create') }}" class="btn btn-primary" style="background-color:#1e40af;">
            Nuevo lanzamiento
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="text-muted small text-uppercase">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Tipo</th>
                            <th>Fecha estimada</th>
                            <th>Estado</th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($releases as $release)
                            <tr>
                                <td>{{ $release->id }}</td>
                                <td>{{ $release->title }}</td>
                                <td>{{ ucfirst($release->type) }}</td>
                                <td>{{ $release->release_date?->format('d/m/Y') ?? 'N/D' }}</td>
                                <td>{{ ucfirst($release->status) }}</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.upcoming-releases.edit', $release) }}" class="btn btn-outline-secondary">Editar</a>
                                        <form method="POST" action="{{ route('admin.upcoming-releases.destroy', $release) }}"
                                              onsubmit="return confirm('¿Eliminar este lanzamiento?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No hay lanzamientos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($releases, 'links'))
                <div class="mt-3">
                    {{ $releases->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
