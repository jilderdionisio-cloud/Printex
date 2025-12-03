@extends('layouts.admin')

@section('title', 'Proveedores | Admin')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Proveedores</h1>
            <p class="text-muted mb-0">Gestiona tus aliados comerciales.</p>
        </div>
        <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary" style="background-color:#1e40af;">
            <i class="bi bi-plus-lg me-1"></i> Nuevo proveedor
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
                            <th>RUC</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->id }}</td>
                                <td>{{ $supplier->name }}</td>
                                <td>{{ $supplier->ruc }}</td>
                                <td>{{ $supplier->email }}</td>
                                <td>{{ $supplier->phone }}</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="btn btn-outline-secondary">Editar</a>
                                        <form action="{{ route('admin.suppliers.destroy', $supplier) }}" method="POST"
                                              onsubmit="return confirm('¿Eliminar proveedor?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-danger" type="submit">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No hay proveedores registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($suppliers, 'links'))
                <div class="mt-3">
                    {{ $suppliers->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
