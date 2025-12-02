ÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¯ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â»ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â¿@extends('layouts.app')

@section('title', 'Mis cursos | Printex')

@section('content')
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
            <div>
                <p class="text-uppercase text-muted small mb-1">Aprendizaje continuo</p>
                <h2 class="fw-bold mb-0">Mis cursos</h2>
            </div>
            <a href="{{ route('courses.index') }}" class="btn btn-outline-primary btn-sm" style="color:#1e40af; border-color:#1e40af;">
                Explorar cursos
            </a>
        </div>
    </div>

    @if ($enrollments->isEmpty())
        <div class="bg-white rounded-4 shadow-sm p-5 text-center">
            <h4 class="fw-bold mb-2">AÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Âºn no te has inscrito</h4>
            <p class="text-muted mb-4">Empieza un nuevo curso y lleva tu negocio de estampado al siguiente nivel.</p>
            <a href="{{ route('courses.index') }}" class="btn btn-primary" style="background-color:#1e40af;">
                Ver cursos disponibles
            </a>
        </div>
    @else
        <div class="row g-4">
            @foreach ($enrollments as $enrollment)
                <div class="col-12 col-lg-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge text-bg-success" style="background-color:#1e40af !important;">
                                    {{ $enrollment->status ?? 'Activo' }}
                                </span>
                                <small class="text-muted">
                                    Inscrito el {{ $enrollment->created_at?->format('d/m/Y') }}
                                </small>
                            </div>
                            <h4>{{ $enrollment->course->name ?? 'Curso' }}</h4>
                            <p class="text-muted mb-1">
                                <strong>Duración:</strong> {{ ($enrollment->course->duration_hours ?? "N/D") . " horas" }}
                            </p>
                            <p class="text-muted">
                                <strong>Modalidad:</strong> {{ $enrollment->course->modality ?? 'Presencial' }}
                            </p>
                            <p class="text-muted flex-grow-1">
                                {{ Str::limit($enrollment->course->description ?? 'DescripciÃƒÆ’Ã†â€™Ãƒâ€ Ã¢â‚¬â„¢ÃƒÆ’Ã¢â‚¬Å¡Ãƒâ€šÃ‚Â³n no disponible.', 140) }}
                            </p>
                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('courses.show', $enrollment->course_id) }}" class="btn btn-primary flex-fill"
                                   style="background-color:#1e40af;">Ver curso</a>
                                <button class="btn btn-outline-secondary flex-fill" type="button">
                                    Descargar certificado
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if (method_exists($enrollments, 'links'))
            <div class="mt-4">
                {{ $enrollments->links() }}
            </div>
        @endif
    @endif
@endsection
