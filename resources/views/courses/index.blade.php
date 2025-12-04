@extends('layouts.app')

@section('title', 'Cursos | Printex')

@section('content')
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
            <div>
                <p class="text-uppercase text-muted small mb-1">Formación especializada</p>
                <h2 class="fw-bold mb-0">Cursos disponibles</h2>
            </div>
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.courses.create') }}" class="btn btn-outline-primary btn-sm d-none d-lg-inline-flex"
                       style="color:#1e40af; border-color:#1e40af;">
                        Crear nuevo curso
                    </a>
                @endif
            @endauth
        </div>
    </div>

    <div class="row g-4">
        @forelse ($courses as $course)
            @php
                $inscrito = in_array($course->id, $enrolledIds ?? []);
            @endphp
            <div class="col-12 col-md-6 col-xl-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="ratio ratio-16x9 rounded-top bg-light">
                        @php
                            $imagePath = $course->image ?? null;
                        @endphp
                        @if (!empty($imagePath))
                            @if (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://']))
                                <img src="{{ $imagePath }}" alt="{{ $course->name }}" class="rounded-top object-fit-cover" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $course->name }}" class="rounded-top object-fit-cover" style="width: 100%; height: 100%; object-fit: cover;">
                            @endif
                        @else
                            <div class="d-flex justify-content-center align-items-center text-muted">
                                Imagen del curso
                            </div>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge text-bg-primary" style="background-color:#1e40af !important;">
                                {{ $course->modality ?? 'Presencial' }}
                            </span>
                            <small class="text-muted">Cupos: {{ $course->slots ?? 'N/D' }}</small>
                        </div>
                        <h4 class="card-title">{{ $course->name }}</h4>
                        <p class="text-muted mb-1"><strong>Duración (horas):</strong> {{ $course->duration_hours }}</p>
                        <p class="text-primary fw-bold mb-4" style="color:#1e40af !important;">
                            S/ {{ number_format($course->price, 2) }}
                        </p>
                        <p class="text-muted small flex-grow-1">
                            {{ Str::limit($course->description, 120) }}
                        </p>
                        <div class="mt-3 d-flex flex-column gap-2">
                            @if ($inscrito)
                                <button class="btn btn-primary w-100" style="background-color:#1e40af; border-color:#1e40af;" disabled>Inscrito</button>
                            @else
                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary"
                                   style="background-color:#1e40af;">Ver detalles</a>
                                @auth
                                    @include('courses.partials.purchase-modal', [
                                        'course' => $course,
                                        'buttonClass' => 'btn btn-outline-secondary w-100',
                                        'buttonLabel' => 'Adquirir video',
                                    ])
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">
                                        Inicia sesión para adquirir
                                    </a>
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <h4 class="fw-bold mb-2">No hay cursos disponibles.</h4>
                    <p class="text-muted mb-3">Pronto estaremos publicando nuevas fechas.</p>
                    <a href="{{ url('/') }}" class="btn btn-outline-primary" style="color:#1e40af; border-color:#1e40af;">
                        Volver al inicio
                    </a>
                </div>
            </div>
        @endforelse
    </div>
@endsection
