@extends('layouts.app')

@section('title', ($course->name ?? 'Curso') . ' | Printex')

@section('content')
    @php
        $isEnrolled = $isEnrolled ?? false;
    @endphp
    <div class="row g-4">
        <div class="col-12 col-lg-7">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <div class="rounded-3 mb-3 bg-light overflow-hidden" style="min-height: 320px;">
                    @php
                        $imagePath = $course->image ?? null;
                    @endphp
                    @if (!empty($imagePath))
                        @if (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://']))
                            <img src="{{ $imagePath }}" alt="{{ $course->name }}" class="w-100 h-100 object-fit-cover" style="max-height:480px;">
                        @else
                            <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $course->name }}" class="w-100 h-100 object-fit-cover" style="max-height:480px;">
                        @endif
                    @else
                        <div class="d-flex justify-content-center align-items-center text-muted" style="min-height:320px;">
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
                    {!! nl2br(e($course->description ?? 'Pronto agregaremos una descripción detallada para este curso.')) !!}
                </p>

                <div class="row g-3 my-4 row-cols-2 row-cols-md-4">
                    <div class="col">
                        <div class="p-3 border rounded-3 h-100">
                            <p class="text-muted small mb-1 text-uppercase">Duración (horas)</p>
                            <h5 class="mb-0">{{ $course->duration_hours ?? 'N/D' }}</h5>
                        </div>
                    </div>
                    @unless($isEnrolled)
                        <div class="col">
                            <div class="p-3 border rounded-3 h-100">
                                <p class="text-muted small mb-1 text-uppercase">Cupos disponibles</p>
                                <h5 class="mb-0">{{ $course->slots ?? '20' }}</h5>
                            </div>
                        </div>
                    @endunless
                    <div class="col">
                        <div class="p-3 border rounded-3 h-100">
                            <p class="text-muted small mb-1 text-uppercase">Instructor</p>
                            <h5 class="mb-0">{{ $course->instructor ?? 'Equipo Printex' }}</h5>
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-3 border rounded-3 h-100">
                            <p class="text-muted small mb-1 text-uppercase">Modalidad</p>
                            <h5 class="mb-0">{{ $course->modality ?? 'Presencial' }}</h5>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row gap-3">
                    @auth
                        @if ($isEnrolled)
                            <a href="{{ route('courses.my') }}" class="btn btn-lg btn-primary w-100 flex-fill"
                               style="background-color:#1e40af; border-color:#1e40af;">
                                Ir a Mis cursos
                            </a>
                            <a href="{{ route('courses.index') }}" class="btn btn-lg btn-outline-secondary flex-fill">
                                Volver al listado
                            </a>
                        @else
                            @include('courses.partials.purchase-modal', [
                                'course' => $course,
                                'buttonClass' => 'btn btn-lg btn-primary w-100 flex-fill',
                                'buttonLabel' => 'Adquirir video',
                            ])
                            <a href="{{ route('courses.index') }}" class="btn btn-lg btn-outline-secondary flex-fill">
                                Volver al listado
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-lg btn-primary w-100 flex-fill" style="background-color:#1e40af;">
                            Inicia sesión para adquirir video
                        </a>
                        <a href="{{ route('courses.index') }}" class="btn btn-lg btn-outline-secondary flex-fill">
                            Volver al listado
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5 d-flex flex-column gap-3 h-100">
            <div class="bg-white rounded-4 shadow-sm p-4 h-100">
                <h4 class="fw-bold mb-3">Lo que aprenderás</h4>
                <ul class="list-unstyled mb-4">
                    <li class="mb-3 d-flex">
                        <span class="text-primary me-3">&check;</span>
                        <span>Fundamentos del proceso de {{ strtolower($course->modality ?? 'sublimación') }}.</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <span class="text-primary me-3">&check;</span>
                        <span>Manejo adecuado de equipos y consumibles.</span>
                    </li>
                    <li class="mb-3 d-flex">
                        <span class="text-primary me-3">&check;</span>
                        <span>Buenas prácticas para optimizar la producción.</span>
                    </li>
                    <li class="d-flex">
                        <span class="text-primary me-3">&check;</span>
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

            <div id="asesor" class="bg-white rounded-4 shadow-sm p-4">
                <h5 class="fw-bold mb-3">¿Necesitas un asesor?</h5>
                <p class="text-muted mb-2">El servicio de asesoría está disponible solo para clientes que ya adquirieron el curso.</p>
                @auth
                    <a href="{{ route('courses.my') }}" class="btn btn-outline-primary w-100" style="color:#1e40af; border-color:#1e40af;">
                        Ir a "Mis cursos" para solicitar asesor
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary w-100" style="background-color:#1e40af;">Iniciar sesión</a>
                @endauth
            </div>
            <div class="bg-white rounded-4 shadow-sm p-4">
                <h6 class="fw-bold mb-2">Soporte y ayuda</h6>
                <p class="text-muted small mb-1">Resolvemos dudas sobre acceso al curso y problemas con el video.</p>
                <ul class="text-muted small mb-3 ps-3">
                    <li>Correo: soporte@printex.com</li>
                    <li>Teléfono: +51 999 888 777</li>
                    <li>Horario: Lun - Vie, 9:00 am - 6:00 pm</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- La inscripción se realizará automáticamente al comprar el curso. --}}
@endsection
