ÃÂ¯ÃÂ»ÃÂ¿@extends('layouts.app')

@section('title', ($course->name ?? 'Curso') . ' | Printex')

@section('content')
    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <div class="ratio ratio-16x9 rounded-3 mb-3 bg-light">
                    @php
                        $imagePath = $course->image ?? null;
                    @endphp
                    @if (!empty($imagePath))
                        @if (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://']))
                            <img src="{{ $imagePath }}" alt="{{ $course->name }}" class="rounded-3 object-fit-cover" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $course->name }}" class="rounded-3 object-fit-cover" style="width: 100%; height: 100%; object-fit: cover;">
                        @endif
                    @else
                        <div class="d-flex justify-content-center align-items-center text-muted">
                            Imagen del curso
                        </div>
                    @endif
                </div>
                <span class="badge text-bg-primary mb-3" style="background-color:#1e40af !important;">
                    {{ $course->modality ?? 'Presencial' }}
                </span>
                <h1 class="fw-bold">{{ $course->name }}</h1>
                <p class="text-primary fs-3 fw-bold" style="color:#1e40af !important;">
                    S/ {{ number_format($course->price, 2) }}
                </p>
                <p class="text-muted">
                    {!! nl2br(e($course->description ?? 'Pronto agregaremos una descripciÃÆÃÂ³n detallada para este curso.')) !!}
                </p>

                <div class="row g-3 my-4">
                    <div class="col-12 col-md-6">
                        <div class="p-3 border rounded-3">
                            <p class="text-muted small mb-1 text-uppercase">DuraciÃÆÃÂ³n (horas)</p>
                            <h5 class="mb-0">{{ $course->duration_hours ?? 'N/D' }}</h5>
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
                    @auth
                        @include('courses.partials.purchase-modal', [
                            'course' => $course,
                            'buttonClass' => 'btn btn-lg btn-primary w-100 flex-fill',
                            'buttonLabel' => 'Adquirir video',
                        ])
                    @else
                        <a href="{{ route('login') }}" class="btn btn-lg btn-primary w-100 flex-fill" style="background-color:#1e40af;">
                            Inicia sesión para adquirir video
                        </a>
                    @endauth
                    <a href="{{ route('courses.index') }}" class="btn btn-lg btn-outline-secondary flex-fill">
                        Volver al listado
                    </a>
                </div>
            </div>
        </div>

                <div class="col-12 col-lg-5">
            <div class="bg-white rounded-4 shadow-sm p-4">
                <h4 class="fw-bold mb-3">Lo que aprender?s</h4>
                <ul class="list-unstyled mb-4">
                    <li class="mb-3 d-flex">
                        <span class="text-primary me-3">?</span>
                        <span>Fundamentos del proceso de {{ strtolower($course->modality ?? 'sublimaci?n') }}.</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <span class="text-primary me-3">?</span>
                        <span>Manejo adecuado de equipos y consumibles.</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <span class="text-primary me-3">?</span>
                        <span>Buenas pr?cticas para optimizar la producci?n.</span>
                    </li>
                    <li class="d-flex">
                        <span class="text-primary me-3">?</span>
                        <span>Tips comerciales para escalar tu negocio.</span>
                    </li>
                </ul>

                <div class="p-4 rounded-3 bg-light">
                    <h6 class="text-uppercase text-muted small mb-2">Incluye</h6>
                    <ul class="mb-0 text-muted small">
                        <li>Materiales y gu?as digitales.</li>
                        <li>Certificado de participaci?n.</li>
                        <li>Acceso a PrintBot para consultas.</li>
                        <li>Grupo privado para soporte.</li>
                    </ul>
                </div>
            </div>

            <div class="bg-white rounded-4 shadow-sm p-4 mt-3">
                <h5 class="fw-bold mb-3">?Necesitas un asesor?</h5>
                @auth
                    <form method="POST" action="{{ route('support-requests.store') }}">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <div class="mb-3">
                            <label class="form-label">Cu?ntanos tu duda</label>
                            <textarea name="message" class="form-control" rows="3" required placeholder="No entiendo este tema / Tengo problemas con el acceso..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-outline-primary w-100" style="color:#1e40af; border-color:#1e40af;">
                            Solicitar asesor
                        </button>
                    </form>
                @else
                    <p class="text-muted mb-2">Inicia sesi?n para solicitar ayuda de un asesor.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary w-100" style="background-color:#1e40af;">Iniciar sesi?n</a>
                @endauth
            </div>
        </div>
    </div>

    {{-- La inscripci?n se realizar? autom?ticamente al comprar el curso. --}}
@endsection
