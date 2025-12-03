@extends('layouts.app')

@section('title', 'Mis cursos | Printex')

@section('content')
    <div class="container" style="max-width: 1180px;">
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
                <div>
                    <p class="text-uppercase text-muted small mb-1">Aprendizaje continuo</p>
                    <h2 class="fw-bold mb-0">Mis cursos</h2>
                </div>
                <a href="{{ route('courses.index') }}" class="btn btn-outline-primary btn-sm">
                    Explorar cursos
                </a>
            </div>
        </div>

        @if ($enrollments->isEmpty())
            <div class="bg-white rounded-4 shadow-sm p-5 text-center">
                <h4 class="fw-bold mb-2">Aún no te has inscrito</h4>
                <p class="text-muted mb-4">Empieza un nuevo curso y lleva tu negocio de estampado al siguiente nivel.</p>
                <a href="{{ route('courses.index') }}" class="btn btn-primary">
                    Ver cursos disponibles
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach ($enrollments as $enrollment)
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card h-100 border-0 shadow-sm rounded-4">
                            <div class="card-body d-flex flex-column" style="gap: 12px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge text-bg-primary px-3 py-2" style="background-color:#1e40af !important; border-radius:12px;">
                                        {{ $enrollment->status ?? 'Activo' }}
                                    </span>
                                    <small class="text-muted">Inscrito el {{ $enrollment->created_at?->format('d/m/Y') }}</small>
                                </div>
                                <h5 class="fw-bold mb-0">{{ $enrollment->course->name ?? 'Curso' }}</h5>
                                <p class="text-muted small mb-0">
                                    {{ Str::limit($enrollment->course->description ?? 'Descripción no disponible.', 110) }}
                                </p>
                                <div class="d-flex align-items-center justify-content-between text-muted small">
                                    <span>Duración: {{ ($enrollment->course->duration_hours ?? 'N/D') . ' h' }}</span>
                                    <span>Modalidad: {{ $enrollment->course->modality ?? 'Presencial' }}</span>
                                </div>

                                <div class="d-flex gap-2 mt-1">
                                    <button class="btn btn-primary flex-fill" data-bs-toggle="modal" data-bs-target="#videoModal-{{ $enrollment->id }}">
                                        Ver video
                                    </button>
                                    <a href="{{ route('courses.show', $enrollment->course_id) }}" class="btn btn-outline-secondary flex-fill">
                                        Ver curso
                                    </a>
                                </div>
                                <button class="btn btn-light border w-100" type="button" disabled>
                                    Descargar certificado
                                </button>

                                <form method="POST" action="{{ route('support-requests.store') }}" class="mt-auto p-3 bg-light rounded-3">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $enrollment->course_id }}">
                                    <label class="form-label text-muted small mb-1">Solicitar asesor (costo adicional)</label>
                                    <textarea name="message" class="form-control form-control-sm mb-2" rows="2" minlength="10" required
                                              placeholder="Ej: Necesito ayuda con el módulo 2..." style="border-radius:10px;"></textarea>
                                    <button type="submit" class="btn btn-outline-primary w-100 btn-sm">
                                        Solicitar asesor
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal de video simulado --}}
                    <div class="modal fade" id="videoModal-{{ $enrollment->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow-lg">
                                <div class="modal-header border-0 pb-0">
                                    <div>
                                        <p class="text-muted small mb-1">Vista previa</p>
                                        <h5 class="modal-title fw-bold mb-0">Video: {{ $enrollment->course->name ?? 'Curso' }}</h5>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body pt-3">
                                    <div class="ratio ratio-16x9 rounded-4 position-relative overflow-hidden"
                                         style="background: radial-gradient(circle at 25% 25%, #1e40af, #0b1430); box-shadow:0 12px 34px rgba(0,0,0,0.3);">
                                        <div class="position-absolute top-0 start-0 w-100 h-100"
                                             style="background: linear-gradient(135deg, rgba(255,255,255,0.08), rgba(30,64,175,0.22));"></div>
                                        <div class="d-flex align-items-center justify-content-center h-100 text-white position-relative">
                                            <div class="text-center px-4">
                                                <button type="button"
                                                        class="btn btn-light btn-lg rounded-circle mb-3"
                                                        style="width:80px; height:80px; box-shadow:0 18px 36px rgba(0,0,0,0.38);">
                                                    <span class="fs-3">&#9658;</span>
                                                </button>
                                                <p class="mb-0 fw-semibold">Presiona para ver el video</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <div class="text-start me-auto">
                                        <p class="small mb-0 text-muted">Asegúrate de tener buena conexión para verlo en HD.</p>
                                    </div>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
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
    </div>
@endsection
