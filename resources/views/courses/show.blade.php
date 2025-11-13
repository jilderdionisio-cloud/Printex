@extends('layouts.app')

@section('title', ($course->name ?? 'Curso') . ' | Printex')

@section('content')
    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <span class="badge text-bg-primary mb-3" style="background-color:#1e40af !important;">
                    {{ $course->modality ?? 'Presencial' }}
                </span>
                <h1 class="fw-bold">{{ $course->name }}</h1>
                <p class="text-primary fs-3 fw-bold" style="color:#1e40af !important;">
                    S/ {{ number_format($course->price, 2) }}
                </p>
                <p class="text-muted">
                    {!! nl2br(e($course->description ?? 'Pronto agregaremos una descripción detallada para este curso.')) !!}
                </p>

                <div class="row g-3 my-4">
                    <div class="col-12 col-md-6">
                        <div class="p-3 border rounded-3">
                            <p class="text-muted small mb-1 text-uppercase">Duración</p>
                            <h5 class="mb-0">{{ $course->duration ?? 'N/D' }}</h5>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="p-3 border rounded-3">
                            <p class="text-muted small mb-1 text-uppercase">Cupos disponibles</p>
                            <h5 class="mb-0">{{ $course->slots ?? '20' }}</h5>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="p-3 border rounded-3">
                            <p class="text-muted small mb-1 text-uppercase">Instructor</p>
                            <h5 class="mb-0">{{ $course->instructor ?? 'Equipo Printex' }}</h5>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="p-3 border rounded-3">
                            <p class="text-muted small mb-1 text-uppercase">Modalidad</p>
                            <h5 class="mb-0">{{ $course->modality ?? 'Presencial' }}</h5>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row gap-3">
                    <button class="btn btn-lg btn-primary flex-fill" style="background-color:#1e40af;"
                            data-bs-toggle="modal" data-bs-target="#enrollModal">
                        Inscribirse
                    </button>
                    <a href="{{ route('courses.index') }}" class="btn btn-lg btn-outline-secondary flex-fill">
                        Volver al listado
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <h4 class="fw-bold mb-3">Lo que aprenderás</h4>
                <ul class="list-unstyled mb-4">
                    <li class="mb-3 d-flex">
                        <span class="text-primary me-3">✔</span>
                        <span>Fundamentos del proceso de {{ strtolower($course->modality ?? 'sublimación') }}.</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <span class="text-primary me-3">✔</span>
                        <span>Manejo adecuado de equipos y consumibles.</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <span class="text-primary me-3">✔</span>
                        <span>Buenas prácticas para optimizar la producción.</span>
                    </li>
                    <li class="d-flex">
                        <span class="text-primary me-3">✔</span>
                        <span>Tips comerciales para escalar tu negocio.</span>
                    </li>
                </ul>

                <div class="p-4 rounded-3 bg-light">
                    <h6 class="text-uppercase text-muted small mb-2">Incluye</h6>
                    <ul class="mb-0 text-muted small">
                        <li>Materiales y guías digitales.</li>
                        <li>Certificado de participación.</li>
                        <li>Acceso a PrintBot para consultas.</li>
                        <li>Grupo privado para soporte.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de inscripción --}}
    <div class="modal fade" id="enrollModal" tabindex="-1" aria-labelledby="enrollModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="enrollModalLabel">Inscribirse en {{ $course->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form method="POST" action="{{ route('courses.enroll', $course->id) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nombre completo</label>
                            <input type="text" name="student_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" name="student_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="tel" name="student_phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <textarea name="student_address" rows="2" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" style="background-color:#1e40af;">Confirmar inscripción</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
