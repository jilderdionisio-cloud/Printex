@extends('layouts.admin')

@section('title', 'Destacados | Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Productos y cursos destacados</h1>
            <p class="text-muted mb-0">Basado en compras e inscripciones.</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Top productos (más comprados)</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="text-muted small text-uppercase">
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-end">Compras</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topProducts as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td class="text-end">{{ $product->purchase_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-3">Sin datos</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Top cursos (más inscritos)</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="text-muted small text-uppercase">
                                <tr>
                                    <th>Curso</th>
                                    <th class="text-end">Inscripciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topCourses as $course)
                                    <tr>
                                        <td>{{ $course->name }}</td>
                                        <td class="text-end">{{ $course->enrollment_count }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-3">Sin datos</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
